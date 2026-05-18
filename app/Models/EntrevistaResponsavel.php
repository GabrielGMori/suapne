<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntrevistaResponsavel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'entrevistas_responsavel';

    protected $fillable = [
        'campos',
        'estudante_id',
    ];

    protected $casts = [
        'campos' => 'array',
    ];

    public function estudante()
    {
        return $this->belongsTo(Estudante::class, 'estudante_id');
    }
}
