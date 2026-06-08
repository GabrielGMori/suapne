<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntrevistaFamiliar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'entrevistas_familiar';

    protected $fillable = [
        'data',
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
}
