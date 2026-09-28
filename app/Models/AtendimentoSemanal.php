<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use App\Enums\TipoFormularioEnum;
use App\Models\Concerns\TemCamposAdicionais;

use App\Models\Estudante;
use App\Models\User;
class AtendimentoSemanal extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, AuditableTrait;
    use TemCamposAdicionais;

    public const TIPO_FORMULARIO = TipoFormularioEnum::ATENDIMENTO_SEMANAL;

    protected $table = 'atendimentos_semanais';

    protected $fillable = [
        'local',
        'campos',
        'campos_extras',
        'data',
        'estudante_id',
        'user_id',
    ];

    protected $casts = [
        'campos' => 'array',
        'campos_extras' => 'array',
        'data' => 'datetime',
    ];

    public function estudante() : BelongsTo
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getNomeAttribute() : string
    {
        return "Atendimento Semanal com {$this->estudante->nome} - {$this->data->format('d/m/Y')}";
    }
}
