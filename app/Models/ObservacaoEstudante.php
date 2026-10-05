<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Estudante;
use App\Models\User;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
class ObservacaoEstudante extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, AuditableTrait;

    protected $table = 'observacoes_estudante';

    protected $fillable = [
        'observacao',
        'estudante_id',
        'user_id'
    ];

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getNomeAttribute(): string
    {
        $estudante = $this->estudante;
        $nomeEstudante = $estudante?->nome ?? 'Estudante excluído';

        if ($estudante && $estudante->trashed()) {
            $nomeEstudante .= ' (Excluído)';
        }

        return "Observação sobre estudante {$nomeEstudante}";
    }
}
