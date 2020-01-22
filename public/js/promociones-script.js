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

	actualiza_td();
	
	$( "#calendario" ).load('calendario');
	$('.colorselector').colorselector({
		callback: function (value, color, title) {
			$("#color_add").val(color);
			$("#color_edit").val(color);
		}
	});
	$(document).on('click', '.add-modal', function() {
		var add = 'add';
		dias(false, add);
		empresas(false, add);
		borrar(add);
		ocultar();
		$('#addModal').modal('show');
		$('.modal-title').text('Nueva Promoción');
	});
	$('.modal-footer').on('click', '.add', function() {
			
		var dias_array = [];
		$("#dias input:checkbox:checked").map(function(){
			dias_array.push($(this).val());
		});

		var empresas = [];
		$("#div_empresas_add input:checkbox:checked").map(function(){
			empresas.push($(this).val());
		});

		$.ajax({
			type: 'POST',
			url: 'promociones',
			data: {
				'_token': $('input[name=_token]').val(),
				'nombre' : $('#nombre_add').val(),
				'codigo' : $('#codigo_add').val(),
				'tipo' : $('#tipo_add').val(),
				'cantidad' : $('#cantidad_add').val(),
				'inicio' : $('#inicio_add').val(),
				'fin' : $('#fin_add').val(), 
				'repetir' : $('#repetir_add').val(),
				'estatus' : $('#estatus_add').val(),
				'color' : $('#color_add').val(),
				'dias' :  dias_array,
				'empresas': empresas,
			},
			success: function(data) {
				if ((data.errors)) {
					setTimeout(function () {
						$('#addModal').modal('show');
						toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
					}, 500);
					if (data.errors.nombre) {
						$('.errorNombre').show();
						$('.errorNombre').text(data.errors.nombre);
					}
					if (data.errors.codigo) {
						$('.errorCodigo').show();
						$('.errorCodigo').text(data.errors.codigo);
					}
					if (data.errors.tipo) {
						$('.errorTipo').show();
						$('.errorTipo').text(data.errors.tipo);
					}
					if (data.errors.cantidad) {
						$('.errorCantidad').show();
						$('.errorCantidad').text(data.errors.cantidad);
					}
					if (data.errors.inicio) {
						$('.errorInicio').show();
						$('.errorInicio').text(data.errors.inicio);
					}
					if (data.errors.fin) {
						$('.errorFin').show();
						$('.errorFin').text(data.errors.fin);
					}
					if (data.errors.repetir) {
						$('.errorRepetir').show();
						$('.errorRepetir').text(data.errors.repetir);
					}
					if (data.errors.estatus) {
						$('.errorEstatus').show();
						$('.errorEstatus').text(data.errors.estatus);
					}
					if (data.errors.color) {
						$('.errorColor').show();
						$('.errorColor').text(data.errors.color);
					}
					if (data.errors.empresas) {
						$('.errorEmpresas').show();
						$('.errorEmpresas').text(data.errors.empresas);
					}
				}
				else {

					toastr.success('Usuario agregado con Exito!', 'Success Alert', {timeOut: 5000});
					$('#postTable').prepend("<tr class='item" + data.id + "'><td style='display: table-cell;' class='footable-first-visible'>" + data.nombre + "</td><td style='display: table-cell; text-transform: capitalize;'>" +data.codigo+ "</td><td class='text-uppercase' style='display: table-cell;'>" + data.tipo + "</td><td style='display: table-cell;'>" + data.cantidad + "</td><td style='display: table-cell;'>"+ data.estatus +"</td><td style='display: table-cell;' class='footable-last-visible'><button class='show-modal btn btn-success' data-repetir = '" + data.repetir + "' data-dias = '" + data.dias_id + "' data-color = '" + data.color + "' data-inicio = '" + data.inicio + "' data-fin = '" + data.fin + "'data-diasnombres = '" + data.dias + "' data-empresa = '" + data.empresas + "' style='min-width: 100px; margin: 0%;'> <span class='glyphicon glyphicon-eye-open'></span> Ver </button> <button class='edit-modal btn btn-info' data-id='"+data.id+"' data-nombre= '" + data.nombre + "' data-codigo= '" + data.codigo + "' data-tipo= '" + data.tipo + "' data-cantidad= '" + data.cantidad + "' data-estatus= '" + data.estatus + "' data-repetir= '" + data.repetir + "' data-dias= '" + data.dias_id + "' data-diasnombres= '" + data.dias + "' data-color= '" + data.color + "' data-inicio= '" + data.inicio + "' data-fin= '" + data.fin + "' data-empresa = '" + data.empresas + "' style='min-width: 100px; margin: 0%;'> <span class='glyphicon glyphicon-edit'></span> Editar </button></td></tr>");
					$("#calendario").empty();
					$("#calendario").load('calendario').fadeIn('slow');
					actualiza_td();
				}
			},
		});
	});

	$(document).on('click', '.show-modal', function() {
		$('#dias_show').empty();
		$('#repetir_show').empty();
		$('#empresas_show').empty();
		$('.description').empty();
		$('.modal-title').text('Promocion');
		
		var data_d = $(this).data('diasnombres');
		var dias_db = "";
		var repetir = "";
		var empresa_db = "";
		
		var empresa = $(this).data('empresa');
		
		if ( data_d == "") {
			dias_db = "<h5>No hay dias seleccionados<h5>";
		}
		else{
			var dias_split = data_d.split(",");
			for (var i = 0; i < dias_split.length; i++) {
				dias_db += "<h5 class='text-capitalize'>" + dias_split[i] + "</h5>";
			}
		}
		if ($(this).data('repetir') == 'A') {
			repetir = "<h5>Cada Año</h5>";
		}
		else{
			repetir = "<h5>Dias seleccionados dentro del rango de fechas seleccionadas</h5>";
		}
		//escribir
		$("#dias_show").append(dias_db);
		$('#repetir_show').append(repetir);
		$('#color_show').css({
			"background-color": $(this).data('color'),
			"height" : "30px"
		});
		$('#inicio_show').text( $(this).data('inicio') );
		$('#fin_show').text( $(this).data('fin') );
		if (empresa.length > 1) {
			var empresa_split = empresa.split(",");
			jQuery.each( empresas_get, function( i, val ) {
				for (var i = 0; i < empresa.length; i++) {
					if (val.id == empresa[i]) {
						empresa_db += "<h5 class='text-capitalize'>"+ val.empresa_nombre +" </h5>";
					}
				}
			});
		}
		else{
			jQuery.each( empresas_get, function( i, val ) {
				if (val.id == empresa) {
					empresa_db += "<h5 class='text-capitalize'>"+ val.empresa_nombre +" </h5>";
				}
			});
		}
		$('#empresas_show').append(empresa_db);
		$('#showModal').modal('show');
	});
	$(document).on('click', '.edit-modal', function() {

		var edit = 'edit';
		var empresas_input = "";
		
		$('.modal-title').text('Editar');
		$('#id_edit').val($(this).data('id'));
		$('#nombre_edit').val($(this).data('nombre'));
		$('#codigo_edit').val($(this).data('codigo'));
		$('#cantidad_edit').val($(this).data('cantidad'));
		$('#inicio_edit').val($(this).data('inicio').split(' ')[0]);
		$('#fin_edit').val($(this).data('fin').split(' ')[0]);

		$('#estatus_edit option:selected').removeAttr('selected');
		$('#estatus_edit option[value='+($(this).data('estatus'))+']').attr('selected','selected');

		$('#tipo_edit option:selected').removeAttr('selected');
		$('#tipo_edit option[value='+($(this).data('tipo'))+']').attr('selected','selected');
		
		$('#repetir_edit option:selected').removeAttr('selected');
		$('#repetir_edit option[value='+($(this).data('repetir'))+']').attr('selected','selected');

		var info_data = fecha_change('recargar', edit);
		var selected = $('#repetir_edit').find(':selected');
		$('#info_edit').text(selected.data('description'));
		
		$('#dias_edit').empty();

		$('#dias_edit').append('<label class="form-check-label"><input class="form-check-input" type="checkbox" name="dias_edit[]" value="lunes" />Lunes</label><br><label class="form-check-label"><input class="form-check-input" type="checkbox" name="dias_edit[]" value="martes" />Martes</label><br><label class="form-check-label"><input class="form-check-input" type="checkbox" name="dias_edit[]" value="miércoles" />Miercoles </label><br><label class="form-check-label"><input class="form-check-input" type="checkbox" name="dias_edit[]" value="jueves" />Jueves </label> <br> <label class="form-check-label"><input class="form-check-input" type="checkbox" name="dias_edit[]" value="viernes" />Viernes </label> <br> <label class="form-check-label"> <input class="form-check-input" type="checkbox" name="dias_edit[]" value="sábado" />Sabado </label> <br> <label class="form-check-label"> <input class="form-check-input" type="checkbox" name="dias_edit[]" value="domingo" />Domingo </label><br>');

		if (info_data == 'D') {
			var dias_edit = $(this).data('diasnombres').split(',');
			var dia_semana = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"];

			for (var i = 0; i < dias_edit.length ; i++) {
				if (dia_semana.includes(dias_edit[i]) == true) {
					$('input:checkbox[name="dias_edit[]"][value="'+dias_edit[i]+'"]').attr('checked', true);
				}
			}
		}
		else{
			dias(false, edit);
			$('input:checkbox[name="dias_'+edit+'\[\]"]').attr('checked', true);
			$('input:checkbox[name="dias_'+edit+'\[\]"]').attr('disabled', true);
		}

		var otra_variable = $('#edit_color').find('.btn-colorselector').removeAttr('style');
		$('.dropdown-menu > li').find('.selected').removeClass('selected');
		$('.dropdown-menu > li').find('[data-color="'+ $(this).data('color') +'"]').addClass('selected');
		
		otra_variable.css({
			"background-color": $(this).data('color'),
		});

		$('#color_edit').val($(this).data('color'))

		$('#div_empresas_edit').empty();

		jQuery.each( empresas_get, function( i, val ) {
			empresas_input += "<label class='form-check-label'><input class='form-check-input' type='checkbox' name='empresas_edit[]' value='"+val.id+"' />"+val.empresa_nombre+"</label><br>";
		});

		$('#div_empresas_edit').append(empresas_input);

		var empresa = $(this).data('empresa');

		if (empresa.length > 1) {
			var empresa_split = empresa.split(",");

			jQuery.each( empresas_get, function( i, val ) {
				for (var i = 0; i < empresa.length; i++) {
					if (empresa_split[i] == val.id ) {
						$('input:checkbox[name="empresas_edit[]"][value="'+empresa_split[i]+'"]').attr('checked', true);
					}
				}
			});
		}
		else{
			jQuery.each( empresas_get, function( i, val ) {
				if (empresa == val.id ) {
					$('input:checkbox[name="empresas_edit[]"][value="'+empresa+'"]').attr('checked', true);
				}
			});
		}

		id = $('#id_edit').val();
		ocultar();
		$('#editModal').modal('show');

	});
	$('.modal-footer').on('click', '.edit', function() {

		var dias_array = [];
		var empresas = [];
		
		$("#dias_edit input:checkbox:checked").map(function(){
			dias_array.push($(this).val());
		});
		
		$("#div_empresas_edit input:checkbox:checked").map(function(){
			empresas.push($(this).val());
		});
	    
	    $.ajax({
	        type: 'PUT',
	        url: 'promociones/' + id,
	        data: {
	            '_token': $('input[name=_token]').val(),
				'nombre' : $('#nombre_edit').val(),
				'promocion_codigo' : $('#codigo_edit').val(),
				'tipo' : $('#tipo_edit').val(),
				'cantidad' : $('#cantidad_edit').val(),
				'inicio' : $('#inicio_edit').val(),
				'fin' : $('#fin_edit').val(),
				'repetir' : $('#repetir_edit').val(),
				'estatus' : $('#estatus_edit').val(),
				'color' : $('#color_edit').val(),
				'dias' :  dias_array,
				'empresas': empresas
	        },
	        success: function(data) {

	            if ((data.errors)) {
	                setTimeout(function () {
	                    $('#editModal').modal('show');
	                    toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
	                }, 500);

	                if (data.errors.nombre) {
						$('.errorNombre').show();
						$('.errorNombre').text(data.errors.nombre);
					}
					if (data.errors.promocion_codigo) {
						$('.errorCodigo').show();
						$('.errorCodigo').text(data.errors.promocion_codigo);
					}
					if (data.errors.tipo) {
						$('.errorTipo').show();
						$('.errorTipo').text(data.errors.tipo);
					}
					if (data.errors.cantidad) {
						$('.errorCantidad').show();
						$('.errorCantidad').text(data.errors.cantidad);
					}
					if (data.errors.inicio) {
						$('.errorInicio').show();
						$('.errorInicio').text(data.errors.inicio);
					}
					if (data.errors.fin) {
						$('.errorFin').show();
						$('.errorFin').text(data.errors.fin);
					}
					if (data.errors.repetir) {
						$('.errorRepetir').show();
						$('.errorRepetir').text(data.errors.repetir);
					}
					if (data.errors.estatus) {
						$('.errorEstatus').show();
						$('.errorEstatus').text(data.errors.estatus);
					}
					if (data.errors.color) {
						$('.errorColor').show();
						$('.errorColor').text(data.errors.color);
					}
					if (data.errors.empresas) {
						$('.errorEmpresas').show();
						$('.errorEmpresas').text(data.errors.empresas);
					}
				}
				else {
					toastr.success('Usuario Editado con Exito!', 'Success Alert', {timeOut: 5000});


					if (data.fin == null) {
						var fin = '';
					}
					else{
						var fin = data.fin;
					}

					$('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td style='display: table-cell;' class='footable-first-visible'>" + data.nombre + "</td><td style='display: table-cell; text-transform: capitalize;'>" +data.promocion_codigo+ "</td><td class='text-uppercase' style='display: table-cell;'>" + data.tipo + "</td><td style='display: table-cell;'>" + data.cantidad + "</td><td class='red' style='display: table-cell;'>"+ data.estatus +"</td><td style='display: table-cell;' class='footable-last-visible'><button class='show-modal btn btn-success' data-repetir = '" + data.repetir + "' data-dias = '" + data.dias_id + "' data-color = '" + data.color + "' data-inicio = '" + data.inicio + "' data-fin = '" + fin + "'data-diasnombres = '" + data.dias + "' data-empresa = '" + data.empresas + "' style='min-width: 100px; margin: 0%;'> <span class='glyphicon glyphicon-eye-open'></span> Ver </button> <button class='edit-modal btn btn-info' data-id='"+data.id+"' data-nombre= '" + data.nombre + "' data-codigo= '" + data.promocion_codigo + "' data-tipo= '" + data.tipo + "' data-cantidad= '" + data.cantidad + "' data-estatus= '" + data.estatus + "' data-repetir= '" + data.repetir + "' data-dias= '" + data.dias_id + "' data-diasnombres= '" + data.dias + "' data-color= '" + data.color + "' data-inicio= '" + data.inicio + "' data-fin= '" + fin + "' data-empresa = '" + data.empresas + "' style='min-width: 100px; margin: 0%;'> <span class='glyphicon glyphicon-edit'></span> Editar </button></td></tr>");
					$("#calendario").empty();
					$("#calendario").load('calendario').fadeIn('slow');

					$("#form-edit").trigger("reset");
					$('#estatus_edit option:selected').removeAttr('selected');
					$('#tipo_edit option:selected').removeAttr('selected');
					$('#repetir_edit option:selected').removeAttr('selected');
					actualiza_td();
				}
			}
		});
	});

});
function borrar(option){
	$('#nombre_'+option).val('');
	$('#codigo_'+option).val('');
	$('#tipo_'+option).val('');
	$('#cantidad_'+option).val('');
	$('#inicio_'+option).val('');
	$('#fin_'+option).val('');
	$('#repetir_'+option).val('');
	$('#estatus_'+option).val('');
	$('#color_'+option).val('');
}

