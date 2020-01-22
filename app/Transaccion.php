<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    public $table = "transacciones";

    public function perfil(){
        return $this->belongsTo('App\Perfil', 'user_id', 'user_id');
    }

    public function cliente(){
        return $this->belongsTo('App\Perfil', 'vendedor_id', 'id');
    }

    public function premio(){
		return $this->belongsTo('App\Premio');
	}

	public function empresa(){
        return $this->belongsTo('App\Empresa');
    }

    public function promocion(){
        return $this->belongsTo('App\Promocion');
    }

}
