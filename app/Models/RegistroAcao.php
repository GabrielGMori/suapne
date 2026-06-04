<?php

namespace App\Models;

use App\Enums\TipoRegistroAcaoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\Estudante;
class RegistroAcao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'registros_acao';

    protected $fillable = [
        'tipo',
        'estudante_id',
        'atributo',
        'atributo_valor',
        'atributo_antigo_valor',
        'atributo_tipo',
        'user_id',
    ];

    protected $casts = [
        'tipo' => TipoRegistroAcaoEnum::class,
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function estudante() : BelongsTo
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }

    public function getAcaoAttribute() : string
    {
        return match($this->tipo) {
            TipoRegistroAcaoEnum::CRIACAO_ESTUDANTE => "Registrou o estudante",
            TipoRegistroAcaoEnum::EDICAO_ESTUDANTE => "Editou o campo {$this->estudante->getReadableFillable($this->atributo)}",
            TipoRegistroAcaoEnum::EXCLUSAO_ESTUDANTE => "Excluiu o estudante",
        };
    }
}
