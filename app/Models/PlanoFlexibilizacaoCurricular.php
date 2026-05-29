<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoFlexibilizacaoCurricular extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'planos_flexibilizacao_curricular';

    protected $fillable = [
        'periodo_inicio',
        'periodo_fim',
        'campos',
        'estudante_id',
    ];

    protected $casts = [
        'campos' => 'array',
        'periodo_inicio' => 'date',
        'periodo_fim' => 'date',
    ];

    public function getAnoAttribute(): string
    {
        return $this->periodo_inicio->format('Y');
    }

    public function getNomeEstudanteAttribute()
    {
        return $this->estudante->nome ?? 'Estudante Exemplo';
    }

    public function getCursoAttribute() : string
    {
        return $this->estudante->curso->nome;
    }

    public function estudante() : BelongsTo
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }
}
