<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    protected $fillable = [
        'nombre',
    ];
    protected $hidden = ['pivot'];

    public function lugares()
    {
        return $this->belongsToMany(Lugar::class);
    }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class);
    }
}
