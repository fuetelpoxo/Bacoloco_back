<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Imagen extends Model
{
    protected $table = 'imagenes';
    protected $hidden = ['pivot'];
    protected $fillable = [
        'ruta',
        'tipo',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        if (empty($this->ruta)) {
            return '';
        }
        if (str_starts_with($this->ruta, 'http://') || str_starts_with($this->ruta, 'https://')) {
            return $this->ruta;
        }
        return Storage::url($this->ruta);
    }

    public function lugar()
    {
        return $this->belongsToMany(Lugar::class);
    }

    public function evento()
    {
        return $this->belongsToMany(Evento::class);
    }
}
