@extends('admin.plantilla')
	@section('content')
		<main class="app-content">
			<div class="app-title">
				<div>
					<h5>Reporte del Dia <span class="fecha-t">{{ date('Y-m-d') }}</span></h5>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table id="postTable" class="table table-hover table-bordered table-dark" data-show-toggle="true">
						<thead>
							<tr>
								<th>Ticket</th>
								<th>Fecha Aplicada</th>
								<th data-breakpoints="xs sm">Cantidad</th>
								<th data-breakpoints="xs sm">Puntos S/P</th>
								<th data-breakpoints="xs sm">Descripcion Puntos S/P</th>
								<th data-breakpoints="xs sm">Abono</th>
								<th data-breakpoints="xs sm">Tipo</th>
								<th data-breakpoints="xs sm">Premio</th>
								<th data-breakpoints="xs sm">Promocion</th>
								<th data-breakpoints="xs sm">Sucursal</th>
								<th data-breakpoints="xs sm">Atendio</th>
								<th data-breakpoints="xs sm">Cliente</th>
								<th data-breakpoints="xs sm">Fecha de Creacion</th>
								<th data-breakpoints="xs sm">Opciones</th>
							</tr>
							{{ csrf_field() }}
						</thead>
						<tbody id="transacciones">
							@if ( is_array($transacciones) || is_object($transacciones))
								@foreach($transacciones as $transaccion)
									<tr class="item{{ $transaccion->id }}">
										<td>{{ $transaccion->transaccion_ticket}}</td>
										<td class="fecha-t">{{ $transaccion->transaccion_fecha }}</td>
										<td>{{ $transaccion->transaccion_cantidad}}</td>
										<td>{{ $transaccion->transaccion_puntos_extras}}</td>
										<td>{{ $transaccion->transaccion_descripcion}}</td>
										<td>{{ number_format($transaccion->transaccion_abono , 2, ',', ' ')}}</td>
										<td>{{ $transaccion->transaccion_tipo}}</td>

										@if ( is_null($transaccion->premio_id))
											<td></td>
										@else
											<td>{{ $transaccion->premio->premio_nombre}}</td>
										@endif

										@if ( is_null($transaccion->promocion_id))
											<td></td>
										@else
											<td>{{ $transaccion->promocion->promocion_nombre}}</td>
										@endif
										
										<td>{{ $transaccion->empresa->empresa_nombre}}</td>
										<td class="text-capitalize">{{ $transaccion->cliente->perfil_nombre ." ". $transaccion->cliente->perfil_apellidos}}</td>
										<td class="text-capitalize">{{ $transaccion->perfil->full_name}}</td>
										<td class="times-t">{{ $transaccion->created_at}}</td>
										<td>
										@if ( $transaccion->transaccion_tipo !=  'Cancelacion')
											<button class="confirma btn btn-danger" data-id="{{ $transaccion->id }}" data-user="{{$transaccion->cliente->id}}"  >Cancelación</button>
										@endif
										<a class="btn btn-primary" href="estado_cuenta/{{ $transaccion->id }}/especifico"> <i class="fas fa-print"></i> ReImpresión</a>
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
					<div class="modal fade" id="CancelacionModal" role="dialog">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">Motivo de Cancelación</h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body">
									<form action="" id="form-cancelacion">
										<input type="hidden" id="id">
										<div class="form-group">
											<label for="msg-cancelacion">Motivo de la cancelación</label>
											<textarea name="motivo" id="motivo" class="form-control" style="width: 100%; height: 100px; resize: none;"></textarea>
											<p class="errorMotivo text-center alert alert-danger" style="display: none;"></p>
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
									<button type="button" class="btn btn-danger cancelacion">Cancelar Transacción</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	@endsection