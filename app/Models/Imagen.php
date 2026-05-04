<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';
    protected $hidden = ['pivot'];
    protected $fillable = [
        'ruta',
        'tipo',
    ];

    public function lugar()
    {
        return $this->belongsToMany(Lugar::class);
    }

    public function evento()
    {
        return $this->belongsToMany(Evento::class);
    }
}
