<?php

namespace App\Models;

use App\Enums\StatusPlanoTrabalhoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Estudante;
use App\Models\User;
use App\Models\Disciplina;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use App\Enums\TipoFormularioEnum;
use App\Models\Concerns\TemCamposAdicionais;
class PlanoTrabalhoEstudante extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, AuditableTrait;
    use TemCamposAdicionais;

    public const TIPO_FORMULARIO = TipoFormularioEnum::PLANO_TRABALHO;

    protected $table = 'planos_trabalho_estudante';

    protected $fillable = [
        'status',
        'periodo_inicio',
        'periodo_fim',
        'estudante_id',
        'user_id',
        'user_professor_id',
        'disciplina_id',
        'campos',
        'campos_extras',
        'template_formulario_id',
    ];

    protected $casts = [
        'campos' => 'array',
        'campos_extras' => 'array',
        'periodo_inicio' => 'date',
        'periodo_fim' => 'date',
        'status' => StatusPlanoTrabalhoEnum::class,
    ];

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function templateFormulario(): BelongsTo
    {
        return $this->belongsTo(TemplateFormulario::class);
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
        return $this->estudante->curso;
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
        return "PTE de {$this->estudante->nome} - {$this->disciplina->nome} - {$this->periodo_inicio->year}";
    }
}

