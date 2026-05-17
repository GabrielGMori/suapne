<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'matricula',
        'ingresso_ano',
        'ingresso_periodo',
        'periodo',
        'email_pessoal',
        'email_academico',
        'data_nascimento',
        'telefone',
        'necessidades',
        'cpf',
        'situacao',
        'sexo',
        'etnia',
        'nacionalidade',
        'naturalidade',
        'nome_pai',
        'telefone_pai',
        'nome_mae',
        'telefone_mae',
        'nome_responsavel',
        'telefone_responsavel',
        'email_responsavel',
        'curso_id',
        'avatar',
    ];

    protected $casts = [
        'ingresso_ano' => 'integer',
        'ingresso_periodo' => 'integer',
        'periodo' => 'integer',
        'data_nascimento' => 'date',
        'situacao' => \App\Enums\SituacaoEstudanteEnum::class,
        'sexo' => \App\Enums\SexoEnum::class,
        'etnia' => \App\Enums\EtniaEnum::class,
    ];

    public function getAvatarAttribute($value)
    {
        return $value ?: ('https://api.dicebear.com/7.x/adventurer/svg?backgroundColor=b6e3f4&seed=' . urlencode($this->matricula ?? 'user'));
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function planosFlexibilizacaoCurricular()
    {
        return $this->hasMany(PlanoFlexibilizacaoCurricular::class, 'estudante_id');
    }

    public function planosTrabalho()
    {
        return $this->hasMany(PlanoTrabalhoEstudante::class, 'estudante_id');
    }

    public function atendimentosSemanais()
    {
        return $this->hasMany(AtendimentoSemanal::class, 'estudante_id');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'estudante_id');
    }

    public function entrevistasResponsavel()
    {
        return $this->hasMany(EntrevistaResponsavel::class, 'estudante_id');
    }

    public function observacoes()
    {
        return $this->hasMany(ObservacaoEstudante::class, 'estudante_id');
    }
}
