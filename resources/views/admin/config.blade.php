@extends('admin.plantilla')
    @section('content')
    <style>
        .tile{
            background-color: white;
            padding: 2%;
        }
    </style>
    <main class="app-content">
    	<div class="app-title">
    		<div>
    			<h1>Configuraciones Generales</h1>
    		</div>
    	</div>
        <div class="row">
            <div class="col-md-4">
                <div class="tile">
                    <div class="tile-title-w-btn">
                        <h3 class="title">Ciudades</h3>
                        <div class="btn-group">
                            <button class="btn btn-primary open_modal" data-operation="3"><i class="fa fa-lg fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-ciudades">
                                @if (is_array($ciudades) || is_object($ciudades))
                                    @foreach($ciudades as $ciudad)
                                        <tr>
                                            <td>{{ $ciudad->ciudad_nombre}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tile">
                    <div class="tile-title-w-btn">
                        <h3 class="title">Configuración de Cuentas</h3>
                        <div class="btn-group">
                            <button class="btn btn-primary save-config" data-operation="3" style="margin-left: 2%;"><i class="fas fa-save"></i></button>
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label for="vigencia">Vigencia (Numero de meses para el reset de la cuenta)</label>
                            <input class="form-control" type="text" id="vigencia" value="{{ $vigencia }}">
                            <p class="errorVigencia text-center alert alert-danger" style="display: none;"></p>
                        </div>
                        <div class="form-group">
                            <label for="puntos">Puntos Iniciales (Cantidad de puntos al crear una nueva cuenta)</label>
                            <input class="form-control" type="text" id="puntos_iniciales" value="{{ $puntos_iniciales }}">
                            <p class="errorPuntos text-center alert alert-danger" style="display: none;"></p>
                        </div>
                        <div class="form-group">
                            <label for="puntos">Tiempo Clasificacion Reset (Numero de meses para el reset de la clasificación)</label>
                            <input class="form-control" type="text" id="reset_clasificacion" value="{{ $reset_clasificacion }}">
                            <p class="errorResetClasificacion text-center alert alert-danger" style="display: none;"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="tile">
                    <div class="tile-title-w-btn">
                        <h3 class="title">Sucursales</h3>
                        <div class="btn-group">
                            <button class="btn btn-primary open_modal" data-operation="1"><i class="fa fa-lg fa-plus"></i></button>
                            <button class="btn btn-primary open_modal" data-operation="2"><i class="fa fa-lg fa-edit"></i></button>
                        </div>
                    </div>
                    <div class="tile-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Ubicación</th>
                                    <th>Codigo Postal</th>
                                    <th>Telefono</th>
                                    <th>Ciudad</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-empresas">
                                @if (is_array($empresas) || is_object($empresas))
                                    @foreach($empresas as $empresa)
                                        <tr>
                                            <td>{{ $empresa->empresa_nombre}}</td>
                                            <td>{{ $empresa->empresa_ubicacion }}</td>
                                            <td>{{ $empresa->empresa_cp }}</td>
                                            <td>{{ $empresa->empresa_numero }}</td>
                                            <td>{{ $empresa->ciudad->ciudad_nombre }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tile">
                    <div class="tile-title-w-btn">
                        <h3 class="title">Clasificaciones</h3>
                        <div class="btn-group">
                            <button class="btn btn-primary open_modal" data-operation="4"><i class="fa fa-lg fa-edit"></i></button>
                        </div>
                    </div>
                    <div class="tile-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Rango Min</th>
                                    <th>Rango Max</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-clasificacion">
                                @if (is_array($clasificaciones) || is_object($clasificaciones))
                                    @foreach($clasificaciones as $clasificacion)
                                        <tr>
                                            <td>{{ $clasificacion->clasificacion_nombre}}</td>
                                            <td>{{ $clasificacion->clasificacion_min }}</td>
                                            <td>{{ $clasificacion->clasificacion_max }}</td>
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

    <div class="modal fade" id="general" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="create_empresa" style="display: none;">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="empresa_nombre">
                            <p class="errorNombre text-center alert alert-danger" style="display: none;"></p>
                        </div>
                        <div class="form-group">
                            <label for="ubicacion">Ubicación</label>
                            <input class="form-control" type="text" id="empresa_ubicacion">
                            <p class="errorUbicacion text-center alert alert-danger" style="display: none;"></p>
                        </div>
                        <div class="form-group">
                            <label for="codigo postal">Codigo Postal</label>
                            <input class="form-control" type="text" id="empresa_cp">
                            <p class="errorCp text-center alert alert-danger" style="display: none;"></p>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input class="form-control" type="text" id="empresa_numero">
                            <p class="errorTelefono text-center alert alert-danger" style="display: none;"></p>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Ciudad</label>
                            <select id="empresa_ciudad" class="custom-select">
                                <option value="">Seleccione la ciudad</option>
                                @foreach ($ciudades as $ciudad)
                                    <option value="{{ $ciudad->id }}">{{ $ciudad->ciudad_nombre}}</option>
                                @endforeach
                            </select>
                            <p class="errorCiudad text-center alert alert-danger" style="display: none;"></p>
                        </div>
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="btn_create_empresas">Crear</button>
                        </div>
                    </div>
                    <div id="edit_empresas" style="display: none;">
                        <form id="form_edit_empresa">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="nombre">Nombre</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="ubicacion">Ubicación</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="codigo postal">Codigo Postal</label>
                                </div>
                                <div class="col-md-3">
                                    <label for="telefono">Telefono</label>
                                </div>
                            </div>
                            <div id="modal-empresas">
                                @if (is_array($empresas) || is_object($empresas))
                                    @foreach($empresas as $empresa)
                                        <div class="row">
                                            <input type="hidden" name="dato[{{$empresa->id}}][id]" value="{{$empresa->id}}">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="dato[{{$empresa->id}}][empresa_nombre]" value="{{ $empresa->empresa_nombre }}" required="required">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="dato[{{$empresa->id}}][empresa_ubicacion]" value="{{ $empresa->empresa_ubicacion }}" required="required">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="dato[{{$empresa->id}}][empresa_cp]" value="{{ $empresa->empresa_cp }}" required="required">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="dato[{{$empresa->id}}][empresa_numero]" value="{{ $empresa->empresa_numero }}" required="required">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-12 offset-md-8 col-md-4">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                    <div id="crea_ciudad" style="display: none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="ciudad_nombre">Nombre Ciudad</label>
                                <input class="form-control" type="text" id="ciudad_nombre">
                                <p class="errorCiudad text-center alert alert-danger" style="display: none;"></p>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="btn_create_ciudad">Crear</button>
                        </div>
                    </div>
                    <div id="edit_clasificacion" style="display: none;">
                        <form id="form_edit_clasificacion">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="nombre">Nombre</label>
                                </div>
                                <div class="col-md-4">
                                    <label for="ubicacion">Rango Min</label>
                                </div>
                                <div class="col-md-4">
                                    <label for="codigo postal">Rango Max</label>
                                </div>
                            </div>
                            <div id="modal-clasificacion">
                                @if (is_array($clasificaciones) || is_object($clasificaciones))
                                    @foreach($clasificaciones as $clasificacion)
                                        <div class="row">
                                            <input type="hidden" name="dato[{{$clasificacion->id}}][id]" value="{{$clasificacion->id}}">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h4><strong>{{ $clasificacion->clasificacion_nombre }}</strong></h4>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="dato[{{$clasificacion->id}}][clasificacion_min]" id="min-{{$clasificacion->id}}" value="{{ $clasificacion->clasificacion_min }}" required="required" readonly style="pointer-events: none;">
                                                    <p class="errorMin-{{ $clasificacion->id}} text-center alert alert-danger" style="display: none;"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="dato[{{$clasificacion->id}}][clasificacion_max]" id="max-{{$clasificacion->id}}" value="{{ $clasificacion->clasificacion_max }}" required="required">
                                                    <p class="errorMax-{{ $clasificacion->id}} text-center alert alert-danger" style="display: none;"></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-12 offset-md-8 col-md-4 text-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection