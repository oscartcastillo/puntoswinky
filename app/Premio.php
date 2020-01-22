<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Premio extends Model
{
    public $table = "premios";

    public function transacciones(){
        return $this->hasMany('App\Transaccion');
    }

    public function empresa(){
        return $this->belongsTo('App\Empresa');
    }

    public function clasificacion(){
        return $this->belongsTo('App\Clasificacion');
    }
}
