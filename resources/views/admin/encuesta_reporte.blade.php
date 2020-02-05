@extends('admin.plantilla')
	@section('content')
		<main class="app-content">
			<div class="app-title">
				<div>
					<h1>Encuesta de Satisfacción Winky</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 bg-white text-center p-3">
					<h4>Reporte Encuesta</h4>
				</div>
				<div id="encuesta" class="col-lg-2" style="background-color: white; padding: 1%;">
					<div class="form-group">
						<label for="fechauno">Fecha Inicial:</label>
						<input type="date" id="fecha1" class="form-control">
						<p class="errorFecha1 text-center alert alert-danger" style="display: none;">El campo de Fecha inicial no debe de esta vacio</p>
					</div>
					<div class="form-group">
						<label for="fechados">Fecha Final:</label>
						<input type="date" id="fecha2" class="form-control">
						<p class="errorFecha2 text-center alert alert-danger" style="display: none;">El campo de fecha final no debe de esta vacio</p>
					</div>
					<div class="form-group">
						<label for="tipo_perfil">Tipo de Perfil :</label>
						<select id="tipo_perfil" class="custom-select">
							<option value=''>Tipo Perfil</option>
							@foreach ($tipo_perfiles as $perfil)
								<option value="{{$perfil->id}}">{{$perfil->tipo_perfil_nombre}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="edad">Edad :</label>
						<select id="edad" class="custom-select">
							<option value="">Edad</option>
							<option value="1">Menor de 29 años</option>
							<option value="2">De 30 a 40 años</option>
							<option value="3">Mayor de 40 años</option>
						</select>
					</div>
					<div class="form-group">
						<label for="sucursal">Sucursal :</label>
						<select id="sucursal" class="custom-select">
							<option value="">Sucursal</option>
							@foreach ($empresas as $empresa)
								<option value="{{$empresa->id}}">{{$empresa->empresa_nombre}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="horas">Horas :</label>
						<select id="horas" class="custom-select">
							<option value=''> Selecione Horas </option>
							<option value='A'>08:00-11:00 hrs</option>
							<option value='B'>11:00-14:00 hrs</option>
							<option value='C'>14:00-17:00 hrs</option>
							<option value='D'>17:00-20:00 hrs</option>
						</select>
					</div>
				</div>
				<div class="col-lg-10 text-center" style="background-color: white;">
					<button class="btn btn-primary float-right">Exportar</button>
					<div id="reporte"></div>
				</div>
			</div>
		</main>
	@endsection