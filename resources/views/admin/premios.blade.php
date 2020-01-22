@extends('admin.plantilla')
	<style>
		.titulo{
			font-size: 12pt;
			font-weight: bold;
			height: 30pt;
		}
		#marcoVistaPrevia{
			border: 1px solid #008000;
		}
		#vistaPrevia{
			max-height: 300px;
		}
		#pre_edit{
			max-height: 300px;
		}
		.modal-body .row{
			padding-top: 20px;
		}
		#imagen_show{
			max-height: 300px;
		}

	</style>
	<script>
		var original =  '{{ url("/uploads") }}';
		var thum =  '{{ url("/thumbnail") }}';
	</script>
    @section('content')
		<main class="app-content">
			<div class="app-title">
				<div>
					<h1>Premios</h1>
				</div>
				<ul class="app-breadcrumb breadcrumb side">
					<a href="#" class="add-modal btn btn-primary mb-2"><li>Nuevo Premio</li></a>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12" style="padding: 1%;">
					<table id="postTable" class="table table-hover table-bordered table-dark" data-show-toggle="true" data-paging-size="10"  data-paging="true">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripcion</th>
								<th>Precio</th>
								<th>Stock</th>
								<th data-breakpoints="xs sm">Clasificacion</th>
								<th data-breakpoints="xs sm">Estatus</th>
								<th data-breakpoints="xs sm" style="width: 15%">Opciones</th>
							</tr>
							{{ csrf_field() }}
						</thead>
						<tbody id="users-crud">
							@foreach($premios as $premio)
								<tr class="item{{$premio->id}}">
									<td>{{ $premio->premio_nombre }}</td>
									<td>{{ $premio->premio_descripcion }}</td>
									<td>{{ $premio->premio_precio }}</td>
									<td>{{ $premio->premio_stock }}</td>
									<td>{{ $premio->clasificacion_id }}</td>
									<td class="estatus">{{ $premio->premio_estatus }}</td>
									<td>
										<button class="show-modal btn btn-success"
											data-nombre = "{{ $premio->premio_nombre }}"
											data-descripcion = "{{ $premio->premio_descripcion }}"
											data-precio = "{{ $premio->premio_precio }}"
											data-stock = "{{ $premio->premio_stock }}"
											data-estatus = "{{ $premio->premio_estatus }}"
											data-clasificacion = "{{ $premio->clasificacion_id }}"
											data-imagen = "{{ $premio->premio_imagen }}"
											data-empresa = "{{ $premio->empresa_id }}"
											style="min-width: 100px; margin: 1%;">
											<span class="far fa-eye"></span> Ver
										</button>
										
										<button class="edit-modal btn btn-info"
											data-id = "{{ $premio->id}}"
											data-nombre = "{{ $premio->premio_nombre}}"
											data-descripcion = "{{ $premio->premio_descripcion}}"
											data-precio = "{{ $premio->premio_precio}}"
											data-stock = "{{ $premio->premio_stock}}"
											data-estatus = "{{ $premio->premio_estatus}}"
											data-clasificacion = "{{ $premio->clasificacion_id}}"
											data-imagen = "{{ $premio->premio_imagen}}"
											data-empresa = "{{ $premio->empresa_id}}"
											style="min-width: 100px; margin: 1%;">
											<span class="far fa-edit"></span> Editar 
										</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
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
					<form method="post" id="FrmImgUpload" action="javascript:void(0)" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="nombre">Nombre del Premio :</label>
										<input class="form-control" name="nombre" id="nombre_add" placeholder="Nombre" type="text">
										<p class="errorNombre text-center alert alert-danger"></p>
									</div>
									<div class="form-group">
										<label for="descripcion">Descripcion :</label>
										<textarea class="form-control" name="descripcion" id="descripcion_add" cols="30" rows="4" minlength="10" maxlength="250"  style="resize: none;" ></textarea>
										<p class="errorDescripcion text-center alert alert-danger"></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="imagen">Imagen :</label>
										<input type="file" name="imagen" id="imagen" class="form-control">
									</div>
									<img class="img-fluid" id="imgSalida"src=""/>
									<p class="errorImagen text-center alert alert-danger"></p>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="precio">Puntos :</label>
										<input class="form-control numero" min="1" max="1000" maxlength="4" name="precio" minlength="1" id="precio_add" placeholder="Puntos" type="text">
										<p class="errorPrecio text-center alert alert-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="piezas">No. Piezas :</label>
										<input type="text" id="stock_add" placeholder="No. de Piezas" name="stock" class="form-control numero">
										<p class="errorStock text-center alert alert-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="estatus">Estatus :</label>
										<select id="estatus_add" class="custom-select" autofocus name="estatus">
											<option value="">Estatus</option>
											<option value="A">Activo</option>
											<option value="B">Baja</option>
										</select>
										<p class="errorEstatus text-center alert alert-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="clasificacion">Clasificacion :</label>
										<select id="clasificacion_add" class="custom-select" autofocus name="clasificacion">
											<option value="">Clasificación</option>
											<option value="1">Basica</option>
											<option value="2">Media</option>
											<option value="3">Premium</option>
										</select>
										<p class="errorClasificacion text-center alert alert-danger"></p>
									</div>
								</div>
								@if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super'))
									<div class="col-md-4">
										<div class="form-group">
											<label for="empresa">Sucursales :</label>
											<select id="empresa_add" class="custom-select" autofocus name="empresa">
												<option value="">Seleccione Sucursales</option>
												@foreach ($empresas as $empresa)
													<option value="{{ $empresa->id }}">{{ $empresa->empresa_nombre }}</option>
												@endforeach
											</select>
											<p class="errorEmpresa text-center alert alert-danger"></p>
										</div>
									</div>
								@endif
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-success">
								<span class='glyphicon glyphicon-check'></span> Añadir
							</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">
								<span class='glyphicon glyphicon-remove'></span> Cerrar
							</button>
						</div>
					</form>
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
							<div class="col-md-6 text-center">
								<img id="imagen_show" class="img-fluid" src="" alt="">
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre">Nombre :</label>
									<h5 id="nombre_show"></h5>
								</div>
								<div class="form-group">
									<label for="descripcion">Descripción :</label>
									<h5 id="descripcion_show"></h5>
								</div>
								<div class="form-group">
									<label for="puntos">Puntos :</label>
									<h5 id="precio_show"></h5>
								</div>
								<div class="form-group">
									<label for="stock">Stock :</label>
									<h5 id="stock_show"></h5>
								</div>
								<div class="form-group">
									<label for="clasificacion">Clasificacion :</label>
									<h5 id="clasificacion_show"></h5>
								</div>
								<div class="form-group">
									<label for="empresa">Sucursales :</label>
									<h5 id="empresa_show"></h5>
								</div>
								<div class="form-group">
									<label for="estatus">Estatus :</label>
									<h5 id="estatus_show"></h5>
								</div>
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
					<form method="PUT" id="form_edit" action="javascript:void(0)" enctype="multipart/form-data">
						<input type="hidden" id="id_edit" name="id">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="nombre">Nombre del Premio :</label>
										<input class="form-control" name="nombre" id="nombre_edit" placeholder="Nombre" type="text">
										<p class="errorNombre text-center alert alert-danger"></p>
									</div>
									<div class="form-group">
										<label for="descripcion">Descripcion :</label>
										<textarea class="form-control" name="descripcion" id="descripcion_edit" cols="30" rows="4" minlength="10" maxlength="250" style="resize: none;"></textarea>
										<p class="errorDescripcion text-center alert alert-danger"></p>
									</div>
								</div>
								<div class="col-md-6 text-center">
									<div class="form-group">
										<label for="imagen">Imagen :</label>
										<input type="file" name="imagen" id="imagen_edit" class="form-control">
									</div>
									<img class="img-fluid" id="pre_edit"src=""/>
									<p class="errorImagen text-center alert alert-danger"></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label for="precio">Puntos :</label>
										<input class="form-control numero" name="precio" id="precio_edit" maxlength="4" min="1" max="1000" minlength="1" id="precio_add" placeholder="Puntos" type="text">
										<p class="errorPrecio text-center alert alert-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="piezas">No. Piezas :</label>
										<input type="text" id="stock_edit" placeholder="No. de Piezas" name="stock" class="form-control numero">
										<p class="errorStock text-center alert alert-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="estatus">Estatus :</label>
										<select id="estatus_edit" class="custom-select" autofocus name="estatus">
											<option value="">Estatus</option>
											<option value="A">Activo</option>
											<option value="B">Baja</option>
										</select>
										<p class="errorEstatus text-center alert alert-danger"></p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="clasificacion">Clasificacion :</label>
										<select id="clasificacion_edit" class="custom-select" autofocus name="clasificacion">
											<option value="">Clasificación</option>
											<option value="1">Basica</option>
											<option value="2">Media</option>
											<option value="3">Premium</option>
										</select>
										<p class="errorClasificacion text-center alert alert-danger"></p>
									</div>
								</div>
								@if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super'))
									<div class="col-md-4">
										<div class="form-group">
											<label for="empresa">Sucursales :</label>
											<select id="empresa_edit" name="empresa" class="custom-select" autofocus>
												<option value="">Seleccione Sucursal</option>
												@foreach ($empresas as $empresa)
													<option value="{{ $empresa->id }}">{{ $empresa->empresa_nombre }}</option>
												@endforeach
											</select>
											<p class="errorEmpresa text-center alert alert-danger"></p>
										</div>
									</div>
								@endif
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-success">
								<span class='glyphicon glyphicon-check'></span> Añadir
							</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">
								<span class='glyphicon glyphicon-remove'></span> Cerrar
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
@endsection


