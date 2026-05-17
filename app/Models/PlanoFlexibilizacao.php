<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanoFlexibilizacao extends Model
{
    protected $fillable = [
        'nomeEstudante',
        'disciplina',
        'curso',
        'ano',
    ];

    protected $casts = [
        'ano' => 'integer',
    ];

    /** @use HasFactory<\Database\Factories\PlanoFlexibilizacaoFactory> */
    use HasFactory;
}
