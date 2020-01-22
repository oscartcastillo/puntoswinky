$(document).ready(function(){
	
	$(document).on('click', '.open_modal', function(){
		var type = $(this).data('operation');
		$('#exampleModalLabel').text('');
		$('#edit_empresas').hide();
		$('#create_empresa').hide();
		$('#crea_ciudad').hide();
		$('#edit_clasificacion').hide();
		
		switch(type) {
			case 1://crear empresa
				$('#exampleModalLabel').text('Crear Empresas');
				$('#create_empresa').show();
			break;
			
			case 2://editar empresa
				$('#exampleModalLabel').text('Editar Empresas');
				$('#edit_empresas').show();
			break;

			case 3://crear ciudad
				$('#exampleModalLabel').text('Crear Ciudad');
				$('#crea_ciudad').show();
			break;

			case 4://crear ciudad
				$('#exampleModalLabel').text('Editar Clasificaciones');
				$('#edit_clasificacion').show();
			break;
		}
		$('#general').modal('show');
	});
	$(document).on('click', '#btn_create_empresas', function(){

		$.ajax({
			type: 'POST',
			url: 'config',
			data: {
				'_token': $('input[name=_token]').val(),
				'empresa_nombre' : $('#empresa_nombre').val(),
				'empresa_ubicacion' : $('#empresa_ubicacion').val(),
				'empresa_cp' : $('#empresa_cp').val(),
				'empresa_numero' : $('#empresa_numero').val(),
				'empresa_ciudad' : $('#empresa_ciudad').val(),
				'nameConfig' : 1
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

					if (data.errors.empresa_nombre) {
						$('.errorNombre').show();
						$('.errorNombre').text(data.errors.empresa_nombre);
					}
					if (data.errors.empresa_ubicacion) {
						$('.errorUbicacion').show();
						$('.errorUbicacion').text(data.errors.empresa_ubicacion);
					}
					if (data.errors.empresa_cp) {
						$('.errorCp').show();
						$('.errorCp').text(data.errors.empresa_cp);
					}
					if (data.errors.empresa_numero) {
						$('.errorTelefono').show();
						$('.errorTelefono').text(data.errors.empresa_numero);
					}
					if (data.errors.empresa_ciudad) {
						$('.errorCiudad').show();
						$('.errorCiudad').text(data.errors.empresa_ciudad);
					}
				}
				else{

					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Transaccion Realizada!!!',
						showConfirmButton: false,
						timer: 2000
					});

					$('#tbody-empresas').prepend('<tr><td>'+data.empresa_nombre+'</td><td>'+data.empresa_ubicacion+'</td><td>'+data.empresa_cp+'</td><td>'+data.empresa_numero+'</td><td>'+data.ciudad_nombre+'</td></tr>');

					$('#general').modal('hide');

					reset();
				}
			}
		});
	});
	$(document).ready(function (e) {
		$('#form_edit_clasificacion').on('submit',(function(e) {
				
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			e.preventDefault();
			
			var formData = new FormData(this);
			
			var respuesta = valida_clasificacion();
			console.log(respuesta);
		
			if (respuesta) {

				$.ajax({
					type:'POST',
					url: 'actualiza_clasificacion',
					data:formData,
					cache:false,
					dataType: 'json',
					contentType: false,
					processData: false,
					success:function(data){

						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Actualización Realizada!!!',
							showConfirmButton: false,
							timer: 2000
						});

						var modal_clasificacion, tbody_clasificacion;

						$('#tbody-clasificacion').empty();
						$('#modal-clasificacion').empty();

						jQuery.each(data, function(i, val) {

							modal_clasificacion += '<div class="row"><input type="hidden" name="dato['+val.id+'][id]" value="'+val.id+'"><div class="col-md-4"><div class="form-group"><h4><strong>'+val.clasificacion_nombre+'</strong></h4></div></div><div class="col-md-4"><div class="form-group"><input class="form-control" type="text" name="dato['+val.id+'][clasificacion_min]" id="min-'+val.id+'" value="'+val.clasificacion_min+'" required="required" readonly="" style="pointer-events: none;"><p class="errorMin-'+val.id+' text-center alert alert-danger" style="display: none;"></p></div></div><div class="col-md-4"><div class="form-group"><input class="form-control" type="text" name="dato['+val.id+'][clasificacion_max]" id="max-'+val.id+'" value="'+val.clasificacion_max+'" required="required"><p class="errorMax-'+val.id+' text-center alert alert-danger" style="display: none;"></p></div></div></div>';

							tbody_clasificacion += '<tr><td>'+val.clasificacion_nombre+'</td><td>'+val.clasificacion_min+'</td><td>'+val.clasificacion_max+'</td></tr>';

						});

						$('#tbody-clasificacion').prepend(tbody_clasificacion);
						$('#modal-clasificacion').prepend(modal_clasificacion);

						$('#general').modal('hide');
					}
				});
			}
		}));
	});

	$(document).ready(function (e) {
		$('#form_edit_empresa').on('submit',(function(e) {
				
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			e.preventDefault();
			var formData = new FormData(this);

			$.ajax({
				type:'POST',
				url: 'actualiza_empresa',
				data:formData,
				cache:false,
				dataType: 'json',
				contentType: false,
				processData: false,
				success:function(data){

					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Actualización Realizada!!!',
						showConfirmButton: false,
						timer: 2000
					});

					var modal_empresas, tbody_empresas;

					$('#tbody-empresas').empty();
					$('#modal-empresas').empty();

					jQuery.each(data, function(i, val) {

						modal_empresas += '<div class="row"><input type="hidden" name="dato['+val.id+'][id]" value="'+val.id+'"><div class="col-md-3"><div class="form-group"><input class="form-control" type="text" name="dato['+val.id+'][empresa_nombre]" value="'+val.empresa_nombre+'" required="required"></div></div><div class="col-md-3"><div class="form-group"><input class="form-control" type="text" name="dato['+val.id+'][empresa_ubicacion]" value="'+val.empresa_ubicacion+'" required="required"></div></div><div class="col-md-3"><div class="form-group"><input class="form-control" type="text" name="dato['+val.id+'][empresa_cp]" value="'+val.empresa_cp+'" required="required"></div></div><div class="col-md-3"><div class="form-group"><input class="form-control" type="text" name="dato['+val.id+'][empresa_numero]" value="'+val.empresa_numero+'" required="required"></div></div></div>';

						tbody_empresas += '<tr><td>'+val.empresa_nombre+'</td><td>'+val.empresa_ubicacion+'</td><td>'+val.empresa_cp+'</td><td>'+val.empresa_numero+'</td><td>'+val.ciudad.ciudad_nombre+'</td></tr>';

					});
					
					$('#modal-empresas').append(modal_empresas);
					$('#tbody-empresas').append(tbody_empresas);

					$('#general').modal('hide');
				}
			});
		}));
	});

	$(document).on('click', '#btn_create_ciudad', function(){

		$.ajax({
			type: 'POST',
			url: 'config',
			data: {
				'_token': $('input[name=_token]').val(),
				'ciudad_nombre' : $('#ciudad_nombre').val(),
				'nameConfig' : 2
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

					if (data.errors.ciudad_nombre) {
						$('.errorCiudad').show();
						$('.errorCiudad').text(data.errors.ciudad_nombre);
					}
				}
				else{

					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Transaccion Realizada!!!',
						showConfirmButton: false,
						timer: 2000
					});

					$('#tbody-ciudades').prepend('<tr><td>'+data.ciudad_nombre+'</td></tr>');

					$('#general').modal('hide');

					var select = $('#empresa_ciudad');
					select.empty();

					select.append('<option value="">Seleccione la ciudad</option>');
					$.each(data.empresas,function(key, value) {
						select.append('<option value=' + value.id + '>' + value.ciudad_nombre + '</option>');
					});

					reset();
				}
			}
		});
	});

	$(document).on('click', '.save-config', function(){
		var
		tipo = $(this).data('operation'),
		vigencia = $('#vigencia').val(),
		reset_clasificacion = $('#reset_clasificacion').val(),
		puntos_iniciales = $('#puntos_iniciales').val();			

		$.ajax({
			type: 'POST',
			url: 'config',
			data: {
				'_token': $('input[name=_token]').val(),
				'vigencia' : vigencia,
				'puntos_iniciales' : puntos_iniciales,
				'reset_clasificacion' : reset_clasificacion,
				'nameConfig' : tipo
			},
			success: function(data) {

				$('.errorVigencia').hide();
				$('.errorPuntos').hide();
				$('.errorResetClasificacion').hide();
				
				if ((data.errors)) {
					
					Swal.fire({
						position: 'top-end',
						icon: 'error',
						title: 'Oops...',
						text: 'Error!!!',
						showConfirmButton: false,
						timer: 2000
					});

					if (data.errors.vigencia) {
						$('.errorVigencia').show();
						$('.errorVigencia').text(data.errors.vigencia);
					}
					if (data.errors.puntos_iniciales) {
						$('.errorPuntos').show();
						$('.errorPuntos').text(data.errors.puntos_iniciales);
					}
					if (data.errors.puntos_iniciales) {
						$('.errorResetClasificacion').show();
						$('.errorResetClasificacion').text(data.errors.puntos_iniciales);
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
				}
			}
		});
	});

	function reset()
	{
		$('#empresa_nombre').val('');
		$('#empresa_ubicacion').val('');
		$('#empresa_cp').val('');
		$('#empresa_numero').val('');
		$('#ciudad_nombre').val('');
		$('#empresa_ciudad option:selected').removeAttr('selected');
	}

	function valida_clasificacion()
	{
		var min1 = parseInt($('#min-1').val()),
		max1 = parseInt($('#max-1').val()) ,
		max2 = parseInt($('#max-2').val()),
		max3 = parseInt($('#max-3').val());

		var estatus = true;

		$('#errorMax-1').empty().hide();
		$('#errorMax-2').empty().hide();
		$('#errorMax-3').empty().hide();

		if (max1 == min1 ) {
			$('.errorMax-1').show();
			$('.errorMax-1').text('Error');
			estatus = false;
		}
		if (max1 > max2) {
			$('.errorMax-1').show();
			$('.errorMax-2').text('La clasificacion inicial no deben superar los puntos de Media');
			estatus = false;
		}
		if (max1 > max3) {
			$('.errorMax-1').show();
			$('.errorMax-1').text('La clasificacion inicial no deben superar los puntos de Premium');
			estatus = false;
		}
		if (max2 > max3) {
			$('.errorMax-2').show();
			$('.errorMax-2').text('La clasificacion Media no deben superar los puntos de Premium');
			estatus = false;
		}
		console.log(max2 +" > " + max3);

		return estatus;
	}
});

$("#max-1").keyup(function () {
	var value = $(this).val();
	$('#min-2').val(parseInt(value) + parseInt(1));
});

$("#max-2").keyup(function () {
	var value = $(this).val();
	$('#min-3').val(parseInt(value) + parseInt(1));
});


