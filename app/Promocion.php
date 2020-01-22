<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    public $table = "promociones";

    public function participantes(){
        return $this->hasMany('App\Participante');
    }
}
