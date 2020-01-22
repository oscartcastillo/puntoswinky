@extends('admin.plantilla')
	@section('content')
	<style>
		.responsive-table li {
			border-radius: 3px;
			padding: 10px;
			display: flex;
			justify-content: space-between;
			margin-bottom: 10px;
		}
		.responsive-table{
			padding: 0px;
		}
		.responsive-table .table-header {
			background-color: #95a5a6;
			font-size: 14px;
			text-transform: uppercase;
			letter-spacing: 0.03em;
		}
		.responsive-table .table-row {
			background-color: #ffffff;
			box-shadow: 0px 0px 9px 0px rgba(0, 0, 0, 0.1);
		}
		.dataTables_length {
			margin-top:20px;
		}
		div.dt-buttons {
			position: relative;
			float: left;
			margin-left: 20px;
			margin-top:12px;
			font-size:16px;
			font-weight:bold;
		}
		.dataTables_filter {
			margin-top:20px;
		}
		table.dataTable tbody tr {
			background-color: rgba(255, 255, 255, 0.05);
		}
	</style>
		<main class="app-content">
			<div class="app-title">
				<div>
					<h1>Indicadores <span class="fecha-t" id="reporte_fecha">{{ date('Y-m-d') }}</span></h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">
					<div class="row" id="datos_reporte">
						<div class="form-group col-md-3">
							<label for="reporte">Tipo de Reporte</label>
							<select name="tipo" id="tipo" class="custom-select">
								<option value="">Seleccione Reporte</option>
								<option value="1">Clientes por categoria</option>
								<option value="2">Clientes por clasificación</option>
								<option value="3">Clientes sin tarjeta</option>
								<option value="4">Transacciones del dia</option>
								<option value="5">Registros por Vendedor</option>
								<option value="6">Puntos por Cliente</option>
								
							</select>
							<p class="errorTipo text-center alert alert-danger" style="display: none;"></p>
						</div>
						<div id="div-categoria" class="form-group col-md-3" style="display: none;">
							<label for="reporte">Categoria: </label>
							<select name="categoria" id="categoria" class="custom-select">
								<option value="">Seleccione Categoria</option>
								<option value="2">Ex Alumno</option>
								<option value="3">Docente</option>
								<option value="4">Alumno</option>
								<option value="5">Externo</option>
								<option value="6">Administrativo</option>
							</select>
							<p class="errorTipo text-center alert alert-danger" style="display: none;"></p>
						</div>

						<div id="div-clasificacion" class="form-group col-md-3" style="display: none;">
							<label for="reporte">Clasificacion: </label>
							<select name="clasificacion" id="clasificacion" class="custom-select">
								<option value="">Seleccione Clasificación</option>
								<option value="1">Basica</option>
								<option value="2">Media</option>
								<option value="3">Premium</option>
							</select>
							<p class="errorTipo text-center alert alert-danger" style="display: none;"></p>
						</div>
						
						<div id="div-personal" class="form-group col-md-3" style="display: none">
							<label for="personal">Personal: </label>
							<select name="personal" id="personal" class="custom-select">
								<option value="">Personal</option>
								@foreach($data['empleados'] as $empleado)
									<option value="{{$empleado->id}}">{{ $empleado->perfil->full_name }}</option>
								@endforeach
							</select>
							<p class="errorPersonal text-center alert alert-danger" style="display: none;"></p>
						</div>
						<div id="div-inicio" class="form-group col-md-3" style="display: none;">
							<label for="inicio">Fecha Inicial</label>
							<input type="date" name="inicio" id="inicio" class="form-control">
							<p class="errorInicio text-center alert alert-danger" style="display: none;"></p>
						</div>
						<div id="div-fin" class="form-group col-md-3" style="display: none;">
							<label for="fin">Fecha Fin</label>
							<input type="date" name="fin" id="fin" class="form-control">
							<p class="errorFin text-center alert alert-danger" style="display: none;"></p>
						</div>
						<div class="form-group offset-md-9 col-md-3 text-right" style="display: none;">
							<button type="button" class="btn btn-success" id="consultar">Consultar</button>
						</div>
					</div>
					<div class="row">
						<div id="div-body" class="col-md-12">
							<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead id="thead">
								</thead>
								<tbody id="tbody">
								</tbody>
							</table>
						</div>
					</div>
				</div>


				<div class="col-12 col-md-3">
					<ul class="responsive-table">
						<li class="table-header">
							<div class="col-8">Indicador</div>
							<div class="col-4 text-right">Total</div>
						</li>
						<li class="table-row">
							<div class="col-8">Clientes con Tarjeta</div>
							<div class="col-4 text-right">{{ $data['clientes_totales'] }}</div>
						</li>
						<li class="table-row">
							<div class="col-8">Clientes sin Tarjeta</div>
							<div class="col-4 text-right">{{ $data['clientes_sin_tarjeta'] }}</div>
						</li>
						<li class="table-row">
							<div class="col-8">Clientes nuevos (Hoy)</div>
							<div class="col-4 text-right">{{ $data['clientes_dia'] }}</div>
						</li>
						<li class="table-row">
							<div class="col-8">Clientes nuevos (Semana)</div>
							<div class="col-4 text-right">{{ $data['clientes_semana'] }}</div>
						</li>
						<li class="table-row">
							<div class="col-8">Clientes nuevos (Mes)</div>
							<div class="col-4 text-right">{{ $data['clientes_mes'] }}</div>
						</li>
						<li class="table-row">
							<div class="col-8">Clientes Deshabilitados</div>
							<div class="col-4 text-right">{{ $data['clientes_deshabilitados'] }}</div>
						</li>
						<li class="table-row">
							<div class="col-8">Puntos Acumulados (Mes)</div>
							<div class="col-4 text-right">{{ $data['puntos_utilizar'] }}</div>
						</li>
						<li class="table-row">
							<div class="col-8">Puntos Utilizados (Mes)</div>
							<div class="col-4 text-right">{{ $data['puntos_utilizados_mes'] * -1 }}</div>
						</li>
						<li class="table-row">
							<div class="col-8">Puntos Canjeables</div>
							<div class="col-4 text-right">{{ $data['puntos_acumulados']}}</div>
						</li>
					</ul>
				</div>
			</div>
		</main>
	@endsection