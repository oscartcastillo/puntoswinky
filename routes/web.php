<?php

Route::get('/', function () {
	if (Auth::check()) {
		return redirect()->route('inicio');
	}
    return redirect()->route('login');
});


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::resource('premios', 'PremiosController');
Route::resource('usuarios', 'UsuariosController');
Route::resource('clientes', 'ClientesController');
Route::resource('promociones', 'PromocionesController');
Route::resource('puntos', 'PuntosController');
Route::resource('menu', 'MenuController');
Route::resource('bonos', 'BonosController');
Route::resource('reportes', 'ReportesController');
Route::resource('config', 'ConfigController');
Route::resource('perfil', 'PerfilController');

Route::get('/inicio', 'UsuariosController@inicio')->name('inicio');
Route::get('/export_pdf','UsuariosController@export_pdf')->name('export_pdf');
Route::get('/export_excel', 'UsuariosController@export_excel')->name('export_excel');
Route::get('perfil/{ciudad}/empresa', 'UsuariosController@getEmpresa');

Route::get('/clientes_export_pdf','ClientesController@export_pdf')->name('clientes_export_pdf');
Route::get('/clientes_export_excel', 'ClientesController@export_excel')->name('clientes_export_excel');
Route::get('/reglas', 'ClientesController@reglas')->name('reglas');

Route::get('empresa_ajax', 'PromocionesController@getempresas');
Route::get('eventos', 'PromocionesController@get_eventos')->name('eventos');

Route::post('cancelacion/{id}','PuntosController@destroy');
Route::post('utilizar', 'PuntosController@utilizar')->name('utilizar');
Route::post('cambiar_premio/{id}', 'PuntosController@cambiar_premio')->name('cambiar_premio');
Route::get('cliente_ajax', 'PuntosController@getcliente');
Route::get('get_puntos/{id}', 'PuntosController@getDatos');
Route::get('estado_cuenta/{id}/{tipo}','PuntosController@export_pdf');
Route::get('valida_transaccion/{id}', 'PuntosController@valida_transaccion')->name('valida_transaccion');
Route::get('listado_puntos', 'PuntosController@listado_puntos')->name('listado_puntos');
//Route::get('estado_cuenta/{id}','PuntosController@export_pdf')->name('estado_cuenta_pdf');

Route::get('get_bonos/{id}', 'BonosController@getDatos');
Route::post('genera_bono', 'BonosController@generaBono')->name('genera_bono');

Route::get('listado_premios', 'PremiosController@listado_premios')->name('listado_premios');
Route::post('actualiza/{id}', 'PremiosController@update')->name('actualiza');
Route::post('/ajax_upload', 'PremiosController@store')->name('ajaxupload');


Route::get('transacciones/{id}', 'PuntosController@imprime')->name('transacciones');


Route::post('actualiza_empresa', 'ConfigController@update')->name('actualiza_empresa');
Route::post('actualiza_clasificacion', 'ConfigController@clasificaciones')->name('actualiza_clasificacion');


Route::post('reset_pass', 'PerfilController@pass')->name('reset_pass');


Route::get('genera_reporte', 'ReportesController@genera_reporte')->name('genera_reporte');

Route::view('calendario', 'admin.calendario', [
	'promociones' => App\Promocion::all()
	])->name('calendario');

Route::get('404',['as'=>'404','uses'=>'ErrorHandlerController@errorCode404']);
Route::get('405',['as'=>'405','uses'=>'ErrorHandlerController@errorCode405']);


?>