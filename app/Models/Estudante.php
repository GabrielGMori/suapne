<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudante extends Model
{
    protected $fillable = [
        'nome',
        'curso',
        'periodo',
        'situacao',
    ];

    /** @use HasFactory<\Database\Factories\EstudanteFactory> */
    use HasFactory;
}
