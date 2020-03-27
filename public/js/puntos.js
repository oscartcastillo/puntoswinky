$(document).ready(function(){
	ocultar();
	$('#seach').keyup(function(){
		var dato = $(this).val();
		if( dato != ''){
			var _token = $('input[name="_token"]').val();
			$.ajax({
				url:"cliente_ajax",
				method:"GET",
				data:{
					_token:_token,
					dato:dato
				},
				success:function(data){
					$('#result').fadeIn();  
					$('#result').html(data);
				}
			});
		}
		else{
			$('#result').fadeOut();
		}
	});

	$(document).on('click', '.list-group-item', function(){ 
		var valores = $(this).text();
		var nvalores = valores.split('|');
		if (nvalores.length > 1) {
			var id = $('#id').val();
			$.ajax({
				url:"get_puntos/"+id,
				method:"GET",
				success:function(data){
					$('#mov').empty();
					$('#list_premios').empty();
					$('#user_id').val(data.user.id);
					$('#nombre').text(data.user.perfil.perfil_nombre + " "+ data.user.perfil.perfil_apellidos);
					$('#tarjeta').text(data.user.perfil.perfil_tarjeta);
					$('#telefono').text(data.user.perfil.perfil_telefono);
					$('#correo').text(data.user.email);
					$('#puntos').text(data.puntos);
					var datos_premio = '';
					
					jQuery.each( data.premios, function(i, val) {
						datos_premio += '<div class="col-md-4 col-premio'+val.id+'"><div class="repo"><img class="img-fluid premio" src="./uploads/'+val.premio_imagen+'" alt=""><button type="button" class="cambio btn" data-id='+val.id+'>Cambiar</br>Premio</button><div class="info_regalo"><h3>'+val.premio_precio+' puntos</h3><h6>'+val.premio_nombre+'</h5><hr><h6 class="unidades'+val.id+'">Disponible '+val.premio_stock+' piezas</h6></div></div></div>';
					});
					
					$('#list_premios').append(datos_premio);
					
					var datos_transfe = '<table id="postTable" class="table table-hover table-bordered table-dark" data-show-toggle="true"><thead><tr><th>Ticket</th><th>Fecha</th><th data-breakpoints="xs sm">Total Ticket</th><th data-breakpoints="xs sm">Puntos S/P</th><th data-breakpoints="xs sm">Descripcion</th><th data-breakpoints="xs sm">Tipo</th><th data-breakpoints="xs sm">Puntos</th></tr></thead><tbody id="mov">';
					
					jQuery.each(data.transacciones, function(i, val) {
						datos_transfe += '<tr><td>'+val.transaccion_ticket+'</td><td>'+val.transaccion_fecha+'</td><td>'+val.transaccion_cantidad+'</td><td>'+val.transaccion_puntos_extras+'</td><td>'+val.transaccion_descripcion+'</td><td>'+val.transaccion_tipo+'</td><td>'+val.transaccion_abono+'</td></tr>';
					});
					
					datos_transfe += '</tbody></table>';
					
					$('#group_imprimir').append('<a class="btn btn-primary" href="estado_cuenta/'+data.user.id+'/general">Imprimir Estado de Cuenta</a>');
					$('#list_movimientos').append(datos_transfe);
					jQuery(function($){
						$('.table').footable({
							"paging": {
								"size": 3
							},
							"filtering": {
								"enabled": true
							},
							"sorting": {
								"enabled": true
							}
						});
					});
					$('#seach').val('');
					actualiza_td();
				}
			});
			habilitar(true);

		}
		else{
			$('#nombre').empty();
			$('#tarjeta').empty();
			$('#telefono').empty();
			habilitar(false);
		}
		$('#result').fadeOut();

	});
	
	$("#acumula").click( function() {

		var orden = $('#tickets_add').val(), fecha = $('#fecha_add').val(), sucursal = $('#sucursal_add').val();
		var ticket = fecha+"/"+sucursal+"/"+orden;
		
		$.ajax({
			type: 'POST',
			url: 'puntos',
			data: {
				'_token': $('input[name=_token]').val(),
				'user_id' : $('#user_id').val(),
				'transaccion_ticket': ticket,
				'fecha': $('#fecha_add').val(),
				'monto' : $('#monto_add').val(),
				'puntos' : $('#puntos_add').val(),
				'descripcion' : $('#descripcion_add').val(),
				'sucursal' : $('#sucursal_add').val(),
				'imprimir' : $('#imprimir:checked').val()
			},
			success: function(data) {
				
				if ((data.errors)) {

					Swal.fire({
						position: 'top-end',
						icon: 'error',
						title: 'Oops...',
						text: 'Error en Validación!!!',
						showConfirmButton: false,
						timer: 2000
					});
					
					ocultar();
					
					if (data.errors.transaccion_ticket) {
						$('.errorTicket').show();
						$('.errorTicket').text(data.errors.transaccion_ticket);
					}
					if (data.errors.monto) {
						$('.errorMonto').show();
						$('.errorMonto').text(data.errors.monto);
					}
					if (data.errors.fecha) {
						$('.errorFecha').show();
						$('.errorFecha').text(data.errors.fecha);
					}
					if (data.errors.puntos) {
						$('.errorPuntos').show();
						$('.errorPuntos').text(data.errors.puntos);
					}
					if (data.errors.descripcion) {
						$('.errorDescripcion').show();
						$('.errorDescripcion').text(data.errors.descripcion);
					}
					if (data.errors.sucursal) {
						$('.errorSucursal').show();
						$('.errorSucursal').text(data.errors.sucursal);
					}
				}
				else {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Transaccion Realizada!!!',
						showConfirmButton: false,
						timer: 2000
					});
					actualiza_tabla(data);
					actualiza_puntos(data.puntos);
					ocultar();
					reset();

					if (data.url == 'imprimir') {
						var url = location.origin;

						//console.log(url+"/transacciones/"+data.id)
						window.open(url+"/transacciones/"+data.id);
					}
				}
			},
		});
	});
	
	$(".utilizar").click( function() {

		$.ajax({
			type: 'POST',
			url: 'utilizar',
			data: {
				'_token': $('input[name=_token]').val(),
				'user_id' : $('#user_id').val(),
				'transaccion_ticket': $('#ticket_utilizar').val(),
				'importe': $('#importe_utilizar').val(),
			},
			success: function(data) {
				
				if ((data.errors)) {
					Swal.fire({
						position: 'top-end',
						icon: 'error',
						title: 'Oops...',
						text: 'Error en Validación!!!',
						showConfirmButton: false,
						timer: 2000
					});

					if (data.errors.importe) {
						$('.errorImporteUtilizar').show();
						$('.errorImporteUtilizar').text(data.errors.importe);
					}
					if (data.errors.transaccion_ticket) {
						$('.errorTicketUtilizar').show();
						$('.errorTicketUtilizar').text(data.errors.transaccion_ticket);
					}
				}
				
				else if (data.estatus == 'negado') {
					$('.error_info').text(data.mensaje);
					$('.error_puntos').show();
				}
				
				else{
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Transaccion Realizada!!!',
						showConfirmButton: false,
						timer: 5000
					});
					actualiza_tabla(data);
					actualiza_puntos(data.puntos);
					ocultar();
					reset();
				}
			},
		});
	});
	$(document).on('click', '.cambio', function() {
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: 'cambiar_premio/'+id,
			data: {
				'_token': $('input[name=_token]').val(),
				'user_id' : $('#user_id').val()
			},
			success: function(data) {
				if (data.estatus == 'negado') {
					$('.error_info').text(data.mensaje);
					$('.error_puntos').show();
				}
				else{
					//toastr.success('Premio Otorgado!!!', 'Success Alert', {timeOut: 5000});
					actualiza_tabla(data);
					actualiza_puntos(data.puntos);
					Swal.fire({
						title: 'Felicitaciones!',
						text: 'Premio Entregado '+data.premio.premio_nombre,
						imageUrl: './uploads/'+data.premio.premio_imagen,
						imageWidth: 200,
						imageHeight: 400,
						imageAlt: 'Custom image',
					});
				}
				
				if (data.premio.premio_stock == 0) {
					$('.col-premio'+data.premio.id).remove();
				}
				
				if (data.premio.premio_stock > 0){
					$('.unidades'+data.premio.id).text();
					$('.unidades'+data.premio.id).text('');
					$('.unidades'+data.premio.id).text('Disponible '+data.premio.premio_stock+' piezas');
				}
				ocultar();
				reset();
			}
		});
	});
	
});
function habilitar(parametro) {
	if (parametro == true) {
		$('#Acumular').removeClass('disabledbutton');
		$('#Utilizar').removeClass('disabledbutton');
		$('#Canejar').removeClass('disabledbutton');
		$('#Estatus').removeClass('disabledbutton');
	}
	else{
		$('#Acumular').addClass('disabledbutton');
		$('#Utilizar').addClass('disabledbutton');
		$('#Canejar').addClass('disabledbutton');
		$('#Estatus').addClass('disabledbutton');
	}
}

