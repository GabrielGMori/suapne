<?php

namespace App\Models;

use App\Enums\StatusPlanoTrabalhoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoTrabalhoEstudante extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'planos_trabalho_estudante';

    protected $fillable = [
        'status',
        'campos',
        'estudante_id',
        'disciplina_id',
        'user_professor_id',
    ];

    protected $casts = [
        'campos' => 'array',
        'status' => \App\Enums\StatusPlanoTrabalhoEnum::class,
    ];

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
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

/*
public function getStatusAttribute()
    {
        return match($this->tipo) {
    StatusPlanoTrabalhoEnum::Pendente => "Registrou o estudante",
    StatusPlanoTrabalhoEnum::Aprovado => "Aprovado",
    StatusPlanoTrabalhoEnum::Aguardando_revisao => "Aguardando",
    StatusPlanoTrabalhoEnum::Devolvido => "Devolvido",
    default => "Não definido", 
    };
}*/
}

