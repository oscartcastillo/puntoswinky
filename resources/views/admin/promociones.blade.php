@extends('admin.plantilla')
    @section('content')
	<main class="app-content">
		<div class="app-title">
			<div>
				<h1>Promociones</h1>
			</div>
			<ul class="app-breadcrumb breadcrumb side">
				@if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super') || Auth::User()->hasRole('geren'))
					<a href="#" class="add-modal btn btn-primary mb-2"><li>Agregar Promocion</li></a>
				@endif
			</ul>
		</div>
		<div class="row">
			<div class="col-12 col-xl-6" style="padding: 20px 10px;">
				<h2 class="text-center text-uppercase">Promociones</h2>
				<table id="postTable" class="table table-hover table-bordered table-dark" data-show-toggle="true" data-paging-size="5"  data-paging="true">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Codigo</th>
							<th>Tipo</th>
							<th>Cantidad</th>
							<th data-breakpoints="xs sm" class="text-center">Estatus</th>
							<th data-breakpoints="xs sm md" width="10%">Opciones</th>
						</tr>
						{{ csrf_field() }}
					</thead>
					<tbody id="users-crud">
						@foreach($promociones as $promo)
							<tr class="item{{$promo->id}}">
								<td> {{ $promo->promocion_nombre }} </td>
								<td> {{ $promo->promocion_codigo }}</td>
								<td class="text-uppercase"> {{ $promo->promocion_tipo }}</td>
								<td> {{ $promo->promocion_cantidad }}</td>
								<td>{{ $promo->promocion_estatus }}</td>
								<td>
									<button class="show-modal btn btn-success" 
										
										data-repetir = "{{$promo->promocion_repetir}}" 
										data-dias = "{{$promo->promocion_dias}}"
										data-color = "{{$promo->promocion_color}}"
										data-inicio = "{{$promo->promocion_inicio}}"
										data-fin = "{{$promo->promocion_fin}}"
										data-diasnombres = "{{$promo->promocion_dias_nombre}}"
											@php
												$empre = "";
												foreach($promo->participantes as $parti){
													$empre .= $parti->empresa_id. ",";
												}
												$empre = substr($empre,0,-1);
											@endphp
											data-empresa = "{{$empre}}"
											style="min-width: 100px; margin: 0%;">
										<span class="glyphicon glyphicon-eye-open" ></span> Ver
									</button>

									@if (Auth::User()->hasRole('admin') || Auth::User()->id == $promo->user_id)
										<button class="edit-modal btn btn-info"
											data-id = "{{$promo->id}}"
											data-nombre = "{{$promo->promocion_nombre}}"
											data-codigo = "{{$promo->promocion_codigo}}"
											data-tipo = "{{$promo->promocion_tipo}}"
											data-cantidad = "{{$promo->promocion_cantidad}}"
											data-estatus = "{{$promo->promocion_estatus}}"
											data-repetir = "{{$promo->promocion_repetir}}"
											data-dias = "{{$promo->promocion_dias}}"
											data-color = "{{$promo->promocion_color}}"
											data-inicio = "{{$promo->promocion_inicio}}"
											data-fin = "{{$promo->promocion_fin}}"
											data-diasnombres = "{{$promo->promocion_dias_nombre}}"
												@php
													$empre = "";
													foreach($promo->participantes as $parti){
														$empre .= $parti->empresa_id. ",";
													}
													$empre = substr($empre,0,-1);
												@endphp
												data-empresa = "{{$empre}}"
												style="min-width: 100px; margin: 0%;">
											<span class="glyphicon glyphicon-edit" ></span> Editar 
										</button>
									 @endif	
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div id="calendario" class="col-12 col-xl-6" style=" padding: 1%;">
			</div>
		</div>
	</main>
	<div id="addModal" class="modal fade bd-example-modal-lg" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal">
						<div class="form-content">
							<h4 class="heading">Nueva Promocion</h4>
							<div class="form-group row">
								<div class="col-md-6">
									<input class="form-control" id="nombre_add" placeholder="Nombre" type="text">
									<p class="errorNombre text-center alert alert-danger"></p>
								</div>
								<div class="col-md-6">
									<input class="form-control" id="codigo_add" placeholder="Codigo" type="text">
									<p class="errorCodigo text-center alert alert-danger"></p>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6">
									<select id="tipo_add" class="custom-select" autofocus>
										<option value="">Tipo de Descuento</option>
										<option value="puntos">Puntos</option>
										<option value="porcentaje">Porcentaje</option>
									</select>
									<p class="errorTipo text-center alert alert-danger"></p>
								</div>
								<div class="col-md-6">
									<input class="form-control numero" id="cantidad_add" placeholder="Cantidad" type="text">
									<p class="errorCantidad text-center alert alert-danger"></p>
								</div>
							</div> 
							<hr>
							<div class="form-group row" style="min-height: 170px;">
								<div class="col-md-6">
									<div class="form-group">
										<label for="fin">Repetir Evento</label>
										<select id="repetir_add" class="custom-select" autofocus onchange="fecha_change(this.id, 'add')">
											<option value="">Repetir</option>
											<option value="A" data-description="La Promoción es valida cada año, mientras su estatus sea activo">Año</option>
											<option value="D" data-description="La Promoción es valida los dias seleccionados, dentro del rango de fechas seleccionadas">Dias</option>
										</select>
										
										<p class="errorRepetir text-center alert alert-danger"></p>
									</div>
									<div>
										<strong><p class="description" align="justify" style="padding: 0% 12px; font-size: 16px;"></p></strong>
									</div>
								</div>
								<div class="col-md-6">
									<label for="inicio">Inicio de la Promocion</label>
									<input class="form-control" id="inicio_add" placeholder="Inicio de la Promocion" onchange="fecha_change(this.id, 'add')" type="date" min="<?php echo $hoy = date("Y-m-d"); ?>">
									<p class="errorInicio text-center alert alert-danger"></p>
									<br>
									<div id="div_fin_add">
										<label for="fin">Fin de la Promocion</label>
										<input class="form-control" id="fin_add" placeholder="Fin de la Promocion" type="date" min="" onchange="fecha_change(this.id, 'add')">
										<p class="errorFin text-center alert alert-danger"></p>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-group row">
								<div class="col-md-4">
									
									<div class="form-group">
										<select id="estatus_add" class="custom-select" autofocus>
											<option value="">Estatus</option>
											<option value="A">Activo</option>
											<option value="B">Baja</option>
										</select>
										<p class="errorEstatus text-center alert alert-danger"></p>
									</div>
									<div class="form-group">
										<label for="color">Color de la Promoción</label>
										<select class="colorselector">
									        <option value="106" data-color="#c7d714">sienna</option>
									        <option value="47" data-color="#b8d219" selected="selected">indianred</option>
									        <option value="87" data-color="#abb913">orangered</option>
									        <option value="15" data-color="#3e0b65">crimson</option>
									        <option value="24" data-color="#59276f">darkorange</option>
									        <option value="78" data-color="#8c50a7">mediumvioletred</option>
									    </select>
									    <input type="hidden" id="color_add"/>
									    <p class="errorColor text-center alert alert-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<h4>Dias</h4>
									<div id="dias_add">
										<div id="dias" class="form-check">
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" name="dias_add[]" value="lunes" />Lunes
											</label>
											<br>
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" name="dias_add[]" value="martes" />Martes
											</label>
											<br>
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" name="dias_add[]" value="miércoles" />Miercoles
											</label>
											<br>
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" name="dias_add[]" value="jueves" />Jueves
											</label>
											<br>
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" name="dias_add[]" value="viernes" />Viernes
											</label>
											<br>
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" name="dias_add[]" value="sábado" />Sabado
											</label>
											<br>
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" name="dias_add[]" value="domingo" />Domingo
											</label>
											<br>
										</div>
										<p class="errorDias text-center alert alert-danger"></p>
									</div>
								</div>
								@if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super'))
									<div class="col-md-4">
										<h4>Participantes</h4>
										<div id="div_empresas_add" class="form-check">
											@foreach ($empresas_insert as $empresa)
												<label class="form-check-label">
													<input class="form-check-input" type="checkbox" name="empresas_add[]" value="{{$empresa->id}}" />{{$empresa->empresa_nombre}} | {{$empresa->ciudad->ciudad_nombre}}
												</label>
												<br>
											@endforeach
										</div>
										<p class="errorEmpresas text-center alert alert-danger"></p>
									</div>
								@endif
							</div>
							<div class="clearfix"></div>
						</div>
					</form>
					<div class="modal-footer">
						<button type="button" class="btn btn-success add" data-dismiss="modal">
							<span id="" class='glyphicon glyphicon-check'></span> Añadir
						</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">
							<span class='glyphicon glyphicon-remove'></span> Cerrar
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="showModal" class="modal fade bd-example-modal-lg" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4 form-group text-center">
							<label for="repetir">Repetir: </label>
							<div id="repetir_show"></div>
						</div>
						<div class="col-md-4 form-group  text-center">
							<label for="dias">Dias: </label>
							<div id="dias_show"></div>
						</div>
						<div class="col-md-4 form-group  text-center">
							<label for="color">Color: </label>
							<div id="color_show"></div>
						</div>
						<div class="col-md-4 form-group  text-center">
							<label for="inicio">Inicio: </label>
							<h5 id="inicio_show"></h5>
						</div>
						<div class="col-md-4 form-group  text-center">
							<label for="fin">Fin: </label>
							<h5 id="fin_show"></h5>
						</div>
						<div class="col-md-4 text-center">
							<label for="empresas">Sucursales: </label>
							<div id="empresas_show"></div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal">
							<span class='glyphicon glyphicon-remove'></span>Cerrar
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="editModal" class="modal fade bd-example-modal-lg" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" id="form-edit">
						<input type="hidden" id="id_edit">
						<div class="form-content">
							<h4 class="heading">Editar Promocion</h4>
							<div class="form-group row">
								<div class="col-md-6">
									<input class="form-control" id="nombre_edit" placeholder="Nombre" type="text">
									<p class="errorNombre text-center alert alert-danger"></p>
								</div>
								<div class="col-md-6">
									<input class="form-control" id="codigo_edit" placeholder="Codigo" type="text">
									<p class="errorCodigo text-center alert alert-danger"></p>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-6">
									<select id="tipo_edit" class="custom-select" autofocus>
										<option value="">Tipo de Descuento</option>
										<option value="puntos">Puntos</option>
										<option value="porcentaje">Porcentaje</option>
									</select>
									<p class="errorTipo text-center alert alert-danger"></p>
								</div>
								<div class="col-md-6">
									<input id="cantidad_edit" class="form-control numero" placeholder="Cantidad" type="text">
									<p class="errorCantidad text-center alert alert-danger"></p>
								</div>
							</div>
							<hr>
							<div class="form-group row" style="min-height: 170px;">
								<div class="col-md-6">
									<div class="form-group">
										<label for="fin">Repetir Evento</label>
										<select id="repetir_edit" class="custom-select" autofocus onchange="fecha_change(this.id, 'edit')">
											<option value="">Repetir</option>
											<option value="A" data-description="La Promoción es valida cada año, mientras su estatus sea activo">Año</option>
											<option value="D" data-description="La Promoción es valida los dias seleccionados, dentro del rango de fechas seleccionadas">Dias</option>
										</select>
										<p class="errorRepetir text-center alert alert-danger"></p>
									</div>
									<div>
										<strong><p id="info_edit" align="justify" style="padding: 0% 12px; font-size: 16px;"></p></strong>
									</div>
								</div>
								<div class="col-md-6">
									<label for="inicio">Inicio de la Promocion</label>
									<input class="form-control" id="inicio_edit" placeholder="Inicio de la Promocion" type="date" onchange="fecha_change(this.id, 'edit')">
									<p class="errorInicio text-center alert alert-danger"></p>
									<br>
									<div id="div_fin_edit">
										<label for="fin">Fin de la Promocion</label>
										<input class="form-control" id="fin_edit" placeholder="Fin de la Promocion" type="date" min="" onchange="fecha_change(this.id, 'edit')">
										<p class="errorFin text-center alert alert-danger"></p>
									</div>
									
								</div>
							</div>
							<hr>
							<div class="form-group row">
								<div class="col-md-4">
									<div class="form-group">
										<select id="estatus_edit" class="custom-select" autofocus>
											<option value="">Estatus</option>
											<option value="A">Activo</option>
											<option value="B">Baja</option>
										</select>
										<p class="errorEstatus text-center alert alert-danger"></p>
									</div>
									<div class="form-group" id="edit_color">
										<label for="color">Color de la Promoción</label>
										<select class="colorselector">
									        <option value="106" data-color="#c7d714">sienna</option>
									        <option value="47" data-color="#b8d219" selected="selected">indianred</option>
									        <option value="87" data-color="#abb913">orangered</option>
									        <option value="15" data-color="#3e0b65">crimson</option>
									        <option value="24" data-color="#59276f">darkorange</option>
									        <option value="78" data-color="#8c50a7">mediumvioletred</option>
									    </select>
									    <input type="hidden" id="color_edit" />
									</div>
								</div>
								<div class="col-md-4">
									<h4>Dias</h4>
									<div id="dias-edit">
										<div id="dias_edit" class="form-check">
										</div>
									</div>
								</div>
								@if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super'))
									<div class="col-md-4">
										<h4>Participantes</h4>
										<div id="div_empresas_edit" class="form-check">
										</div>
										<p class="errorEmpresas text-center alert alert-danger"></p>
									</div>
								@endif
							</div>
							<div class="clearfix"></div>
						</div>
					</form>
					<div class="modal-footer">
						<button type="button" class="btn btn-success edit" data-dismiss="modal">
							<span id="" class='glyphicon glyphicon-check'></span> Añadir
						</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">
							<span class='glyphicon glyphicon-remove'></span> Cerrar
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection