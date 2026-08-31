<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Estudante;
use App\Models\User;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
class EntrevistaFamiliar extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, AuditableTrait;

    protected $table = 'entrevistas_familiar';

    protected $fillable = [
        'data',
        'responsavel_preenchimento',
        'campos',
        'estudante_id',
        'user_id',
    ];

    protected $casts = [
        'data' => 'date',
        'campos' => 'array',
    ];

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function enviadoPor()
    {
        return $this->belongsTo(User::class, 'enviado_por_user_id');
    }

    public function getNomeAttribute() : string
    {
        return "Entrevista Familiar com responsáveis de {$this->estudante->nome}";
    }
}