function ocultar(){
	$('.errorTicket').hide();
	$('.errorMonto').hide();
	$('.errorPuntos').hide();
	$('.errorDescripcion').hide();
	$('.errorFecha').hide();
	$('.errorImporteUtilizar').hide();
	$('.errorTicketUtilizar').hide();
	$('.error_puntos').hide();
	$('.errorSucursal').hide();
}

function reset(){

	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day);
	
	$('#sucursal_add option:selected').removeAttr('selected');
	$('#sucursal_add').val('');
	$('#posibles_puntos').val(0);
	
	$('#tickets_add').val('');
	$('#fecha_add').val(today);
	$('#monto_add').val('');
	$('#puntos_add').val('');
	$('#descripcion_add').val('');
	$('#ticket_utilizar').val('');
	$('#importe_utilizar').val('');
}

function actualiza_puntos(puntos){

	$('#puntos').text();
	$('#puntos').text('');
	$('#puntos').text(puntos);
}

function actualiza_tabla(data){
	$('#postTable').prepend('<tr><td style="display: table-cell;" class="footable-first-visible">'+data.transaccion_ticket+'</td><td style="display: table-cell;">'+data.transaccion_fecha+'</td><td style="display: table-cell;">'+data.transaccion_cantidad+'</td><td style="display: table-cell;">'+data.transaccion_puntos_extras+'</td><td style="display: table-cell;">'+data.transaccion_descripcion+'</td><td style="display: table-cell;">'+data.transaccion_tipo+'</td><td style="display: table-cell;" class="footable-last-visible">'+data.transaccion_abono+'</td></tr>');
}

$("#monto_add").keyup(function () {
	var value = $(this).val(), puntos_add = 0;
	if (value != '' && $.isNumeric(value)) {

		puntos_add = (value * 0.05).toFixed(2); 

		$('#posibles_puntos').val(puntos_add);
	}
});
