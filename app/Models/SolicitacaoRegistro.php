<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitacaoRegistro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'solicitacoes_registro';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'role',
        'status',
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
}
