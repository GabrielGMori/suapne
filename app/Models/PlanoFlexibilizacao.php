<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoFlexibilizacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'planos_flexibilizacao_curricular';

    protected $fillable = [
        'campos',
        'estudante_id',
    ];

    protected $casts = [
        'campos' => 'array',
    ];

    public function getNomeEstudanteAttribute()
    {
        return $this->estudante ? $this->estudante->nome : 'Estudante Exemplo';
    }

    public function getCursoAttribute()
    {
        return $this->estudante && $this->estudante->cursoRelation ? $this->estudante->cursoRelation->nome : 'Engenharia de Software';
    }

    public function getDisciplinaAttribute()
    {
        $campos = is_string($this->campos) ? json_decode($this->campos, true) : $this->campos;
        return $campos['disciplina'] ?? 'Português';
    }

    public function getAnoAttribute()
    {
        $campos = is_string($this->campos) ? json_decode($this->campos, true) : $this->campos;
        return $campos['ano'] ?? 2026;
    }

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }
}
