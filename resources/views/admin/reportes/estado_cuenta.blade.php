<link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
@php
	function traduce_fecha($date){
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$fecha = Carbon\Carbon::parse($date);
		$mes = $meses[($fecha->format('n')) - 1];
		$fecha_traducida = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
		return $fecha_traducida;
	}
@endphp
<div id="wrapper">
	<h2>Winky Coffee</h2>
	<h4>{{ Auth::User()->perfil->empresa->empresa_ubicacion }}</h4>
	<h4>{{ Auth::User()->perfil->ciudad->ciudad_nombre }}. Pue {{ Auth::User()->perfil->empresa->empresa_cp }}</h4>
	<h4>{{ Auth::User()->perfil->empresa->empresa_numero }}</h4>
	<h4>Estado de Cuenta : {{ $user->perfil->full_name }}</h4>
	@if (isset($puntos))
		<h4>Puntos Acumulados : {{ $puntos }} </h4>
	@endif
	@if (strlen($user->perfil->perfil_tarjeta) > 10 )
		<h4></h4>
	@else
		<h4>{{$user->perfil->perfil_tarjeta}}</h4>
	@endif
	<h4>{{ traduce_fecha(date('Y-m-d')) }}</h4>
	@if ($tipo == 'general' )
		<table id="keywords" cellspacing="0" cellpadding="0">
			<thead>
				<thead>
					<tr>
						<td colspan="13">
							Detalles
						</td>
					</tr>
					<tr>
						<th>Ticket</th>
						<th>Fecha Aplicada</th>
						<th>Cantidad</th>
						<th>Puntos S/P</th>
						<th>Descripcion Puntos S/P</th>
						<th>Abono</th>
						<th>Tipo</th>
						<th>Premio</th>
						<th>Promocion</th>
						<th>Sucursal</th>
						<th>Atendio</th>
						<th>Cliente</th>
						<th>Fecha de Creacion</th>
					</tr>
				</thead>
			<tbody>
				@if ( is_array($transacciones) || is_object($transacciones))
					@foreach($transacciones as $transaccion)
						<tr>
							<td>{{ $transaccion->transaccion_ticket }}</td>
							<td>{{ $fecha_aplicada = traduce_fecha($transaccion->transaccion_fecha) }}</td>
							<td>{{ $transaccion->transaccion_cantidad }}</td>
							<td>{{ $transaccion->transaccion_puntos_extras }}</td>
							<td>{{ $transaccion->transaccion_descripcion }}</td>
							<td>{{ $transaccion->transaccion_abono }}</td>
							<td>{{ $transaccion->transaccion_tipo }}</td>

							@if ( is_null($transaccion->premio_id))
								<td></td>
							@else
								<td>{{ $transaccion->premio->premio_nombre }}</td>
							@endif

							@if ( is_null($transaccion->promocion_id))
								<td></td>
							@else
								<td>{{ $transaccion->promocion->promocion_nombre }}</td>
							@endif
							
							<td>{{ $transaccion->empresa->empresa_nombre }}</td>
							<td class="text-capitalize">{{ $transaccion->cliente->perfil_nombre ." ". $transaccion->cliente->perfil_apellidos }}</td>
							<td class="text-capitalize">{{ $transaccion->perfil->perfil_nombre ." ". $transaccion->perfil->perfil_apellidos }}</td>
							<td>{{ $transaccion->created_at}}</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	@else
		<h4>Ticket : {{ $transacciones->transaccion_ticket }}</h4>
		<h4>Fecha Aplicada : {{ $fecha_aplicada = traduce_fecha($transacciones->transaccion_fecha) }}</h4>
		<h4>Cantidad : {{ $transacciones->transaccion_cantidad }}</h4>
		<h4>Puntos S/P : {{ $transacciones->transaccion_puntos_extras }}</h4>
		<h4>Descripcion S/P : {{ $transacciones->transaccion_descripcion }}</h4>
		<h4>Abono : {{ $transacciones->transaccion_abono }}</h4>
		<h4>Tipo : {{ $transacciones->transaccion_tipo }}</h4>
		@if ( !is_null($transacciones->premio_id))
			<h4>Nombre del Premio : {{ $transacciones->premio->premio_nombre }}</h4>
		@endif
		@if ( !is_null($transacciones->promocion_id))
			<h4>Nombre del la promocion : {{ $transacciones->promocion->promocion_nombre }}</h4>
		@endif
		<h4>Nombre de la Sucursal : {{ $transacciones->empresa->empresa_nombre }}</h4>
		<h4 class="text-capitalize"> Atendio : {{ $transacciones->cliente->perfil_nombre ." ". $transacciones->cliente->perfil_apellidos }}</h4>
		<h4 class="text-capitalize"> Cliente : {{ $transacciones->perfil->perfil_nombre ." ". $transacciones->perfil->perfil_apellidos }}</h4>
		<h4>Fecha de Creacion : {{ $transacciones->created_at}}</h4>
	@endif
</div>
			