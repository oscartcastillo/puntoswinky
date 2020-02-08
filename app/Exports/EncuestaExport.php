<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EncuestaExport implements FromView, ShouldAutoSize
{
	public $respuesta;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($respuesta)
    {
        $this->respuesta = $respuesta;
    }
	

	public function view(): View{

        /*$clientes = User::whereHas(
            'roles', function($clie){
                $clie->where('name', '=', 'cliente');
            }
        )->get();*/

		return view('admin.reportes.encuesta_excel', [
			'data' => $this->$respuesta
		]);
	}
}