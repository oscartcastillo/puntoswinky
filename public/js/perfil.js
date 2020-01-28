$(document).ready(function (e) {
	
	var url = location.origin;
	
	$('#form-avatar').on('submit',(function(e) {	
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			type:'POST',
			url: 'perfil',
			data:formData,
			cache:false,
			dataType: 'json',
			contentType: false,
			processData: false,
			success:function(data){
				avatar(data.avatar);
				$('#exampleModalCenter').modal('hide');
			}
		});
	}));

	$(document).on('click', '.change_pass', function() {
		$.ajax({
			type: 'POST',
			url: 'reset_pass',
			data: {
				'_token': $('input[name=_token]').val(),
				'password_anterior' : $('#password_prev').val(),
				'password_nueva' : $('#password_new').val(),
				'password_repetir' :$('#password_repeat').val()
			},
			success: function(data) {

				$('.errorPassword').hide();
				$('.errorPasswordNueva').hide();
				$('.errorPasswordNuevaRepeat').hide();

				if ((data.errors)) {
					Swal.fire({
						position: 'top-end',
						icon: 'error',
						title: 'Oops...',
						text: 'Error en Validación!!!',
						showConfirmButton: false,
						timer: 2000
					});
					if (data.errors.password_anterior) {
						$('.errorPassword').show();
						$('.errorPassword').text(data.errors.password_anterior);
					}
					
					if (data.errors.incorrecta) {
						$('.errorPassword').show();
						$('.errorPassword').text(data.errors.incorrecta);
					}
					
					if (data.errors.password_nueva) {
						$('.errorPasswordNueva').show();
						$('.errorPasswordNueva').text(data.errors.password_nueva);
					}

					if (data.errors.password_repetir) {
						$('.errorPasswordNuevaRepeat').show();
						$('.errorPasswordNuevaRepeat').text(data.errors.password_repetir);
					}
				}
				else{

					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Actualización Realizada!!!',
						showConfirmButton: false,
						timer: 2000
					});

					$('#password_prev').val('');
					$('#password_new').val('');
					$('#password_repeat').val('');
					
				}
			}
		});
	});
});

