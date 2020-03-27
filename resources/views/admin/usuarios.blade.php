@extends('admin.plantilla')
    @section('content')
    <main class="app-content">
    	<div class="app-title">
    		<div>
    			<h1>Lista del Personal</h1>
    		</div>
    		<ul class="app-breadcrumb breadcrumb side">
                <a href="#" class="add-modal btn btn-primary mb-2"><li>Agregar Personal</li></a>
    		</ul>
    	</div>
    	<div class="row">
    		<div class="col-md-12">
    			<div class="tile">
    				<div class="tile-body">
                        <p class="bs-component">
                            <a class="btn btn-primary mt-3" href="{{ URL::to('/export_pdf') }}">Exportar PDF <i class="fas fa-file-pdf"></i></a>
                            <a class="btn btn-primary mt-3" href="{{ URL::to('/export_excel') }}">Exportar Excel <i class="fas fa-file-excel"></i></a>
                        </p>
                        <table id="postTable" class="table table-hover table-bordered table-dark" data-show-toggle="true" data-paging-size="10"  data-paging="true">
    						<thead>
    							<tr>
                                    @if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super'))
                                        <th width="10%">Puesto</th>
                                        <th>Nombre</th>
                                        <th data-breakpoints="xs sm">Ciudad</th>
                                        <th data-breakpoints="xs sm">Sucursal</th>
                                        <th data-breakpoints="xs sm">Email</th>
                                        <th data-breakpoints="xs sm">Cumpleaños</th>
                                        <th data-breakpoints="xs sm">Genero</th>
                                        <th data-breakpoints="xs sm" width="5%">Estatus</th>
                                        <th data-breakpoints="xs sm" width="10%">Opciones</th>
                                    @elseif( Auth::User()->hasRole('geren'))
                                        <th>Nombre</th>
                                        <th data-breakpoints="xs sm">Email</th>
                                        <th data-breakpoints="xs sm">Cumpleaños</th>
                                        <th data-breakpoints="xs sm">Genero</th>
                                        <th data-breakpoints="xs sm" width="5%">Estatus</th>
                                        <th data-breakpoints="xs sm" width="10%">Opciones</th>
                                    @endif
    							</tr>
                                {{ csrf_field() }}
    						</thead>
    						<tbody id="users-crud">
                                @if ( is_array($empleados) || is_object($empleados))
                                    @foreach($empleados as $user)
                                        <tr class="item{{$user->id}}">
                                            @if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super'))
                                                <td class="rol-a">{{ $user->name }}</td>
                                                <td class="text-capitalize">{{ $user->perfil->full_name }}</td>
                                                <td class="text-capitalize">{{ $user->perfil->ciudad->ciudad_nombre }}</td>
                                                <td class="text-capitalize">{{ $user->perfil->empresa->empresa_nombre}}</td>
                                                <td class="text-lowercase">{{ $user->email }}</td>
                                                <td class="fecha-t">{{ $user->perfil->perfil_nacimiento }}</td>
                                                <td class="text-lowercase text-uppercase">{{ $user->perfil->perfil_genero }}</td>
                                                <td class="estatus_general">{{ $user->estatus }}</td>
                                                <td>
                                                    <button class="edit-modal btn btn-info" 
                                                        data-id = "{{$user->id}}" 
                                                        data-name = "{{$user->name}}"
                                                        data-email = "{{$user->email}}"
                                                        data-nombre = "{{$user->perfil->perfil_nombre}}"
                                                        data-apellidos = "{{$user->perfil->perfil_apellidos}}"
                                                        data-ciudad = "{{$user->perfil->ciudad_id}}" 
                                                        data-empresa = "{{$user->perfil->empresa_id}}" 
                                                        data-estatus = "{{$user->estatus}}" 
                                                        data-cumpleanos = "{{ $user->perfil->perfil_nacimiento }}"
                                                        data-genero = "{{ $user->perfil->perfil_genero }}"
                                                    >
                                                    <span class="glyphicon glyphicon-edit"></span> Editar</button>
                                                </td>
                                            @elseif( Auth::User()->hasRole('geren'))
                                                <td>{{ $user->perfil->perfil_nombre." ".$user->perfil->perfil_apellidos}}</td>
                                                <td>{{$user->email}}</td>
                                                <td class="fecha-t">{{$user->perfil->perfil_nacimiento}}</td>
                                                <td>{{$user->perfil->perfil_genero}}</td>
                                                <td>{{ $user->estatus }}</td>
                                                <td>
                                                    <button class="edit-modal btn btn-info" 
                                                        data-id = "{{$user->id}}"
                                                        data-name = "{{$user->name}}"
                                                        data-email = "{{$user->email}}"
                                                        data-nombre = "{{$user->perfil->perfil_nombre}}"
                                                        data-apellidos = "{{$user->perfil->perfil_apellidos}}"
                                                        data-estatus = "{{$user->estatus}}" 
                                                        data-cumpleanos = "{{ $user->perfil->perfil_nacimiento }}"
                                                        data-genero = "{{ $user->perfil->perfil_genero }}"
                                                    >
                                                    <span class="glyphicon glyphicon-edit"></span> Editar</button>
                                                </td>
                                            @endif
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
                            <div class="form-group row">
                                <div class="col-md-6 text-center">
                                    <img src="{{ asset('img/logo.png') }}" id="icon" alt="User Icon" />
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p>Puesto:</p>
                                        <select id="rol_add" class="custom-select" autofocus>
                                            @role('admin')
                                                <option value="">Puesto</option>
                                                <option value="admin">Administrador</option>
                                                <option value="super">Supervisor</option>
                                                <option value="geren">Gerente</option>
                                                <option value="cajero">Cajero</option>
                                            @endrole

                                            @role('super')
                                                <option value="">Puesto</option>
                                                <option value="gerente">Gerente</option>
                                                <option value="cajero">Cajero</option>
                                            @endrole

                                            @role('geren')
                                                <option value="">Puesto</option>
                                                <option value="cajero">Cajero</option>
                                            @endrole
                                        </select>
                                        <p class="errorRol text-center alert alert-danger"></p>
                                    </div>
                                    @if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super'))
                                        <div class="form-group">
                                            <label for="ciudad">Ciudad :</label>
                                            <select id="ciudad_add" class="custom-select" autofocus>
                                                <option value="">Ciudad</option>
                                                @foreach ($ciudades as $ciudad)
                                                    <option value="{{ $ciudad->id }}">{{ $ciudad->ciudad_nombre }}</option>
                                                @endforeach
                                            </select>
                                            <p class="errorCiudad text-center alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="empresa">Sucursal</label>
                                            <select id="empresa_add" class="custom-select" autofocus>
                                                <option value="">Seleccione Sucursal</option>
                                                @foreach ($empresas as $empresa)
                                                    <option value="{{ $empresa->id }}">{{ $empresa->empresa_nombre }}</option>
                                                @endforeach
                                            </select>
                                            <p class="errorEmpresa text-center alert alert-danger"></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <h4 class="heading">Datos Personales</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Nombre :</label>
                                        <input class="form-control" id="nombre_add" placeholder="Nombre" type="text" maxlength="50" minlength="2">
                                        <p class="errorNombre text-center alert alert-danger"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="apellidos">Apellidos :</label>
                                        <input class="form-control" id="apellidos_add" placeholder="Apellidos" type="text" maxlength="50" minlength="2">
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
                                        <label for="cumpleanos">Cumpleaños :</label>
                                        <input class="form-control" id="cumpleanos_add" placeholder="Cumpleaños" type="date">
                                        <p class="errorCumpleanos text-center alert alert-danger"></p>
                                    </div>
                                </div>
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
                        <div class="form-content">
                            <div class="form-group row">
                                <div class="col-md-6 text-center">
                                    <img src="{{ asset('img/logo.png') }}" id="icon" alt="User Icon" />
                                    <input type="hidden" id="id_edit">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p>Puesto:</p>
                                        <select id="rol_edit" class="custom-select" autofocus>
                                            @role('admin')
                                                <option value="">Puesto</option>
                                                <option value="admin">Administrador</option>
                                                <option value="super">Supervisor</option>
                                                <option value="geren">Gerente</option>
                                                <option value="cajero">Cajero</option>
                                            @endrole

                                            @role('super')
                                                <option value="">Puesto</option>
                                                <option value="gerente">Gerente</option>
                                                <option value="cajero">Cajero</option>
                                            @endrole

                                            @role('geren')
                                                <option value="">Puesto</option>
                                                <option value="cajero">Cajero</option>
                                            @endrole
                                        </select>
                                        <p class="errorRol text-center alert alert-danger"></p>
                                    </div>
                                    @if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super'))
                                        <div class="form-group">
                                            <p>Ciudad:</p>
                                            <select id="ciudad_edit" class="custom-select" autofocus>
                                                <option value="">Ciudad</option> 
                                                @foreach ($ciudades as $ciudad)
                                                    <option value="{{ $ciudad->id }}">{{ $ciudad->ciudad_nombre }}</option>
                                                @endforeach
                                            </select>
                                            <p class="errorCiudad text-center alert alert-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <p>Sucursal :</p>
                                            <select id="empresa_edit" class="custom-select" autofocus>
                                                <option value="">Seleccione Sucursal</option>
                                               {{--  @foreach ($empresas as $empresa)
                                                    <option value="{{ $empresa->id }}">{{ $empresa->empresa_nombre }}</option>
                                                @endforeach --}}
                                            </select>
                                            <p class="errorEmpresa text-center alert alert-danger"></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <h4 class="heading">Datos Personales</h4>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <input class="form-control" id="nombre_edit" placeholder="Nombre" type="text">
                                    <p class="errorNombre text-center alert alert-danger"></p>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" id="apellidos_edit" placeholder="Apellidos" type="text">
                                    <p class="errorApellidos text-center alert alert-danger"></p>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" id="correo_edit" placeholder="Correo Electronico" type="text">
                                    <p class="errorCorreo text-center alert alert-danger"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <input class="form-control" id="cumpleanos_edit" placeholder="Cumpleaños" type="date">
                                    <p class="errorCumpleanos text-center alert alert-danger"></p>
                                </div>
                                <div class="col-md-4">
                                    <select id="genero_edit" class="custom-select" autofocus>
                                        <option value="">Genero</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    <p class="errorGenero text-center alert alert-danger"></p>
                                </div>
                                <div class="col-md-4">
                                     <select id="estatus_edit" class="custom-select" autofocus>
                                        <option value="">Estatus</option>
                                        <option value="A">Activo</option>
                                        <option value="B">Baja</option>
                                    </select>
                                    <p class="errorEstatus text-center alert alert-danger"></p>
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
          