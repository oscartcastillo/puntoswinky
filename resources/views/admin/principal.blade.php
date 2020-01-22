@extends('admin.plantilla')
    @section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1>Inicio</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="widget-small primary coloured-icon"><i class="icon far fa-credit-card fa-3x" aria-hidden="true"></i>
                    <div class="info">
                       <h2 class="text-center">{{ $data['clientes'] }}</h2>
                       <h6 class="text-center">¡Numero de Cuenta!</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small primary coloured-icon"><i class="icon fas fa-user-check fa-3x" aria-hidden="true"></i>
                    <div class="info">
                        <h2 class="text-center">{{ $data['clientes_totales'] }}</h2>
                        <h6 class="text-center">¡Clientes Registrados!</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon"><i class="icon fas fa-times fa-3x" aria-hidden="true"></i>
                    <div class="info">
                        <h2 class="text-center">{{ $data['clientes_sin_tarjeta'] }}</h2>
                        <h6 class="text-center">Clientes sin Tarjeta</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="widget-small warning coloured-icon"><i class="icon fas fa-users fa-3x" aria-hidden="true"></i>
                    <div class="info">
                        <h2 class="text-center">{{ $data['clientes_mes'] }}</h2>
                        <h6 class="text-center">Nuevos Clientes (Mes)</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small warning coloured-icon"><i class="icon fas fa-users fa-3x" aria-hidden="true"></i>
                    <div class="info">
                        <h2 class="text-center">{{ $data['clientes_semana'] }}</h2>
                        <h6 class="text-center">Nuevos Clientes (Semana)</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small warning coloured-icon"><i class="icon fas fa-users fa-3x" aria-hidden="true"></i>
                    <div class="info">
                        <h2 class="text-center">{{ $data['clientes_dia'] }}</h2>
                        <h6 class="text-center">Nuevos Clientes (Hoy)</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="widget-small info coloured-icon"><i class="icon fas fa-cash-register fa-3x" aria-hidden="true"></i>
                    <div class="info">
                        <h2 class="text-center">{{$data['puntos_utilizados_mes']}}</h2>
                        <h6 class="text-center">Total Puntos Utilizados (Mes)</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small info coloured-icon"><i class="icon fas fa-gift fa-3x" aria-hidden="true"></i>
                    <div class="info">
                        <h2 class="text-center">{{ $data['premios_otorgados_mes']}} </h2>
                        <h6 class="text-center">Premios del Mes</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small info coloured-icon"><i class="icon fas fa-money-check-alt fa-3x" aria-hidden="true"></i>
                    <div class="info">
                        <h2 class="text-center">{{ $data['cancelaciones_mes']}} </h2>
                        <h6 class="text-center">Cancelaciones del Mes</h6>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Estadisticas Mensuales</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Porcentaje de Puntos</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
