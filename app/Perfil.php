<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
	public $table = "perfiles";

    public function getFullNameAttribute() {
        return ucfirst($this->perfil_nombre) . ' ' . ucfirst($this->perfil_apellidos);
    }

	public function ciudad(){
        
        return $this->belongsTo('App\Ciudad');
    }

    public function empresa(){
        
        return $this->belongsTo('App\Empresa');
    }

    public function tipo_perfil(){
		
        return $this->belongsTo('App\TipoPerfil');
	}

    public function clasificacion(){
        
        return $this->belongsTo('App\Clasificacion');
    }

    public function transacciones(){
        return $this->hasMany('App\Transaccion', 'user_id', 'user_id');
    }

    /*public function sumtransacciones(){
        return $this->hasMany('App\Transaccion')
                    ->sum('transaccion_abono');
    }*/
}