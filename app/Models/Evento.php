<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
        'lugar_id',
        'user_id',
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'precio',
        'activo',
    ];

    public function lugar()
    {
        return $this->belongsTo(Lugar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imagenes()
    {
        return $this->belongsToMany(Imagen::class);
    }

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class);
    }
}
