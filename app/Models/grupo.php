<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }
}