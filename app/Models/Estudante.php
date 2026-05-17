<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'curso',
        'periodo',
        'situacao',
        'avatar',
        'matricula',
        'email_pessoal',
        'email_academico',
        'cpf',
    ];

    protected $casts = [
        'periodo' => 'integer',
    ];
}
