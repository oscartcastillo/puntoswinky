$(document).ready(function(){
	
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
			}
		});
	});
});