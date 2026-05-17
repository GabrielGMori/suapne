<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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

    public function getAvatarAttribute($value)
    {
        return $value ?: ('https://api.dicebear.com/7.x/adventurer/svg?backgroundColor=b6e3f4&seed=' . urlencode($this->email ?? 'user'));
    }

    public function getNameAttribute()
    {
        return $this->nome;
    }

    public function getFuncaoAttribute()
    {
        return $this->role instanceof \App\Enums\RoleEnum ? $this->role->label() : $this->role;
    }
}
