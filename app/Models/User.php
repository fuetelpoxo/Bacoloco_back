<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'avatar',
    ];

    protected $hidden = [
        'password',
    ];

    protected $appends = ['avatar_url'];

    public function getAvatarUrlAttribute()
    {
        if (empty($this->avatar)) {
            return null;
        }
        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            return $this->avatar;
        }

        return Storage::url($this->avatar);
    }

    public function lugares()
    {
        return $this->hasMany(Lugar::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }
}
