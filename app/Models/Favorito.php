<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{

    protected $fillable = [
        'user_id',
        'lugar_id',
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
