<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disciplina extends Model
{
    /** @use HasFactory<\Database\Factories\DisciplinaFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'ementa',
        'curso_id',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
