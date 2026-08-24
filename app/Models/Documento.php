<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;

use App\Models\User;
use App\Models\Estudante;
class Documento extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $table = 'documentos';

    protected $fillable = [
        'tipo',
        'nome',
        'extensao',
        'path',
        'estudante_id',
        'user_id',
    ];

    protected $casts = [
        'tipo' => \App\Enums\TipoDocumentoEnum::class,
    ];

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getNomeArquivoAttribute(): string
    {
        return $this->nome . '.' . $this->extensao;
    }
}
