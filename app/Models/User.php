<?php

namespace App\Models;

use App\Models\Disciplina;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPassword;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable, CanResetPassword
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, CascadeSoftDeletes, AuditableTrait, CanResetPasswordTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nome',
        'email',
        'password',
        'role',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role' => \App\Enums\RoleEnum::class,
        ];
    }
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class);
    }

    public function planosTrabalhoProfessor(): HasMany
    {
        return $this->hasMany(PlanoTrabalhoEstudante::class, 'user_professor_id');
    }

    public function getNameAttribute()
    {
        return $this->nome;
    }

    public function sendPasswordResetNotification($token): void
    {
        $url = url()->route('password.reset', ['token' => $token]);
        $this->notify(new ResetPassword($url));
    }
}
