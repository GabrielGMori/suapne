<?php

namespace App\Models;

use App\Enums\TipoRegistroAcaoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }

    public function getAcaoAttribute()
    {
        return match($this->tipo) {
            TipoRegistroAcaoEnum::Criacao => "Registrou o estudante",
            TipoRegistroAcaoEnum::Edicao => "Editou o campo $this->atributo",
            TipoRegistroAcaoEnum::Exclusao => "Excluiu o estudante",
        };
    }
}
