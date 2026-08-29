<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\Curso;
use App\Models\User;
use App\Models\SolicitacaoRegistro;
class Disciplina extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\DisciplinaFactory> */
    use HasFactory, SoftDeletes, CascadeSoftDeletes, AuditableTrait;

    protected $fillable = [
        'nome',
        'ementa',
        'curso_periodo',
        'curso_id',
    ];

    protected $casts = [
        'curso_periodo' => 'integer',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function solicitacoesRegistro()
    {
        return $this->belongsToMany(SolicitacaoRegistro::class);
    }
}
