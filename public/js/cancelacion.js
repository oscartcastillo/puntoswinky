$(document).on('click', '.confirma', function() {
	$('#CancelacionModal').modal('show');
	$('#id').val($(this).data('id'));
});

$(document).on('click', '.cancelacion', function() {
	var id = $('#id').val();
	$.ajax({
		type: 'POST',
		url: 'cancelacion/'+id,
		data: {
			'_token': $('input[name=_token]').val(),
			'motivo': $('#motivo').val(),
		},
		success: function(data) {
			if ((data.errors)) {
				$('#CancelacionModal').modal('show');
				/*setTimeout(function () {
					toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
				}, 500);*/
				Swal.fire({
					position: 'top-end',
					icon: 'error',
					title: 'Oops...',
					text: 'Error en Cancelación!!!',
					showConfirmButton: false,
					timer: 2000
				});
				
				if (data.errors.motivo) {
					$('.errorMotivo').show();
					$('.errorMotivo').text(data.errors.motivo);
				}
				if (data.errors.negacion) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: data.errors.negacion
					});
					$('#CancelacionModal').modal('hide');
				}
			}
			else {
				//toastr.success('Transacción Cancelada!', 'Success Alert', {timeOut: 5000});
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Transaccion Realizada!!!',
					showConfirmButton: false,
					timer: 2000
				});
				
				$('#CancelacionModal').modal('hide');

				setTimeout(function() { 
						location.reload();
					},
				2200); 
				
			}
			$('#motivo').val('');
			$('#id').val('');
		},
	});
});