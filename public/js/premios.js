var empresas_get = $.ajax({
		type: 'GET',
		url: 'empresa_ajax',
		async: false,
		dataType: 'json',
		done: function(results) {
			JSON.parse(results);
			return results;
		},
		fail: function( jqXHR, textStatus, errorThrown ) {
			console.log( 'Could not get posts, server response: ' + textStatus + ': ' + errorThrown );
		}
	}).responseJSON;
$(function() {
	ocultar();

	$(document).on('click', '.add-modal', function() {
		reset();
		$('.modal-title').text('Agregar Nuevo Premio');
		$('#addModal').modal('show');
	});

	$('#imagen').change(function(e) {
		addImage(e); 
	});
	function addImage(e){
		var file = e.target.files[0],
		imageType = /image.*/;
		if (!file.type.match(imageType))
			return;
		var reader = new FileReader();
		reader.onload = fileOnload;
		reader.readAsDataURL(file);
	}

	function fileOnload(e) {
		var result=e.target.result;
		$('#imgSalida').attr("src",result);
	}

	$('#imagen_edit').change(function(e) {
		editImage(e); 
	});
	function editImage(e){
		var file = e.target.files[0],
		imageType = /image.*/;
		if (!file.type.match(imageType))
			return;
		var reader = new FileReader();
		reader.onload = fileOnload2;
		reader.readAsDataURL(file);
	}

	function fileOnload2(e) {
		var result=e.target.result;
		$('#pre_edit').attr("src",result);
	}
	$(document).ready(function (e) {
		$('#FrmImgUpload').on('submit',(function(e) {
			
			$('#addModal').modal('hide');
			
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type:'POST',
				url: 'premios',
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(data){
					if ((data.errors)) {
						setTimeout(function () {
							$('#addModal').modal('show');
							toastr.error('Error de Registro!', 'Error Alert', {timeOut: 5000});
						}, 500);

						if (data.errors.nombre) {
							$('.errorNombre').show();
							$('.errorNombre').text(data.errors.nombre);
						}
						if (data.errors.descripcion) {
							$('.errorDescripcion').show();
							$('.errorDescripcion').text(data.errors.descripcion);
						}
						if (data.errors.imagen) {
							$('.errorImagen').show();
							$('.errorImagen').text(data.errors.imagen);
						}
						if (data.errors.precio) {
							$('.errorPrecio').show();
							$('.errorPrecio').text(data.errors.precio);
						}
						if (data.errors.stock) {
							$('.errorStock').show();
							$('.errorStock').text(data.errors.stock);
						}
						if (data.errors.estatus) {
							$('.errorEstatus').show();
							$('.errorEstatus').text(data.errors.estatus);
						}
						if (data.errors.clasificacion) {
							$('.errorClasificacion').show();
							$('.errorClasificacion').text(data.errors.clasificacion);
						}
					}
					else{
						toastr.success('Premio Agregado!', 'Success Alert', {timeOut: 5000});
						
						$('#postTable').prepend('<tr id="registro'+data.id+'"><td style="display: table-cell;" class="footable-first-visible">'+data.premio_nombre+'</td><td style="display: table-cell;">'+data.premio_descripcion+'</td><td style="display: table-cell;">'+data.premio_precio+'</td><td style="display: table-cell;">'+data.premio_stock+'</td><td style="display: table-cell;">'+data.clasificacion_id+'</td><td style="display: table-cell;">'+data.premio_estatus+'</td><td style="display: table-cell;" class="footable-last-visible"><button class="show-modal btn btn-success" data-nombre = "'+data.premio_nombre+'" data-descripcion = "'+data.premio_descripcion+'" data-precio = "'+data.premio_precio+'" data-stock = "'+data.premio_stock+'" data-estatus = "'+data.premio_estatus+'" data-clasificacion = "'+data.clasificacion_id+'" data-imagen = "'+data.premio_imagen+'" data-empresa = "'+data.empresa_id+'" style="min-width: 100px; margin: 0%;"> <span class="far fa-eye" ></span> Ver </button> <button class="edit-modal btn btn-info" data-id = "'+data.id+'" data-nombre = "'+data.premio_nombre+'" data-descripcion = "'+data.premio_descripcion+'" data-precio = "'+data.premio_precio+'" data-stock = "'+data.premio_stock+'" data-estatus = "'+data.premio_estatus+'"data-clasificacion = "'+data.clasificacion_id+'" data-imagen = "'+data.premio_imagen+'" data-empresa = "'+data.empresa_id+'" style="min-width: 100px; margin: 0%;"> <span class="far fa-edit" ></span> Editar </button></td></tr>');
					}
				}
			});
		}));
	});
	$(document).on('click', '.show-modal', function() {

		$('.modal-title').text('Mostrar Producto');
		$('#nombre_show').text($(this).data('nombre'));
		$('#descripcion_show').text($(this).data('descripcion'));
		$('#precio_show').text($(this).data('precio'));
		$('#stock_show').text($(this).data('stock'));
		$('#premio_show').text($(this).data('precio'));
		var empresa = $(this).data('empresa');
		jQuery.each( empresas_get, function( i, val ) {
			if (val.id == empresa) {
				$('#empresa_show').text(val.empresa_nombre);
			}
		});
		var clasificacion = { 1:"Basica", 2:"Media", 3:"Premium"};

		$('#clasificacion_show').text(clasificacion[$(this).data('clasificacion')]);
		
		$("#imagen_show").attr("src", original+"/"+$(this).data('imagen'));
		
		$('#estatus_show').text($(this).data('estatus'));
		$('#showModal').modal('show');
	});
	$(document).on('click', '.edit-modal', function() {
		reset();
		$('.modal-title').text('Editar Producto');
		$('#id_edit').val($(this).data('id'));
		$('#nombre_edit').val($(this).data('nombre'));
		$('#descripcion_edit').val($(this).data('descripcion'));
		$('#precio_edit').val($(this).data('precio'));
		$('#stock_edit').val($(this).data('stock'));
		$("#pre_edit").attr("src", original+"/"+$(this).data('imagen'));
		$('#estatus_edit option[value='+($(this).data('estatus'))+']').attr('selected','selected');
		$('#clasificacion_edit option[value='+($(this).data('clasificacion'))+']').attr('selected','selected');
		$('#empresa_edit option[value='+($(this).data('empresa'))+']').attr('selected','selected');
		
		id = $('#id_edit').val();
		$('#editModal').modal('show');
	});
	$(document).ready(function (e) {
		$('#form_edit').on('submit',(function(e) {
			
			$('#editModal').modal('hide');
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			e.preventDefault();
			var formData2 = new FormData(this);

			//console.log(formData2[0]);
			$.ajax({
				type:'POST',
				//type : 'PUT' ,
				url: 'actualiza/'+id ,
				//url : 'premios/'+ id,
				data:formData2,
				cache:false,
				contentType: false,
				processData: false,
				success:function(data){
					if ((data.errors)) {
						setTimeout(function () {
							$('#addModal').modal('show');
							toastr.error('Error de Registro!', 'Error Alert', {timeOut: 5000});
						}, 500);

						if (data.errors.nombre) {
							$('.errorNombre').show();
							$('.errorNombre').text(data.errors.nombre);
						}
						if (data.errors.descripcion) {
							$('.errorDescripcion').show();
							$('.errorDescripcion').text(data.errors.descripcion);
						}
						if (data.errors.imagen) {
							$('.errorImagen').show();
							$('.errorImagen').text(data.errors.imagen);
						}
						if (data.errors.precio) {
							$('.errorPrecio').show();
							$('.errorPrecio').text(data.errors.precio);
						}
						if (data.errors.stock) {
							$('.errorStock').show();
							$('.errorStock').text(data.errors.stock);
						}
						if (data.errors.estatus) {
							$('.errorEstatus').show();
							$('.errorEstatus').text(data.errors.estatus);
						}
						if (data.errors.clasificacion) {
							$('.errorClasificacion').show();
							$('.errorClasificacion').text(data.errors.clasificacion);
						}
					}
					else{
						toastr.success('Premio Actualizado!', 'Success Alert', {timeOut: 5000});

						$('.item' + data.id).replaceWith('<tr id="registro'+data.id+'"><td style="display: table-cell;" class="footable-first-visible">'+data.premio_nombre+'</td><td style="display: table-cell;">'+data.premio_descripcion+'</td><td style="display: table-cell;">'+data.premio_precio+'</td><td style="display: table-cell;">'+data.premio_stock+'</td><td style="display: table-cell;">'+data.clasificacion_id+'</td><td style="display: table-cell;">'+data.premio_estatus+'</td><td style="display: table-cell;" class="footable-last-visible"><button class="show-modal btn btn-success" data-nombre = "'+data.premio_nombre+'" data-descripcion = "'+data.premio_descripcion+'" data-precio = "'+data.premio_precio+'" data-stock = "'+data.premio_stock+'" data-estatus = "'+data.premio_estatus+'" data-clasificacion = "'+data.clasificacion_id+'" data-imagen = "'+data.premio_imagen+'" data-empresa = "'+data.empresa_id+'" style="min-width: 100px; margin: 0%;"> <span class="far fa-eye" ></span> Ver </button> <button class="edit-modal btn btn-info" data-id = "'+data.id+'" data-nombre = "'+data.premio_nombre+'" data-descripcion = "'+data.premio_descripcion+'" data-precio = "'+data.premio_precio+'" data-stock = "'+data.premio_stock+'" data-estatus = "'+data.premio_estatus+'"data-clasificacion = "'+data.clasificacion_id+'" data-imagen = "'+data.premio_imagen+'" data-empresa = "'+data.empresa_id+'" style="min-width: 100px; margin: 0%;"> <span class="far fa-edit" ></span> Editar </button></td></tr>');

					}
				},
			});
		}));
	});
});

function ocultar(){
	$('.errorNombre').hide();
	$('.errorDescripcion').hide();
	$('.errorImagen').hide();
	$('.errorPrecio').hide();
	$('.errorStock').hide();
	$('.errorEstatus').hide();
	$('.errorEmpresa').hide();
	$('.errorClasificacion').hide();
}

function reset(){
	$('#nombre_add').val('');
	$('#descripcion_add').val('');
	$('#precio_add').val('');
	$('#stock_add').val('');
	$('#imagen').val('');
	$('#imgSalida').attr("src", '');

	$('#estatus_add option:selected').removeAttr('selected');
	$('#clasificacion_add option:selected').removeAttr('selected');
	$('#empresa_add option:selected').removeAttr('selected');

	$('#nombre_edit').val('');
	$('#descripcion_edit').val('');
	$('#precio_edit').val('');
	$('#stock_edit').val('');

	$('#estatus_edit option:selected').removeAttr('selected');
	$('#clasificacion_edit option:selected').removeAttr('selected');
	$('#empresa_edit option:selected').removeAttr('selected');
}