<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonoDetalle extends Model
{
    public $table = "bono_detalles";

    public function empresa(){
        return $this->belongsTo('App\Empresa');
    }
}
