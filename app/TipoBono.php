<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoBono extends Model
{
    public $table = "tipo_bonos";
    protected $visible = ['tipo_bono_nombre'];
}
