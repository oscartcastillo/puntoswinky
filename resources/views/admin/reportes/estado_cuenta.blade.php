{{-- <link rel="stylesheet" href="{{ asset('css/pdf.css') }}"> --}}
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
<style>
	@charset "UTF-8";
	.image {
		width: 250px;
		float: left;
		margin: 20px;
	}
	*{
		font-family: 'Roboto';
	}
	body{
		display: flex;
		align-content: center;
		justify-content: center;
	}
	p {
		margin: 0;
	}
	.performance-facts {
		border: 1px solid black;
		margin: 20px;
		float: left;
		width: 380px;
		padding: 2% 8%;
	}
	.performance-facts table {
		border-collapse: collapse;
	}

	.performance-facts__title {
		font-weight: bold;
		font-size: 2rem;
		margin: 0 0 0.25rem 0;
	}

	.performance-facts__header {
		margin: 0 0 1rem 0;
	}
	.performance-facts__header p {
		margin: 0;
	}

	.performance-facts__table, .performance-facts__table--small, .performance-facts__table--grid {
		width: 100%;
	}
	.performance-facts__table thead tr th, .performance-facts__table--small thead tr th, .performance-facts__table--grid thead tr th, .performance-facts__table thead tr td, .performance-facts__table--small thead tr td, .performance-facts__table--grid thead tr td {
		border: 0;
	}
	.performance-facts__table th, .performance-facts__table--small th, .performance-facts__table--grid th, .performance-facts__table td, .performance-facts__table--small td, .performance-facts__table--grid td {
		font-weight: normal;
		text-align: left;
		padding: 0.25rem 0;
		white-space: nowrap;
	}
	.performance-facts__table td:last-child, .performance-facts__table--small td:last-child, .performance-facts__table--grid td:last-child {
		text-align: right;
	}
	.performance-facts__table .blank-cell, .performance-facts__table--small .blank-cell, .performance-facts__table--grid .blank-cell {
		width: 1rem;
		border-top: 0;
	}
	.performance-facts__table .thick-row th, .performance-facts__table--small .thick-row th, .performance-facts__table--grid .thick-row th, .performance-facts__table .thick-row td, .performance-facts__table--small .thick-row td, .performance-facts__table--grid .thick-row td {
		border-top-width: 5px;
	}

	.small-info {
		font-size: 0.7rem;
	}

	.performance-facts__table--small {
		border-bottom: 1px solid #999;
		margin: 0 0 0.5rem 0;
	}
	.performance-facts__table--small thead tr {
		border-bottom: 1px solid black;
	}
	.performance-facts__table--small td:last-child {
		text-align: left;
	}
	.performance-facts__table--small th, .performance-facts__table--small td {
		border: 0;
		padding: 0;
	}

	.performance-facts__table--grid {
		margin: 0 0 0.5rem 0;
	}
	.performance-facts__table--grid td:last-child {
		text-align: left;
	}
	.performance-facts__table--grid td:last-child::before {
		content: "•";
		font-weight: bold;
		margin: 0 0.25rem 0 0;
	}

	.text-center {
		text-align: center;
	}

	.thick-end {
		border-bottom: 10px solid black;
	}

	.thin-end {
		border-bottom: 1px solid black;
	}
	.logo_center{
		display: flex;
		align-items: center;
		justify-content: center;
	}
	header h4{
		font-weight: 700;
		padding: 0px;
		margin: 0px;
		line-height: 1.5;
	}
	.titulos{
		margin-bottom: 20px;
	}
</style>
<div id="wrapper">
	<section class="performance-facts">
		<header class="performance-facts__header">
			<div class="logo_center">
				<img width="160" src="{{ asset('img/logo.png') }}" alt="logo winky" style="margin: 0 auto;">
			</div>
			<div class="titulos">
				<center><strong><h3>TICKETS PUNTOS DE LEALTAD</h3></strong></center>
				<center><strong><h4>Transacción</h4></strong></center>
			</div>
			<h4>{{ Auth::User()->perfil->ciudad->ciudad_nombre }}. Pue {{ Auth::User()->perfil->empresa->empresa_cp }}</h4>
			<h4>{{ Auth::User()->perfil->empresa->empresa_ubicacion }}</h4>
			<h4>Tel : {{ Auth::User()->perfil->empresa->empresa_numero }}</h4>
		</header>
		<table class="performance-facts__table">
			<thead>
				<tr style="border-bottom: 1px solid black; height: 40px;">
					<th colspan="3">
						<strong>Movimiento</strong>
					</th>
					<th style="text-align: right;">
						{{ $transacciones->transaccion_ticket }}
					</th>
				</tr>
				<tr style="border-bottom: 1px solid black; height: 40px;">
					<th colspan="3">
						<strong>Fecha de operación</strong>
					</th>
					<th style="text-align: right;">
						<?php echo date('d-m-Y')?>
					</th>
				</tr>
				<tr style="height: 40px;">
					
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="4" align="center">
						<h4>Descripción de la transacción</h4>
					</td>
				</tr>
				<tr>
					<td colspan="3"><strong>Fecha Aplicada</strong></td>
					<td>{{ $transacciones->transaccion_fecha }}</td>
				</tr>
				<tr>
					<td colspan="3"><strong>Cantidad</strong></td>
					<td>{{ $transacciones->transaccion_cantidad }}</td>
				</tr>
				<tr>
					<td colspan="3"><strong>Abono</strong></td>
					<td>{{ $transacciones->transaccion_abono }}</td>
				</tr>
				<tr>
					<td colspan="3"><strong>Tipo</strong></td>
					<td>{{ $transacciones->transaccion_tipo }}</td>
				</tr>
				<tr>
					<td colspan="3"><strong>Descripción</strong></td>
					<td>{{ $transacciones->transaccion_descripcion }}</td>
				</tr>
				<tr>
					<td colspan="3"><strong>Premio</strong></td>
					<td>{{ @$transaccion->premio->premio_nombre }}</td>
				</tr>
				<tr>
					<td colspan="3"><strong>Nombre Promoción</strong></td>
					<td>{{ @$transaccion->promocion->promocion_nombre }}</td>
				</tr>
			</tbody>
		</table>
		<div>
			<h4 style="text-align: right;">Datos Cliente</h4>
			<p><strong>Cliente : </strong> {{ $user->perfil->full_name }}</p>
			<p><strong>Tarjeta : </strong> {{ $tarjeta = (strlen($user->perfil->perfil_tarjeta) < 10) ? '' : $user->perfil->perfil_tarjeta }}</p>
			<p><strong>Puntos Acumulados :</strong> {{ @$puntos }} </p>
		</div>
		<p class="small-info text-center" style="margin-top: 50px;">
			www.winky.mx
		</p>
	</section>
</div>
			