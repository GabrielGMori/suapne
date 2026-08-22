<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObservacaoEstudante extends Model
{
    use HasFactory;

    protected $table = 'observacoes_estudante';

    protected $fillable = [
        'observacao',
        'estudante_id',
        'user_id'
    ];

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
