<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Bono extends Model
{
    public $table = "bonos";

    public function tipo_bono(){
		return $this->belongsTo('App\TipoBono');
	}

	public function bono_detalle(){
		
		return $this->hasMany('App\BonoDetalle')
					->whereDate('created_at', '=', Carbon::today()->toDateString());
	}
	
	public function scopeActive($query){
        
        return $query->where('bono_estatus', 'activo');
    }
}
