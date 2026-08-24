<?php

namespace App\Models;

use App\Enums\StatusPlanoTrabalhoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Estudante;
use App\Models\User;
use App\Models\Disciplina;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;
class PlanoTrabalhoEstudante extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $table = 'planos_trabalho_estudante';

    protected $fillable = [
        'status',
        'periodo_inicio',
        'periodo_fim',
        'campos',
        'estudante_id',
        'user_id',
        'disciplina_id',
        'user_professor_id',
    ];

    protected $casts = [
        'campos' => 'array',
        'periodo_inicio' => 'date',
        'periodo_fim' => 'date',
        'status' => StatusPlanoTrabalhoEnum::class,
    ];

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    public function getAnoAttribute()
    {
        return $this->created_at->format('Y');
    }

    public function getAnoCriacaoAttribute(): string
    {
        return $this->created_at->format('Y');
    }

    public function getNomeAttribute(): string
    {
        return "PTE de {$this->estudante->nome} - {$this->disciplina->nome} - {$this->periodo_inicio->year}";
    }
}

