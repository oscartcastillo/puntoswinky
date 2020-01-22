<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientesExport implements FromView, ShouldAutoSize
{
	public function view(): View{

        $clientes = User::whereHas(
            'roles', function($clie){
                $clie->where('name', '=', 'cliente');
            }
        )->get();

		return view('admin.plantillas_export.clientes_export_excel', [
			'data' => $clientes
		]);
	}
}