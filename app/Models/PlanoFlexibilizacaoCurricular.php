<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Estudante;
use App\Models\User;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use App\Enums\TipoFormularioEnum;
use App\Models\Concerns\TemCamposAdicionais;
class PlanoFlexibilizacaoCurricular extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, AuditableTrait;
    use TemCamposAdicionais;

    public const TIPO_FORMULARIO = TipoFormularioEnum::PLANO_FLEXIBILIZACAO;

    protected $table = 'planos_flexibilizacao_curricular';

    protected $fillable = [
        'periodo_inicio',
        'periodo_fim',
        'campos',
        'campos_extras',
        'template_formulario_id',
        'estudante_id',
        'user_id',
    ];

    protected $casts = [
        'campos' => 'array',
        'campos_extras' => 'array',
        'periodo_inicio' => 'date',
        'periodo_fim' => 'date',
    ];


    public function getAnoAttribute(): string
    {
        return $this->periodo_inicio->format('Y');
    }

    public function estudante() : BelongsTo
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function templateFormulario(): BelongsTo
    {
        return $this->belongsTo(TemplateFormulario::class);
    }

    public function getNomeAttribute(): string
    {
        return "Plano de Flexibilização Curricular de {$this->estudante->nome} - {$this->periodo_inicio->year}";
    }

}
