<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
	public $table = "empresas";
	
	public function ciudad(){
		return $this->belongsTo('App\Ciudad');
	}
}
