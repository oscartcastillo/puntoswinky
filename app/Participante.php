<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
	public $table = "participantes";

	protected $fillable = ['ciudad_id', 'empresa_id', 'promocion_id'];
    
    public function promocion(){
		return $this->belongsTo('App\Promocion');
	}
}