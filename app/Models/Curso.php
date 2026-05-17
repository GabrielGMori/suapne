<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'quantidade_periodos',
    ];

    protected $casts = [
        'quantidade_periodos' => 'int',
    ];

    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class);
    }

    public function estudantes()
    {
        return $this->hasMany(Estudante::class);
    }

    public function __toString()
    {
        return (string) $this->nome;
    }
}
