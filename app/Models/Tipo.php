<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipos';

    protected $fillable = [
        'nombre',
    ];

    public function lugares()
    {
        return $this->hasMany(Lugar::class);
    }
}
