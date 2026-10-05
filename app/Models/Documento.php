<?php

namespace App\Models;

use App\Enums\TipoDocumentoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\User;
use App\Models\Estudante;
class Documento extends Model implements Auditable
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, AuditableTrait;

    protected $table = 'documentos';

    protected $fillable = [
        'tipo',
        'nome_arquivo',
        'extensao',
        'path',
        'estudante_id',
        'user_id',
    ];

    protected $casts = [
        'tipo' => TipoDocumentoEnum::class,
    ];

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullArquivoAttribute(): string
    {
        return $this->nome_arquivo . '.' . $this->extensao;
    }

    public function getNomeAttribute(): string
    {
        $tipo = $this->tipo !== TipoDocumentoEnum::DOCUMENTO ? ' ('.$this->tipo->label().') ' : '';
        return $this->fullArquivo . $tipo;
    }
}
