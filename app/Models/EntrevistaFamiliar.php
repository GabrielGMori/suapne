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
class EntrevistaFamiliar extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, AuditableTrait;
    use TemCamposAdicionais;

    public const TIPO_FORMULARIO = TipoFormularioEnum::ENTREVISTA_FAMILIAR;

    protected $table = 'entrevistas_familiar';

    protected $fillable = [
        'data',
        'responsavel_preenchimento',
        'campos',
        'campos_extras',
        'template_formulario_id',
        'estudante_id',
        'user_id',
    ];

    protected $casts = [
        'data' => 'date',
        'campos' => 'array',
        'campos_extras' => 'array',
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

    public function enviadoPor()
    {
        return $this->belongsTo(User::class, 'enviado_por_user_id');
    }

    public function getNomeAttribute() : string
    {
        return "Entrevista Familiar com responsáveis de {$this->estudante->nome}";
    }
}
