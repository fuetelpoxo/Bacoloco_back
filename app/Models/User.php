<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
