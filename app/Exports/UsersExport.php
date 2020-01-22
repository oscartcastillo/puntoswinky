<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromView, ShouldAutoSize
{
	public function view(): View{

		$rol = Auth::User()->roles()->first()->name;
        switch ($rol) {
            case 'admin':
                $empleados = User::whereHas(
                    'roles', function($emp){
                        $emp->where('name', '!=', 'cliente');
                    }
                )->get();
            break;
            case 'super':
                $empleados = User::whereHas(
                    'roles', function($emp){
                        $emp->whereIn('name',  ['geren', 'cajero']);
                    }
                )->whereHas(
                    'perfil', function ($c) {
                        $c->where('ciudad_id', '=', Auth::user()->perfil->ciudad_id);
                    }
                )->get();
            break;
            case 'geren':
                $empleados = User::whereHas(
                    'roles', function($emp){
                        $emp->where('name', 'cajero');
                    }
                )->whereHas(
                    'perfil', function ($c) {
                        $c->where('ciudad_id', '=', Auth::user()->perfil->ciudad_id);
                    }
                )->get();
            break;
        }

		return view('admin.plantillas_export.export_excel', [
			'data' => $empleados
		]);
	}
}
