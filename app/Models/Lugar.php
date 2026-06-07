<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    protected $fillable = [
        'tipo_id',
        'user_id',
        'nombre',
        'descripcion',
        'latitud',
        'longitud',
        'municipio',
        'direccion',
        'activo',
    ];

    protected $table = 'lugares';

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

    public function imagenes()
    {
        return $this->belongsToMany(Imagen::class);
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class);
    }
}
