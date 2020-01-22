@extends('admin.plantilla')
	@section('content')
	<style>
		.tiempo{
			display: flex;
		}
		.tiempo .tiempo-title h1{
			font-size: 3rem;
			margin: 0px;
		}
		.tiempo-title{
			min-width: 300px;
			display: flex;
			align-items: center;
		}
		.tiempo_info{
			padding: 1% 3%;
		}
		.tiempo_button{
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.card-title{
			text-align: right;
		}
	</style>
		<main class="app-content">
			<div class="app-title">
				<div>
					<h1>Bonos</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					{{ csrf_field() }}
					<h3>Buscar Cliente</h3>
					<div class="form-group">
						<input type="text" id="seach" class="form-control input-lg text-capitalize" placeholder="Buscar"/>
						<div id="result"></div>
					</div>
				</div>
			</div>
			<div class="row" style="margin-bottom: 2rem;">
				<div class="col-lg-8">
					<div class="bs-component bg-dark" style="padding-top: 20px; border-radius:0px 20px 0px 20px;">
						<ul class="nav nav-pills" id="pill-puntos">
							<li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#bonos">Bonos</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#renovar">Nuevo o Renovar</a></li>-->
						</ul>
						<div class="tab-content" id="myTabContent" style="margin-top: 2%; padding: 2%;">
							<div class="tab-pane fade active show" id="bonos" style="color: white;">
								<div class="historico text-center" style="display: none;">
									<i class="fas fa-user-clock" style="font-size: 3rem;"></i>
									<h2>Tu Bono expiro</h2>
									<h2><span id="expiro" class="fecha-t"></span></h2>
								</div>

								<div class="nullo text-center" style="display: none;">
									<i class="fas fa-plus-square" style="font-size: 3rem;"></i>
									<h2>No tienes ningun bono</h2>
								</div>
								
								<div class="tiempo row" id="desayuno" style="display: none;">
									<div class="tiempo-title col-12 col-md-3">
										<h1 id="tiempo1">Desayuno</h1>
									</div>
									<div class="tiempo_info col-12 col-md-5">
										<h5>Estatus : <span id="estatus_tiempo1"></span></h5>
										<h5>Sucursal : <span id="empresa_tiempo1"></span></h5>
										<h5>Hora : <span id="hora_tiempo1"></span> </h5>
									</div>
									<div class="tiempo_button col-12 col-md-3">
										<button class="btn btn-md" data-id="1" id="btn_estatus_tiempo1"></button>
									</div>
								</div>
								<div class="tiempo row" id="comida" style="display: none;">
									<div class="tiempo-title col-12 col-md-3">
										<h1 id="tiempo2">Comida</h1>
									</div>
									<div class="tiempo_info col-12 col-md-5">
										<h5>Estatus : <span id="estatus_tiempo2"></span></h5>
										<h5>Sucursal : <span id="empresa_tiempo2"></span> </h5>
										<h5>Hora : <span id="hora_tiempo2"></span></h5>
									</div>
									<div class="tiempo_button col-12 col-md-3">
										<button class="btn btn-md" data-id="2" id="btn_estatus_tiempo2"></button>
									</div>
								</div>

								<div class="tiempo row" id="cena" style="display: none;">
									<div class="tiempo-title col-12 col-md-3">
										<h1 id="tiempo3">Cena</h1>
									</div>
									<div class="tiempo_info col-12 col-md-5">
										<h5>Estatus: <span id="estatus_tiempo3"></span></h5>
										<h5>Sucursal : <span id="empresa_tiempo3"></span></h5>
										<h5>Hora: <span id="hora_tiempo3"></span></h5>
									</div>
									<div class="tiempo_button col-12 col-md-3">
										<button class="btn btn-md" data-id="3" id="btn_estatus_tiempo3"></button>
									</div>
								</div>
							</div>
							<div class="tab-pane fade disabledbutton" id="renovar">
								<form class="form-horizontal text-white">
									<h4 class="heading">Nuevo Bono o Renovar</h4>
									<div class="form-group">
										<label for="tipo">Tipo de Bono</label>
										<select name="tipo" id="tipo" class="custom-select" onchange="actualiza_fechas()">
											<option value="">Seleccione Bono</option>
											<option value="1">Mensual todas comidas</option>
											<option value="2">Mensual solo comida</option>
											<option value="3">Semana todas comidas</option>
											<option value="4">Semana solo comida</option>
										</select>
										<p class="errorTipo text-center alert alert-danger" style="display: none;"></p>
									</div>
									<div class="form-group">
										<label for="inicio">Inicio Bono</label>
										<input id="inicio" name="inicio" autocomplete="off" class="datepicker form-control" placeholder="Inicio del Bono" disabled="disabled" onchange="actualiza_fechas()"/>
										<p class="errorInicio text-center alert alert-danger" style="display: none;"></p>
									</div>
									<div class="form-group">
										<label for="fin">Vencimiento Bono</label>
										<input id="fin" name="fin" class="datepicker form-control" placeholder="Vencimiento" disabled="disabled"/>
										<p class="errorFin text-center alert alert-danger" style="display: none;"></p>
									</div>
									<div class="form-group">
										<button type="button" class="btn btn-success nuevo">
											<span class='glyphicon glyphicon-check'></span> Ingresar
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="bs-component">
						<div class="uno">
							<input type="hidden" id="user_id">
							<h4 class="card-title">Perfil</h4>
							<h5>Nombre: <span id="nombre"></span></h5>
							<h5>Tarjeta:<span id="tarjeta" class="tarjeta"></span></h5>
							<h5>Correo:<span id="correo"></span></h5>
						</div>
						<div class="dos">
							<h5 class="card-title">Informacion Bono</h5>
							<h5>Tipo de Bono: <span id="bono_nombre"></span></h5>
							<h5>Fecha Inicio: <span id="bono_inicio" class="fecha-t"></span></h5>
							<h5>Fecha Fin: <span id="bono_fin" class="fecha-t"></span></h5>
						</div>
						<div class="tres" id="horario_todas_comidas" style="display: none;">
							<h5 class="card-title">Informacion Horarios</h5>
							<h5>Horario Desayuno: 08:00 am - 13:59 pm</h5>
							<h5>Horario Comida: 14:00 pm - 16:59 pm</h5>
							<h5>Horario Cena: 17:00 pm - 19:30 pm</h5>
						</div>
						<div class="tres" id="horario_solo_comida" style="display: none;">
							<h5 class="card-title">Informacion Horarios</h5>
							<h5>Horario Comida: 14:00 pm - 16:59 pm</h5>
						</div>
					</div>
				</div>
			</div>
		</main>
	@endsection