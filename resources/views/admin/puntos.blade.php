@extends('admin.plantilla')
	@section('content')
		<style>
			#list_premios .col-md-4 {
				margin-top: 10%;
			}
			.repo{
				position: relative;
				border-radius: 20px;
				background: linear-gradient(to bottom, rgba(210,231,24,1) 0%, rgba(225,236,19,1) 35%, rgba(170,219,36,1) 100%);
				min-height: 280px;
				max-width: 220px;
			}
			.premio{
				position: absolute;
				max-height: 250px;
				top: -30%;
				left: 20%;
			}
			.info_regalo{
				position: absolute;
				bottom: 10px;
				left: 10%;
			}
			.info_regalo *{
				color: #353a40;
			}
			.cambio{
				position: absolute;
				bottom: 16%;
				right: -15%;
				border-radius: 50%;
				background-color:#401158;
				color:white;
				width: 70px;
				font-size: 10px;
				height: 70px;
				padding-top: 5%;
			}
			.cambio:hover{
				color: white;
			}
			.info_regalo h3{
				line-height: 1;
			}
			.info_regalo hr{
				margin-top: .5rem;
				margin-bottom: .5rem;
				border-top: 2px solid #353a40;
				width: 70px;
				float: left;
			}

		</style>
		<main class="app-content">
			<div class="app-title">
				<div>
					<h1>Puntos</h1>
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
							<li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Acumular">Acumular Puntos</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Utilizar">Utilizar Puntos por Dinero</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Canejar">Canjear Puntos por Regalos</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Estatus">Estado de Cuenta</a></li>
						</ul>
						<div class="tab-content" id="myTabContent" style="margin-top: 2%; padding: 2%;">
							<div class="tab-pane fade active show disabledbutton" id="Acumular">
								<form class="form-horizontal">
									<div class="row">
										<div class="col-md-12">
											<h4 class="heading text-white">Acumular Puntos</h4>
										</div>
										<div class="col-md-6">
											<div class="form-content text-white">
												<div class="form-group">
													<label for="ticket">Ticket o Factura</label>
													<input class="form-control numero" id="tickets_add" placeholder="Numero de Tickets o Factura" type="text">
													<p class="errorTicket text-center alert alert-danger"></p>
												</div>
												<div class="form-group">
													<label for="fecha">Fecha del Ticket</label>
													<input class="form-control" id="fecha_add" type="date" value="{{ date('Y-m-d') }}">
													<p class="errorFecha text-center alert alert-danger"></p>
												</div>

												<div class="form-group">
													<label for="sucursal">Sucursal</label>
													<select class="custom-select" id="sucursal_add">
														<option value="">Seleccione Sucursal</option>
														@foreach ($empresas as $empresa)
															<option value="{{$empresa->id}}">{{$empresa->empresa_nombre}}</option>
														@endforeach
													</select>
													<p class="errorSucursal text-center alert alert-danger"></p>
												</div>

												<div class="form-group">
													<label for="monto">Monto Total de la compra</label>
													<input class="form-control" id="monto_add" placeholder="Monto Total" type="text">
													<p class="errorMonto text-center alert alert-danger"></p>
												</div>
												<div class="form-group">
													<label for="monto">Puntos que seran agregados</label>
													<input class="form-control" id="posibles_puntos" type="text" value="0" disabled="disabled">
												</div>
												
												<div class="clearfix"></div>
											</div>
										</div>
										@if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super')|| Auth::User()->hasRole('super'))
											<div class="col-md-6">
												<div class="form-content text-white">
													<div class="form-group">
														<label for="puntos">Puntos sin Promocion</label>
														<input class="form-control" id="puntos_add" placeholder="Puntos sin Promocion" type="numeric" min="1" max="1000">
														<p class="errorPuntos text-center alert alert-danger"></p>
													</div>
													<div class="form-group">
														<label for="puntos">Descripcion de los puntos sin promocion</label>
														<textarea class="form-control" id="descripcion_add" rows="4" style="resize: none;" maxlength="300" minlength="10"></textarea>
														<p class="errorDescripcion text-center alert alert-danger"></p>
													</div>
													<div class="form-group text-right">
														<div class="form-check">
															<label class="form-check-label">
																<input class="form-check-input" type="checkbox" id="imprimir" value="si" />Imprimir Comprobante
															</label>
														</div>
													</div>
												</div>
											</div>
										@endif
										<div class="col-md-12">
											<div class="text-right">
												<button type="button" id="acumula" class="btn btn-success add">
													<span class='glyphicon glyphicon-check'></span> Añadir
												</button>
											</div>
											<div class="clearfix"></div>
										</div> 
									</div>
								</form>
							</div>
							<div class="tab-pane fade disabledbutton" id="Utilizar">
								<form class="form-horizontal">
									<div class="row text-white">
										<div class="col-md-12">
											<h4 class="heading">Utilizar Puntos</h4>
										</div>
										<div class="col-md-12">
											<div class="form-content">
												<div class="form-group">
													<label for="ticket_utilizar">Ticket</label>
													<input class="form-control entero" id="ticket_utilizar" placeholder="Ticket" type="text">
													<p class="errorTicketUtilizar text-center alert alert-danger"></p>
												</div>
												<div class="form-group">
													<label for="importe_utilizar">Monto Total de la compra</label>
													<input class="form-control numero" id="importe_utilizar" placeholder="Importe en dinero" type="text">
													<p class="errorImporteUtilizar text-center alert alert-danger"></p>
												</div>
												<div class="form-group">
													<div class="form-check">
														<label class="form-check-label">
															<input class="form-check-input" type="checkbox" id="imprimir_utilizar"/>Imprimir Comprobante
														</label>
													</div>
												</div>
												<div class="clearfix"></div>
											</div>
											<button type="button" class="btn btn-success utilizar">
												<span id="" class='glyphicon glyphicon-check'></span> Descontar
											</button>
										</div>
									</div>
								</form>
							</div>
							<div class="tab-pane fade disabledbutton text-white" id="Canejar">
								<h4 class="heading">Canjear Puntos</h4>
								<div id="list_premios" class="row">	
								
								</div>
							</div>
							<div class="tab-pane fade disabledbutton text-white" id="Estatus">
								<h4 class="heading">Transacciones</h4>
								<div id="list_movimientos">
								</div>
								<div id="group_imprimir" class="text-right">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="bs-component">
						<div class="uno">
							<h4> Perfil </h4>
						</div>
						<div class="dos">
							<input type="hidden" id="user_id">
							<h5 id="nombre" class="card-title"></h5>
							<h6 id="tarjeta" class="tarjeta card-subtitle text-muted "></h6>
							<h6 id="correo" class="card-subtitle text-muted"></h6>
						</div>
						<div class="tres text-center">
							<h1 id="puntos"></h1>
							<h5>Total de Puntos</h5>
						</div>
					</div>
					<div class="bs-component error_puntos" style="margin: 5% 0%; display: none;">
						<div class="card mb-3 text-white bg-danger" style="border-radius: 0px 40px 0px 40px;">
							<div class="card-body">
								<blockquote class="card-blockquote">
									<h3>Error Grave !!!!</h3>
									<p class="error_info"></p>
								</blockquote>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	@endsection