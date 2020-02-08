@extends('admin.plantilla')
	@section('content')
		<main class="app-content">
			<div class="app-title">
				<div>
					<h1>Encuesta de Satisfacción Winky</h1>
				</div>
			</div>
			<div class="row">
				<!--<div class="col-12 col-md-12 bg-white text-center p-2">
					<h4>Reporte Encuesta</h4>
				</div>-->
				{{ csrf_field() }}
				<div id="encuesta" class="col-12 col-lg-2" style="background-color: white; padding: 1%;">
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
					<!--<button class="btn btn-primary exportToExcel" disabled="disabled">Exportar</button>-->
				</div>
				<style>
					.progress-bar{
						font-size: 14px;
					}
					#reporte table tbody td {
						padding: 10px 0%;
					}

					#pregunta1 div:nth-child(1),
					#pregunta2 div:nth-child(1),
					#pregunta3 div:nth-child(1),
					#pregunta4 div:nth-child(1),
					#pregunta5 div:nth-child(1),
					#pregunta6 div:nth-child(1),
					#pregunta7 div:nth-child(1),
					#pregunta8 div:nth-child(1),
					#pregunta9 div:nth-child(1)
					{
						background-color: #28a745 !important;
					}

					#pregunta1 div:nth-child(2),
					#pregunta2 div:nth-child(2),
					#pregunta3 div:nth-child(2),
					#pregunta4 div:nth-child(2),
					#pregunta5 div:nth-child(2),
					#pregunta6 div:nth-child(2),
					#pregunta7 div:nth-child(2),
					#pregunta8 div:nth-child(2),
					#pregunta9 div:nth-child(2)
					{
						background-color: #6c757d !important;
					}

					#pregunta1 div:nth-child(3),
					#pregunta2 div:nth-child(3),
					#pregunta3 div:nth-child(3),
					#pregunta4 div:nth-child(3),
					#pregunta5 div:nth-child(3),
					#pregunta6 div:nth-child(3),
					#pregunta7 div:nth-child(3),
					#pregunta8 div:nth-child(3),
					#pregunta9 div:nth-child(3)
					{
						background-color: #ffc107 !important;
					}

					#pregunta1 div:nth-child(4),
					#pregunta2 div:nth-child(4),
					#pregunta3 div:nth-child(4),
					#pregunta4 div:nth-child(4),
					#pregunta5 div:nth-child(4),
					#pregunta6 div:nth-child(4),
					#pregunta7 div:nth-child(4),
					#pregunta8 div:nth-child(4),
					#pregunta9 div:nth-child(4)
					{
						background-color: #dc3545 !important;
					}
					.etiquetas span{
						display: block;
						height: 20px;
						width: 20px;
					}
					.etiquetas{
						display: flex;
						align-content: center;
						text-align: center;
						width: auto;
						float: right;
						padding-right: 10px;
					}
					.etiquetas span {
						margin: 0px 15px;
						border-radius: 5px;
					}
					.etiquetas h6{
						padding: 2px;
					}

				</style>
				<div class="col-12 col-lg-10 text-center p-3" style="background-color: white;">
					<div class="row">
						<div class="col-12 col-lg-9">
							<div id="reporte">
								<table style="width: 100%;" id="table_encuesta" class="table2excel_with_colors">
									<thead>	
										<tr>
											<td colspan="2" class="text-right">
												<div class="etiquetas">
													<div class="etiquetas">
														<span class="bg-success text-white"></span><h6 class="text-dark">EXCELENTE</h6>
													</div>
													<div class="etiquetas">
														<span class="bg-secondary text-white"></span><h6 class="text-dark">BUENO</h6>
													</div>
													<div class="etiquetas">
														<span class="bg-warning text-white"></span><h6 class="text-dark">REGULAR</h6>
													</div>
													<div class="etiquetas">
														<span class="bg-danger text-white"></span><h6 class="text-dark">MALO</h6>
													</div>
												</div>
											</td>
										</tr>
									</thead>
									<tbody>
										<tr style="height: 50px;">
											<td width="20%">¿En general que tal fue la atención a su servicio?</td>
											<td style="padding: 0% 15px;" >
												<div class="bs-component">
													<div class="progress mb-2" id="pregunta1"></div>
												</div>
											</td>
										</tr>
										<tr style="height: 50px;">
											<td>La atención del cajero fue...</td>
											<td style="padding: 0% 15px;">
												<div class="bs-component">
													<div class="progress mb-2" id="pregunta2"></div>
												</div>
											</td>
										</tr>
										<tr style="height: 50px;">
											<td>¿Qué te parecen nuestros precios?</td>
											<td style="padding: 0% 15px;">
												<div class="bs-component">
													<div class="progress mb-2" id="pregunta3"></div>
												</div>
											</td>
										</tr>
										<tr style="height: 50px;">
											<td>¿Cómo calificas el sabor de nuestros platillos?</td>
											<td style="padding: 0% 15px;">
												<div class="bs-component">
													<div class="progress mb-2" id="pregunta4"></div>
												</div>
											</td>
										</tr>
										<tr style="height: 50px;">
											<td>¿Cómo calificas la higiene de nuestros platillos?</td>
											<td style="padding: 0% 15px;">
												<div class="bs-component">
													<div class="progress mb-2" id="pregunta5"></div>
												</div>
											</td>
										</tr>
										<tr style="height: 50px;">
											<td>¿El servicio de internet fue...?</td>
											<td style="padding: 0% 15px;">
												<div class="bs-component">
													<div class="progress mb-2" id="pregunta7"></div>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<div class="etiquetas">
													<div class="etiquetas">
														<span class="bg-success text-white"></span><h6>SI</h6>
													</div>
													<div class="etiquetas">
														<span class="bg-secondary text-white"></span><h6>NO</h6>
													</div>
													<div class="etiquetas">
														<span class="bg-warning text-white"></span><h6>TAL VEZ</h6>
													</div>
												</div>
											</td>
										</tr>
										<tr style="height: 50px;">
											<td>¿Nos recomendarías?</td>
											<td style="padding: 0% 15px;">
												<div class="bs-component">
													<div class="progress mb-2" id="pregunta6"></div>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<div class="etiquetas">
													<div class="etiquetas">
														<span class="bg-success text-white"></span><h6>08:00-11:00</h6>
													</div>
													<div class="etiquetas">
														<span class="bg-secondary text-white"></span><h6>11:00-14:00 </h6>
													</div>
													<div class="etiquetas">
														<span class="bg-warning text-white"></span><h6>14:00-17:00</h6>
													</div>
													<div class="etiquetas align-middle">
														<span class="bg-danger text-white"></span><h6>17:00-20:00</h6>
													</div>
												</div>
											</td>
										</tr>
										<tr style="height: 50px;">
											<td>Tu servicio fue entre las...</td>
											<td style="padding: 0% 15px;">
												<div class="bs-component">
													<div class="progress mb-2" id="pregunta8"></div>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<div class="etiquetas">
													<div class="etiquetas">
														<span class="bg-success text-white"></span><h6>5-10 min</h6>
													</div>
													<div class="etiquetas">
														<span class="bg-secondary text-white"></span><h6>10-15 min</h6>
													</div>
													<div class="etiquetas">
														<span class="bg-warning text-white"></span><h6>15-20 min</h6>
													</div>
													<div class="etiquetas">
														<span class="bg-danger text-white"></span><h6>20 o mas min</h6>
													</div>
												</div>
											</td>
										</tr>
										<tr style="height: 50px;">
											<td>¿Cuánto tardó tu servicio?</td>
											<td style="padding: 0% 15px;">
												<div class="bs-component">
													<div class="progress mb-2" id="pregunta9">
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>

								<!--<table>
									<thead>	
										<tr>
											<td>PREGUNTA</td>
											<td>EXCELENTE</td>
											<td>BUENO</td>
											<td>REGULAR</td>
											<td>MALO</td>
										</tr>
									</thead>
									<tbody>
										<tr class="pregunta1">
											<td>¿En general que tal fue la atención a su servicio?</td>
										</tr>
										<tr class="pregunta2">
											<td>La atención del cajero fue...</td>
										</tr>
										<tr class="pregunta3">
											<td>¿Qué te parecen nuestros precios?</td>
										</tr>
										<tr class="pregunta4">
											<td>¿Cómo calificas el sabor de nuestros platillos?</td>
										</tr>
										<tr class="pregunta5">
											<td>¿Cómo calificas la higiene de nuestros platillos?</td>
										</tr>
										<tr class="pregunta7">
											<td>¿El servicio de internet fue...?</td>
										</tr>
										<tr>
											<td>SI</td>
											<td>NO</td>
											<td>TAL VEZ</td>
										</tr>
										<tr class="pregunta6">
											<td>¿Nos recomendarías?</td>
										</tr>
										<tr>
											<td>08:00-11:00</td>
											<td>11:00-14:00</td>
											<td>14:00-17:00</td>
											<td>17:00-20:00</td>
										</tr>
										<tr class="pregunta8">
											<td>Tu servicio fue entre las...</td>
										</tr>
										<tr>
											<td>5-10 min</td>
											<td>10-15 min</td>
											<td>15-20 min</td>
											<td>20 o mas min</td>
										</tr>
										<tr class="pregunta9">
											<td>¿Cuánto tardó tu servicio?</td>
										</tr>
									</tbody>
								</table>-->
							</div>
						</div>
						<div class="col-12 col-lg-3">
							<style>
								#lista-opciones{
									height: 480px;
									max-height: 480px;
									overflow-y: scroll;
								}
								#personas{
									font-size: 2rem;
								}
							</style>
							<h6 style="padding: 18px;">Plantillos Sugeridos</h6>
							<ul class="list-group" id="lista-opciones">
							</ul>

							<div class="form-group">
								<h4>TOTAL DE PERSONAS ENCUESTADAS</h4>
								<strong><span id="personas"></span></strong>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	@endsection