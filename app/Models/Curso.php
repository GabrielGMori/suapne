<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;

use App\Models\Disciplina;
use App\Models\Estudante;
class Curso extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

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