function ocultar(){
	$('.description').empty();
	$('.errorNombre').hide();
	$('.errorCodigo').hide();
	$('.errorTipo').hide();
	$('.errorCantidad').hide();
	$('.errorInicio').hide();
	$('.errorFin').hide();
	$('.errorRepetir').hide();
	$('.errorDias').hide();
	$('.errorEmpresas').hide();
	$('.errorColor').hide();
	$('.errorEstatus').hide();
}

function fecha_change(value, view){
	
	var repetir = $('#repetir_'+ view).val();
	var inicio = $('#inicio_'+ view).val();
	var fin = $('#fin_'+ view).val();

	var info_data = '';

	var $selected = $('#repetir_'+ view).find(':selected');
	$('.description').html($selected.data('description'));

	switch (repetir) {
		case "A":
			dias(false, view);
			$('input:checkbox[name="dias_'+view+'\[\]"]').attr('disabled', true);
			$('#div_fin_'+view).hide();
			return info_data = 'A';
			
		break;
		case "D":
			dias(true, view);
			//$('input:checkbox[name="dias_'+view+'\[\]"]').attr('disabled', false);
			
			$('#div_fin_'+view).show();
			
			if (inicio != '') {
				$('#fin_'+view).attr("min", $('#inicio_'+view).val());

				var fechaInicio = new Date($('#inicio_'+view).val());
				var fechaFin    = new Date($('#fin_'+view).val());

				$('input:checkbox[name="dias_'+view+'\[\]"]').attr('disabled', true);

				while(fechaFin.getTime() >= fechaInicio.getTime()){
					fechaInicio.setDate(fechaInicio.getDate() + 1);
					var fecha = fechaInicio.getFullYear() + '/' + (fechaInicio.getMonth() + 1) + '/' + fechaInicio.getDate();
					diaSemana(fecha, view); //2019/02/24
				}

				if($('#inicio_'+view).val() > $('#fin_'+view).val()){
					$("#fin_"+view).val("YYYY-MM-DD");
				}
			}
			return info_data = 'D';
		break;
	}
}

function diaSemana(x, view) {
	let date = new Date(x.replace(/-+/g, '/'));
	let options = {
		weekday: 'long'
	};
	var fecha_dia = date.toLocaleDateString('es-MX', options); //lunes
	var dia_semana = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"];
	if (dia_semana.includes(fecha_dia) == true) {
		$('input:checkbox[name="dias_'+view+'[]"][value="'+fecha_dia+'"]').attr('disabled', false);
	}
}

function dias(source, option) {
	checkboxes = document.getElementsByName('dias_'+option+'[]');
	for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	}
}
function empresas(source, option) {
	checkboxes = document.getElementsByName('empresas_'+option+'[]');
	for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	}
}