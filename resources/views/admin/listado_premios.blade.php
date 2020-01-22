@extends('admin.plantilla')
    @section('content')
		<main class="app-content">
			<div class="app-title">
				<div>
					<h1>Premios Otorgados</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" style="padding: 1%;">
					<table id="postTable" class="table table-hover table-bordered table-dark" data-show-toggle="true" data-paging-size="10"  data-paging="true">
						<thead>
							<tr>
								<th>Ticket</th>
								<th>Premio</th>
								<th>Sucursalf</th>
								<th data-breakpoints="xs sm">Vendedor</th>
								<th data-breakpoints="xs sm">Creación</th>
							</tr>
							{{ csrf_field() }}
						</thead>
						<tbody id="users-crud">
							@foreach($transacciones as $transaccion)
								<tr class="item{{$transaccion->id}}">
									<td>{{ $transaccion->transaccion_ticket }}</td>
									<td>{{ $transaccion->premio->premio_nombre }}</td>
									<td>{{ $transaccion->empresa->empresa_nombre }}</td>
									<td>{{ $transaccion->perfil->full_name }}</td>
									<td class="times-t">{{ $transaccion->created_at }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</main>
@endsection


