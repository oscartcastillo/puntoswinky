<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-colorselector.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('footable/css/footable.bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('footable/css/footable.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('sweetalert/sweetalert2.min.css') }}">

    <!-- <link rel="stylesheet" href="https://unpkg.com/flickity@2.0/dist/flickity.min.css"> -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script> 

</head>
<body class="app sidebar-mini rtl">
    <header class="app-header">
        <a class="app-header__logo" href="index.html"><strong>Puntos</strong> de Lealtad</a>
        <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <ul class="app-nav">
            <li class="dropdown">
                <a class="app-nav__item text-uppercase" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">
                    {{-- <i class="fa fa-user fa-lg"></i> --}}
                    <img src="{{ asset('img/avatar-0.png') }}" alt="" style="width: 40px;">
                </a>
                <ul id="options" class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="{{ route('perfil.index') }}"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" ><i class="fa fa-sign-out fa-lg"></i> Salir</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </ul>
            </li>
        </ul>
    </header>

    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user">
            {{--<img id="img-avatar" class="user-img avatar-4" src="http://puntos4.test.uvp.mx/img/avatar-4.png">
             src="{{ asset('img/perfil.png') }}"  --}}
            <img class="app-sidebar__user-avatar user-img" src="../img/avatar-{{ Auth::User()->perfil->avatar_id }}.png" alt="User Image" style="width: 40%;">
            <div>
            </div>
        </div>
        <img class="img-fluid" id="slider-logo" src="{{asset('img/logo.png')}}" alt="">
        <ul class="app-menu">
            <li>
                <a class="app-menu__item active" href="{{ url('/inicio') }}">
                    <i class="app-menu__icon fa fa-dashboard"></i>
                    <span class="app-menu__label">Inicio</span>
                </a>
            </li>
            @if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super') || Auth::User()->hasRole('geren') || Auth::User()->hasRole('cajero')) 
                <li class="treeview">
                    <a class="app-menu__item" href="#" data-toggle="treeview">
                        <i class="app-menu__icon fas fa-users"></i>
                        <span class="app-menu__label">Usuarios</span>
                        <i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        @if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('super') || Auth::User()->hasRole('geren')) 
                            <li>
                                <a class="treeview-item" href="{{ route('usuarios.index') }}"><i class="icon fa fa-circle-o"></i>Personal</a>
                            </li>
                            <li>
                                <a class="treeview-item" href="{{ route('clientes.index') }}" rel="noopener"><i class="icon fa fa-circle-o"></i>Clientes</a>
                            </li>
                        @else
                            <li>
                                <a class="treeview-item" href="{{ route('clientes.index') }}" rel="noopener"><i class="icon fa fa-circle-o"></i>Clientes</a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li>
                    <a class="app-menu__item" href="{{ route('promociones.index') }}">
                        <i class="app-menu__icon fas fa-wallet"></i>
                        <span class="app-menu__label">Promociones</span>
                    </a>
                </li>
                <li>
                    <a class="app-menu__item" href="{{ route('bonos.index') }}">
                        <i class="app-menu__icon fas fa-shopping-cart"></i>
                        <span class="app-menu__label">Bonos</span>
                    </a>
                </li>
                <li class="treeview">
                    <a class="app-menu__item" href="#" data-toggle="treeview">
                        <i class="app-menu__icon fas fa-coins"></i>
                        <span class="app-menu__label">Puntos</span>
                        <i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a class="treeview-item" href="{{ route('puntos.index') }}"><i class="icon fa fa-circle-o"></i>Puntos</a>
                        </li>
                        <li>
                            <a class="treeview-item" href="{{ route('listado_puntos') }}"><i class="icon fa fa-circle-o"></i>Listado de Puntos</a>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a class="app-menu__item" href="#" data-toggle="treeview">
                        <i class="app-menu__icon fas fa-gift"></i>
                        <span class="app-menu__label">Premios</span>
                        <i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a class="treeview-item" href="{{ route('premios.index') }}"><i class="icon fa fa-circle-o"></i>Premios</a>
                        </li>
                        <li>
                            <a class="treeview-item" href="{{ route('listado_premios') }}"><i class="icon fa fa-circle-o"></i>Consulta Premios</a>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a class="app-menu__item" href="#" data-toggle="treeview">
                        <i class="app-menu__icon fas fa-chart-line"></i>
                        <span class="app-menu__label">Reportes</span>
                        <i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a class="treeview-item" href="{{ route('reportes.index') }}"><i class="icon fa fa-circle-o"></i>Reportes Generales</a>
                        </li>
                        <li>
                            <a class="treeview-item" href="{{ route('encuestas.index') }}"><i class="icon fa fa-circle-o"></i>Encuestas Winky</a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a class="app-menu__item" href="{{ route('config.index') }}">
                        <i class="app-menu__icon fas fa-cogs"></i>
                        <span class="app-menu__label">Configuración</span>
                    </a>
                </li>
                
            @endif
            <li>
                <a class="app-menu__item" href="{{ route('reglas') }}">
                    <i class="app-menu__icon fa fa-file-text"></i>
                    <span class="app-menu__label">Reglas</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item" href="{{ route('menu.index') }}">
                    <i class="app-menu__icon fa fa-file-text"></i>
                    <span class="app-menu__label">Menu</span>
                </a>
            </li>
        </ul>
    </aside>
	@yield('content')
    
    <div class="ir-arriba">
        <ul class="social-network social-circle">
            <li><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
            <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
            <li><a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a></li>
        </ul>
    </div>

    <script type="text/javascript" src="{{ asset('js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js')}}"></script>
    <script type="text/javascript" src="{{ asset('footable/js/footable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('footable/js/footable.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-colorselector.js')}}"></script>

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript" src="{{ asset('sweetalert/sweetalert2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moments.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/config.js')}}"></script>
    
    @php
        $url = $_SERVER["REQUEST_URI"];
        $fin =  explode('/', $url);
    @endphp
    @switch($url)
        @case('/usuarios')
            
            <script type="text/javascript" src="{{ asset('js/ajax.js')}}"></script>
            <script type="text/javascript">
                jQuery(function($){
                    $('.table').footable({
                        "paging": {
                            "size": 10
                        },
                        "filtering": {
                            "enabled": true
                        },
                        "sorting": {
                            "enabled": true
                        }
                    });
                });
            </script>
            @break

        @case('/clientes')
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
            <script type="text/javascript" src="{{ asset('js/ajax-cliente.js')}}"></script>
            <script type="text/javascript">
                jQuery(function($){
                    $('.table').footable({
                        "paging": {
                            "size": 10
                        },
                        "filtering": {
                            "enabled": true
                        },
                        "sorting": {
                            "enabled": true
                        }
                    });
                });
            </script>
            @break

        @case('/puntos')
            <script type="text/javascript" src="{{ asset('js/puntos.js')}}"></script>
            @break

        @case('/promociones')
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
            <script type="text/javascript"  src="{{ asset('js/es.js')}}"></script>
            <script type="text/javascript" src="{{ asset('js/promociones-script.js')}}"></script>
            <script type="text/javascript">
                jQuery(function($){
                    $('.table').footable({
                        "paging": {
                            "size": 3
                            //"enabled": true
                        },
                        "filtering": {
                            "enabled": true
                        },
                        "sorting": {
                            "enabled": true
                        }
                    });
                });
            </script>
            @break

        @case('/inicio')
            <script type="text/javascript" src="{{ asset('js/plugins/chart.js')}}"></script>
            {{-- <script type="text/javascript" src="{{ asset('js/grafica.js')}}"></script> --}}

            <script type="text/javascript" src="{{ asset('js/inicio.js')}}"></script>
            <script type="text/javascript">
                jQuery(function($){
                    $('.table').footable({
                        "paging": {
                            "size": 5
                        },
                        "filtering": {
                            "enabled": true
                        },
                        "sorting": {
                            "enabled": true
                        }
                    });
                });
            </script>
            @break

        @case('/listado_puntos')
            <script type="text/javascript" src="{{ asset('js/cancelacion.js')}}"></script>
            <script type="text/javascript">
                jQuery(function($){
                    $('.table').footable({
                        "paging": {
                            "size": 15
                        },
                        "filtering": {
                            "enabled": true
                        },
                        "sorting": {
                            "enabled": true
                        }
                    });
                });
            </script>
            @break

        @case('/premios')
            <script type="text/javascript" src="{{ asset('js/premios.js')}}"></script>
            <script type="text/javascript">
                jQuery(function($){
                    $('.table').footable({
                        "paging": {
                            "size": 10
                        },
                        "filtering": {
                            "enabled": true
                        },
                        "sorting": {
                            "enabled": true
                        }
                    });
                });
            </script>
            @break

        @case('/bonos')
            <script type="text/javascript" src="{{ asset('js/bonos.js')}}"></script>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
            <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
            @break

        @case('/reportes')
            <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
            <script type="text/javascript" src="{{ asset('js/reportes.js')}}"></script>
            @break

        @case('/perfil')
            <script type="text/javascript" src="{{ asset('js/perfil.js')}}"></script>
            @break

        @case('/encuestas')
            <script type="text/javascript" src="{{ asset('js/encuesta.js')}}"></script>
            @break

        @case('/menu')
            <script type="text/javascript" src="{{ asset('js/flickity.js')}}"></script>
            @break
    
        @default
    @endswitch
</body>
</html>