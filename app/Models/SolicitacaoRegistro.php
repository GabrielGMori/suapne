<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Disciplina;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class SolicitacaoRegistro extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $table = 'solicitacoes_registro';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'role',
        'status',
        'campos',
        'user_aprovador_id',
        'user_criado_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'campos' => 'array',
            'role' => \App\Enums\RoleEnum::class,
            'status' => \App\Enums\StatusSolicitacaoRegistroEnum::class,
        ];
    }

    public function aprovador()
    {
        return $this->belongsTo(User::class, 'user_aprovador_id');
    }

    public function usuarioCriado()
    {
        return $this->belongsTo(User::class, 'user_criado_id');
    }

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class);
    }

    public function toUserAttributes() : array
    {
        return [
            'nome' => $this->nome,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'disciplinas' => $this->disciplinas ?? null,
        ];
    }

    public function createUser(): User
    {
        $data = $this->toUserAttributes();
        $newUser = User::create($data);
        $newUser->disciplinas()->sync($data['disciplinas']);

        return $newUser;
    }
}
