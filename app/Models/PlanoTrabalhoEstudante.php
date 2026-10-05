<?php

namespace App\Models;

use App\Enums\StatusPlanoTrabalhoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Estudante;
use App\Models\User;
use App\Models\Disciplina;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
class PlanoTrabalhoEstudante extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, AuditableTrait;

    protected $table = 'planos_trabalho_estudante';

    protected $fillable = [
        'status',
        'periodo_inicio',
        'periodo_fim',
        'estudante_id',
        'user_id',
        'user_professor_id',
        'disciplina_id',
        'campos'
    ];

    protected $casts = [
        'campos' => 'array',
        'periodo_inicio' => 'date',
        'periodo_fim' => 'date',
        'status' => StatusPlanoTrabalhoEnum::class,
    ];

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class, 'disciplina_id');
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'user_professor_id');

    }

    public function getCursoAttribute()
    {
        return optional($this->estudante)->curso;
    }

    public function getAnoAttribute()
    {
        return $this->created_at->format('Y');
    }

    public function getAnoCriacaoAttribute(): string
    {
        return $this->created_at->format('Y');
    }

    public function getNomeAttribute(): string
    {
        $estudante = $this->estudante;
        $nomeEstudante = $estudante?->nome ?? 'Estudante excluído';
        $nomeDisciplina = optional($this->disciplina)->nome ?? 'Disciplina excluída';

        if ($estudante && $estudante->trashed()) {
            $nomeEstudante .= ' (Excluído)';
        }

        return "PTE de {$nomeEstudante} - {$nomeDisciplina} - {$this->periodo_inicio->year}";
    }
}

