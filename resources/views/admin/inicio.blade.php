@extends('admin.plantilla')
    @section('content')
        <main class="app-content">
            <div class="row user">
                <div class="col-md-12 margin-botton">
                    <div class="profile">
                        <div class="info"><img class="user-img" src="../img/avatar-{{ Auth::User()->perfil->avatar_id }}.png">
                            @if (Auth::user()->perfil->perfil_genero == 'M')
                                <h4>Bienvenido </h4>
                                <h4>{{ Auth::user()->perfil->perfil_nombre }}</h4>
                            @else
                                <h4>Bienvenida </h4>
                                <h4>{{ Auth::user()->perfil->perfil_nombre }}</h4>
                            @endif
                        </div>
                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel" style="width: 100%">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block img-fluid" src="{{ asset('img/publi1.jpg') }}">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block img-fluid" src="{{ asset('img/publi2.jpg') }}">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block img-fluid" src="{{ asset('img/publi3.jpg') }}">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block img-fluid" src="{{ asset('img/publi4.jpg') }}">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block img-fluid" src="{{ asset('img/publi5.jpg') }}">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block img-fluid" src="{{ asset('img/publi6.jpg') }}">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block img-fluid" src="{{ asset('img/publi7.jpg') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-12 col-xl-3">
                    <h5 class="title-table">Datos Cliente</h5>
                    <div class="uno">
                        <h1 class="text-center">{{$puntos}}</h1>
                        <h5 class="text-center">Puntos Acumulados</h5>
                    </div>
                    <div class="dos">
                        <h5>Correo: {{ Auth::user()->email }}</h5>
                        <h5>Categoria: <span class="text-capitalize"> {{ Auth::user()->perfil->clasificacion->clasificacion_nombre }}</span></span></h5>
                    </div>

                    <button type="button" class="btn btn-regalos" data-toggle="modal" data-target="#modal_regalos"><img src="{{asset('img/gift.png')}}" alt="" style="margin: 0px 5%">Catalogo de Premios</button>

                    <div class="modal fade" id="modal_regalos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3>Lista de Premios</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        @if (is_array($premios) || is_object($premios))
                                            @foreach($premios as $premio)
                                                <div class="col-md-4 col-premio">
                                                    <div class="repo text-center">
                                                        <h4>{{ $premio->premio_nombre }}</h4>
                                                        <img class="img-fluid premio" src="./uploads/{{ $premio->premio_imagen }}" alt="">
                                                        <div class="info_regalo text-center">
                                                            <h6>{{ $premio->premio_descripcion }}</h6>
                                                            <h6>{{ $premio->premio_precio }} puntos </h6s>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-12 col-xl-9">
                    <h5 class="title-table">Detalles</h5>
                    <div class="tab-content">
                        <table id="postTable" class="table table-hover table-bordered table-dark" data-show-toggle="true" data-paging-size="5"  data-paging="true">
                            <thead>
                                <tr>
                                    <th>Ticket</th>
                                    <th>Total del Ticket</th>
                                    <th data-breakpoints="xs sm">Puntos Extras</th>
                                    <th data-breakpoints="xs sm">Tipo Transacción</th>
                                    <th data-breakpoints="xs sm">Puntos Acumulados</th>
                                    <th data-breakpoints="xs sm">Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="users-crud">
                                @if (is_array($datos) || is_object($datos))
                                    @foreach($datos as $dato)
                                        <tr>
                                            <td>{{ $dato->transaccion_ticket}}</td>
                                            <td>{{ $dato->transaccion_cantidad }}</td>
                                            <td>{{ $dato->transaccion_puntos_extras }}</td>
                                            <td class="times-t">{{ $dato->transaccion_tipo }}</td>
                                            <td>{{ $dato->transaccion_abono }}</td>
                                            <td>{{ $dato->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    @endsection