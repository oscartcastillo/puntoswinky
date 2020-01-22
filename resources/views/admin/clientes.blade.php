@extends('admin.plantilla')
    @section('content')
    <main class="app-content">
    	<div class="app-title">
    		<div>
    			<h1>Lista del Clientes</h1>
    		</div>
    		<ul class="app-breadcrumb breadcrumb side">
                <a href="#" class="add-modal btn btn-primary mb-2"><li>Nuevo Usuario</li></a>
    		</ul>
    	</div>
    	<div class="row">
    		<div class="col-md-12">
    			<div class="tile">
    				<div class="tile-body">
                        <p class="bs-component">
                            <a class="btn btn-primary" href="{{ URL::to('clientes_export_pdf') }}">Export PDF</a>
                            <a class="btn btn-primary" href="{{ URL::to('clientes_export_excel') }}">Export EXCEL</a>
                        </p>
                        <table id="postTable" class="table table-hover table-bordered table-dark" data-show-toggle="true">
    						<thead>
    							<tr>
                                    <th>No. Tarjeta</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th data-breakpoints="xs sm">Cumpleaños</th>
                                    <th data-breakpoints="xs sm" width="5%">Estatus</th>
                                    <th data-breakpoints="xs sm" width="15%">Opciones</th>
    							</tr>
                                {{ csrf_field() }}
    						</thead>
    						<tbody id="users-crud">
                                @if ( is_array($clientes) || is_object($clientes))
                                    @foreach($clientes as $user)
                                        <tr class="item{{$user->id}}">
                                        	<td class="tarjeta">{{ $user->perfil->perfil_tarjeta }}</td>
                                            <td style="text-transform: capitalize;">{{ $user->perfil->full_name}}</td>
                                            <td>{{ $user->email}}</td>
                                            <td class="fecha-t">{{ $user->perfil->perfil_nacimiento }}</td>
                                            <td>{{ $user->estatus }}</td>
                                            <td>
                                                <button class="show-modal btn btn-success"
                                                    data-telefono = "{{ $user->perfil->perfil_celular}}"
                                                    data-cumpleanos = "{{ $user->perfil->perfil_nacimiento }}"
                                                    data-compania = "{{ $user->perfil->perfil_compania }}"
                                                    data-tipo = "{{ $user->perfil->tipo_perfil->tipo_perfil_nombre }}"
                                                    data-genero = "{{ $user->perfil->perfil_genero }}"
                                                    data-tarjeta = "{{ $user->perfil->perfil_tarjeta }}"
                                                    style="min-width: 100px;">
                                                <span class="glyphicon glyphicon-eye-open"></span> Ver</button>
                                                <button class="edit-modal btn btn-info" 
                                                    data-id="{{$user->id}}" 
                                                    data-email ="{{$user->email}}"
                                                    data-nombre ="{{$user->perfil->perfil_nombre}}"
                                                    data-apellidos="{{$user->perfil->perfil_apellidos}}"
                                                    data-estatus ="{{$user->estatus}}" 
                                                    data-telefono = "{{ $user->perfil->perfil_celular}}"
                                                    data-cumpleanos = "{{ $user->perfil->perfil_nacimiento}}"
                                                    data-compania = "{{ $user->perfil->perfil_compania }}"
                                                    data-tipo = "{{ $user->perfil->tipo_perfil_id }}"
                                                    data-genero = "{{ $user->perfil->perfil_genero }}"
                                                    data-tarjeta = "{{ $user->perfil->perfil_tarjeta }}"
                                                    style="min-width: 100px;">
                                                <span class="glyphicon glyphicon-edit"></span> Editar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </main>
    <!-- Modal form to add a post -->
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
                            <h4 class="heading">Datos Personales</h4>
                            <div class="form-group row">
                            	<input type="hidden" rol_add ="cliente">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Nombre :</label>
                                        <input class="form-control" id="nombre_add" placeholder="Nombre" type="text">
                                        <p class="errorNombre text-center alert alert-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="apellidos">Apellidos :</label>
                                        <input class="form-control" id="apellidos_add" placeholder="Apellidos" type="text">
                                        <p class="errorApellidos text-center alert alert-danger"></p>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="correo">Correo :</label>
                                        <input class="form-control" id="correo_add" placeholder="Correo Electronico" type="text">
                                        <p class="errorCorreo text-center alert alert-danger"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cumpleanos">Fecha de Nacimiento :</label>
                                        <input class="form-control" id="cumpleanos_add" placeholder="Cumpleaños" type="date">
                                        <p class="errorCumpleanos text-center alert alert-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefono">Telefono :</label>
                                        <input class="form-control" id="telefono_add" placeholder="Celular (10 digitos)" type="text">
                                        <p class="errorTelefono text-center alert alert-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="compania">Compañia Telefonica :</label>
                                        <select id="compania_add" class="custom-select" autofocus>
                                            <option value="">Compañia Telefonica</option>
                                            <option value="telcel">Telcel</option>
                                            <option value="movistar">Movistar</option>
                                            <option value="at&t">AT&T</option>
                                            <option value="unefon">Unefon</option>
                                            <option value="freedompop">FreedomPop</option>
                                            <option value="virgin">Virgin Mobile</option>
                                            <option value="simplii">Simplii</option>
                                            <option value="weex">Weex</option>
                                            <option value="flashmobil">Flash Mobile</option>
                                            <option value="cierto">Cierto</option>
                                            <option value="alo">Aló</option>
                                            <option value="maz_tiempo">Maz Tiempo</option>
                                            <option value="tokamovil">Tokamóvil</option>
                                            <option value="qbocel">QBOcel</option>
                                            <option value="miio">Miio</option>
                                            <option value="otra">Otra</option>
                                        </select>
                                        <p class="errorCompania text-center alert alert-danger"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="genero">Genero :</label>
                                        <select id="genero_add" class="custom-select" autofocus>
                                            <option value="">Genero</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                        <p class="errorGenero text-center alert alert-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="estatus">Estatus :</label>
                                        <select id="estatus_add" class="custom-select" autofocus>
                                            <option value="">Estatus</option>
                                            <option value="A">Activo</option>
                                            <option value="B">Baja</option>
                                        </select>
                                        <p class="errorEstatus text-center alert alert-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipo">Tipo :</label>
                                        <select name="tipo_add" id="tipo_add" class="custom-select" autofocus="">
                                            <option value="">Tipo</option>
                                            <option value="2">Ex Alumno </option>
                                            <option value="3">Docente</option>
                                            <option value="4">Alumno</option>
                                            <option value="5">Externo</option>
                                            <option value="6">Administrativo</option>
                                        </select>
                                        <p class="errorTipo text-center alert alert-danger"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="tarjeta">Tarjeta :</label>
                                    <input class="form-control tarjeta" id="tarjeta_add" placeholder="No. Tarjeta" type="text" maxlength="10" minlength="10">
                                    <p class="errorTarjeta text-center alert alert-danger"></p>
                                </div>
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

    <!-- Modal form to show a post -->
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
                            <label for="telefono">Telefono:</label>
                            <h5 id="telefono_show"></h5>
                        </div>
                        <div class="col-md-4 form-group  text-center">
                            <label for="cumpleanos">Cumpleaños:</label>
                            <h5 id="cumpleanos_show" class="fecha-t"></h5>
                        </div>
                        <div class="col-md-4 form-group  text-center">
                            <label for="compania">Compañia Telefonica:</label>
                            <h5 class="text-uppercase" id="compania_show"></h5>
                        </div>
                        <div class="col-md-4 form-group  text-center">
                            <label for="genero">Genero:</label>
                            <h5 id="genero_show"></h5>
                        </div>
                        <div class="col-md-4 form-group  text-center">
                            <label for="tipo">Tipo:</label>
                            <h5 class="text-uppercase tipo_perfil" id="tipo_show"></h5>
                        </div>
                        <div class="col-md-4 text-center">
                            <label for="tarjeta">No. Tarjeta:</label>
                            <h5 class="tarjeta" id="tarjeta_show"></h5>
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

    <!-- Modal form to edit a form -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="form-edit">
                        <input type="hidden" id="id_edit">
                        <div class="form-content">
                            <h4 class="heading">Datos Personales</h4>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="nombre">Nombre(s): </label>
                                    <input class="form-control" id="nombre_edit" placeholder="Nombre" type="text">
                                    <p class="errorNombre text-center alert alert-danger"></p>
                                </div>
                                <div class="col-md-4">
                                    <label for="apellidos">Apellidos: </label>
                                    <input class="form-control" id="apellidos_edit" placeholder="Apellidos" type="text">
                                    <p class="errorApellidos text-center alert alert-danger"></p>
                                </div>
                                <div class="col-md-4">
                                    <label for="correo">Correo: </label>
                                    <input class="form-control" id="correo_edit" placeholder="Correo Electronico" type="text">
                                    <p class="errorCorreo text-center alert alert-danger"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="cumpleanos">Cumpleaños: </label>
                                    <input class="form-control" id="cumpleanos_edit" placeholder="Cumpleaños" type="date">
                                    <p class="errorCumpleanos text-center alert alert-danger"></p>
                                </div>
                                <div class="col-md-4">
                                    <label for="telefono">Telefono: </label>
                                    <input class="form-control" id="telefono_edit" placeholder="Celular (10 digitos)" type="text">
                                    <p class="errorTelefono text-center alert alert-danger"></p>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="compania">Compania Telefonica: </label>
                                        <select id="compania_edit" class="custom-select" autofocus style="margin-bottom:5%;">
                                            <option value="telcel">Telcel</option>
                                            <option value="movistar">Movistar</option>
                                            <option value="at&t">AT&T</option>
                                            <option value="unefon">Unefon</option>
                                            <option value="freedompop">FreedomPop</option>
                                            <option value="virgin">Virgin Mobile</option>
                                            <option value="simplii">Simplii</option>
                                            <option value="weex">Weex</option>
                                            <option value="flashmobil">Flash Mobile</option>
                                            <option value="cierto">Cierto</option>
                                            <option value="alo">Aló</option>
                                            <option value="maz_tiempo">Maz Tiempo</option>
                                            <option value="tokamovil">Tokamóvil</option>
                                            <option value="qbocel">QBOcel</option>
                                            <option value="miio">Miio</option>
                                            <option value="otra">Otra</option>
                                        </select>
                                        <p class="errorCompania text-center alert alert-danger"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="genero">Genero: </label>
                                        <select id="genero_edit" class="custom-select" autofocus style="margin-bottom: 5%;">
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                        <p class="errorGenero text-center alert alert-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="estatus">Estatus: </label>
                                        <select id="estatus_edit" class="custom-select" autofocus>
                                            <option value="A">Activo</option>
                                            <option value="B">Baja</option>
                                        </select>
                                        <p class="errorEstatus text-center alert alert-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipo">Tipo: </label>
                                        <select name="tipo_edit" id="tipo_edit" class="custom-select" autofocus="">
                                            <option value="">Tipo</option>
                                            <option value="2">Ex Alumno </option>
                                            <option value="3">Docente</option>
                                            <option value="4">Alumno</option>
                                            <option value="5">Externo</option>
                                            <option value="6">Administrativo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tarjeta">Tarjeta: </label>
                                        <input class="form-control tarjeta" id="tarjeta_edit" placeholder="No. Tarjeta" type="text" maxlength="10" minlength="10">
                                        <p class="errorTarjeta text-center alert alert-danger"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Editar
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection