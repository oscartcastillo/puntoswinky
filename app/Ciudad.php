<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
	public $table = "ciudades";
    
    public function empresas(){
        return $this->hasMany('App\Empresa');
    }
}
