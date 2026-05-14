<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $table = 'valoraciones';
    protected $fillable = [
        'user_id',
        'lugar_id',
        'puntuacion',
        'comentario',
        'reportado',
    ];

    protected $casts = [
        'reportado' => 'boolean',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lugar()
    {
        return $this->belongsTo(Lugar::class);
    }

}
