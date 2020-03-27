(function () {
	"use strict";

	$(document).ready(function(){
		//ocultar();
		$('#seach').keyup(function(){
			var dato = $(this).val();
			if( dato != ''){
				$.ajax({
					url:"cliente_ajax",
					method:"GET",
					data:{
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
	});
	$(document).on('click', '.list-group-item', function(){ 
		var valores = $(this).text();
		var nvalores = valores.split('|');
		if (nvalores.length > 1) {
			var id = $(this).find('#id').val();
			recall(id);
		}
		else{
			$('#nombre').empty();
			$('#tarjeta').empty();
			$('#telefono').empty();
		}
		$('#result').fadeOut();
	});
	$(document).on('click', '.activo', function() {

		Swal.fire({
			title: 'Da clic para confirmar',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Confirmar!'
		}).then((result) => {
			if (result.value) {
				Swal.fire(
					'Entregado!',
					'Has entregado el tiempo seleccionado.',
					'success'
					);

				$.ajax({
					type: 'POST',
					url: 'bonos',
					data: {
						'_token': $('input[name=_token]').val(),
						'user_id' : $('#user_id').val(),
						'tiempo_id': $(this).data('id')
					},
					success: function(data) {
						
						modifica_tiempo(
							data.detalle_bono_estatus, 
							data.tiempo_id,
							data.empresa_nombre,
							data.updated_at
						);
					}
				});
			}
		});
	});

	
	$(document).on('click', '.nuevo', function() {
		$.ajax({
			type: 'POST',
			url: 'genera_bono',
			data: {
				'_token': $('input[name=_token]').val(),
				'user_id' : $('#user_id').val(),
				'tipo' : $('#tipo').val(),
				'inicio' : $('#inicio').val(),
				'fin' : $('#fin').val()
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
					if (data.errors.tipo) {
						$('.errorTipo').show();
						$('.errorTipo').text(data.errors.tipo);
					}
					
					if (data.errors.inicio) {
						$('.errorInicio').show();
						$('.errorInicio').text(data.errors.inicio);
					}

					if (data.errors.fin) {
						$('.errorFin').show();
						$('.errorFin').text(data.errors.fin);
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
					recall(data.user_id);
					
					$('#tipo').val('');
					$('#inicio').val('');
					$('#fin').val('');

				}
			}
		});
	});

})();

function recall(id){

	$.ajax({
		url:"get_bonos/"+id,
		method:"GET",
		success:function(data){
			ocultar();
			if (data.bonos_vencidos != null) {
				$('.historico').show();
				$('#expiro').text(bonos_vencidos.bono_fin);
			}

			if (data.bonos == null) {
				$('.nullo').show();
			}
			
			if (data.bonos != null ) {

				$('#bono_nombre').text(data.bonos.tipo_bono.tipo_bono_nombre);
				$('#bono_inicio').text(data.bonos.bono_inicio);
				$('#bono_fin').text(data.bonos.bono_fin);

				if (data.bonos.tipo_bono_id == 1 || data.bonos.tipo_bono_id == 3) {
					$('#horario_todas_comidas').show();
					$('#desayuno').show();
					$('#comida').show();
					$('#cena').show();
				}
				
				if (data.bonos.tipo_bono_id == 2 || data.bonos.tipo_bono_id == 4) {
					$('#horario_solo_comida').show();
					$('#comida').show();
				}

				verifica_hora();

				if (data.detalle_bono.length > 0) {
					
					data.detalle_bono.forEach(function(tiempo, index) {

						var empresa = (tiempo.empresa == null ) ? '' : tiempo.empresa.empresa_nombre;
						
						modifica_tiempo(
							tiempo.detalle_bono_estatus,
							tiempo.tiempo_id,
							empresa,
							tiempo.created_at
						);
					});
				}

				$('#bono_nombre').text(data.bonos.tipo_bono.tipo_bono_nombre);
				$('#bono_inicio').text(data.bonos.bono_inicio);
				$('#bono_fin').text(data.bonos.bono_fin);
				//$('#inicio').val(data.bonos.bono_fin);
				
			}

			$('#user_id').val(data.user.id);
			$('#nombre').text(data.user.perfil.perfil_nombre + " "+ data.user.perfil.perfil_apellidos);
			$('#tarjeta').text(data.user.perfil.perfil_tarjeta);
			$('#telefono').text(data.user.perfil.perfil_telefono);
			$('#correo').text(data.user.email);
			$('#seach').val('');
			actualiza_td();
			habilitar(true);
		}
	});
}


function ocultar(){
	$('.historico').hide();
	$('.nullo').hide();
}

function verifica_hora(){

	var horaActual = moment().format('HH:mm:ss'),
		horaInicioDesayuno = moment().format('08:00:00'),
		horaFinDesayuno = moment().format('13:59:59'),
		horaInicioComida = moment().format('14:00:00'),
		horaFinComida = moment().format('16:59:59'),
		horaIniciCena = moment().format('17:00:00'),
		horaFinCena = moment().format('19:29:59');

	var boton_activo_desayuno = (horaActual >= horaInicioDesayuno && horaActual <= horaFinDesayuno) ? true : false;
	var boton_vencido_desayuno = (horaActual > horaInicioDesayuno && horaActual > horaFinDesayuno ) ? true : false;
	var boton_espera_desayuno = (horaActual < horaInicioDesayuno && horaActual < horaFinDesayuno ) ? true : false;

	var boton_activo_comida = (horaActual >= horaInicioComida && horaActual <= horaFinComida) ? true : false;
	var boton_vencido_comida = (horaActual > horaInicioComida && horaActual > horaFinComida ) ? true : false;
	var boton_espera_comida = (horaActual < horaInicioComida && horaActual < horaFinComida ) ? true : false;

	var boton_activo_cena = (horaActual >= horaIniciCena && horaActual <= horaFinCena) ? true : false;
	var boton_vencido_cena = (horaActual > horaIniciCena && horaActual > horaFinCena ) ? true : false;
	var boton_espera_cena = (horaActual < horaIniciCena && horaActual < horaFinCena ) ? true : false;


	if (boton_activo_desayuno == true ) {
		$('#btn_estatus_tiempo1').addClass('btn-success activo');
		$('#btn_estatus_tiempo1').text('Activo');
	}
	if (boton_vencido_desayuno == true) {
		$('#tiempo1').replaceWith('<h1 id="tiempo1"><del>Desayuno</del></h1>');
		$('#btn_estatus_tiempo1').attr('disabled','disabled');
		$('#btn_estatus_tiempo1').addClass('btn-danger');
		$('#btn_estatus_tiempo1').text('Vencido');
	}
	if (boton_espera_desayuno == true) {
		$('#btn_estatus_tiempo1').attr('disabled','disabled');
		$('#btn_estatus_tiempo1').addClass('btn-warning');
		$('#btn_estatus_tiempo1').text('En espera');
	}

	if (boton_activo_comida == true ) {
		$('#btn_estatus_tiempo2').addClass('btn-success activo');
		$('#btn_estatus_tiempo2').text('Activo');
	}
	if (boton_vencido_comida == true) {
		$('#tiempo2').replaceWith('<h1 id="tiempo2"><del>Comida</del></h1>');
		$('#btn_estatus_tiempo2').attr('disabled','disabled');
		$('#btn_estatus_tiempo2').addClass('btn-danger');
		$('#btn_estatus_tiempo2').text('Vencido');
	}
	if (boton_espera_comida == true) {
		$('#btn_estatus_tiempo2').attr('disabled','disabled');
		$('#btn_estatus_tiempo2').addClass('btn-warning');
		$('#btn_estatus_tiempo2').text('En espera');
	}

	if (boton_activo_cena == true ) {
		$('#btn_estatus_tiempo3').addClass('btn-success activo');
		$('#btn_estatus_tiempo3').text('Activo');
	}
	if (boton_vencido_cena == true) {
		$('#tiempo3').replaceWith('<h1 id="tiempo3"><del>Cena</del></h1>');
		$('#btn_estatus_tiempo3').attr('disabled','disabled');
		$('#btn_estatus_tiempo3').addClass('btn-danger');
		$('#btn_estatus_tiempo3').text('Vencido');
	}
	if (boton_espera_cena == true) {
		$('#btn_estatus_tiempo3').attr('disabled','disabled');
		$('#btn_estatus_tiempo3').addClass('btn-warning');
		$('#btn_estatus_tiempo3').text('En espera');
	}
}

function modifica_tiempo(estatus, id, empresa, hora){
	
	if (estatus == 'entregado') {
		
		var tiempo = $('#tiempo'+id).text();
		$('#tiempo'+id).replaceWith('<h1 id="tiempo'+id+'"><del>'+tiempo+'</del></h1>');
		$("#btn_estatus_tiempo"+id).removeClass("btn-warning btn-danger").addClass("btn-success");
		$('#btn_estatus_tiempo'+id).attr('disabled','disabled');
		$('#btn_estatus_tiempo'+id).text('Entregado');
		$('#empresa_tiempo'+id).text(empresa);
		$('#estatus_tiempo'+id).text('Entregado');
		var dt = new Date(hora);
		var time = dt.getHours() + ":" + (dt.getMinutes()<10?'0':'') + dt.getMinutes() + ":" + dt.getSeconds();
		$('#hora_tiempo'+id).text(time);
	}
}


$(document).ready(function() {
	
	$(function() {
		$('.datepicker').datepicker({
			dateFormat: 'dd-mm-yy',
			showButtonPanel: false,
			changeMonth: false,
			changeYear: false,
			beforeShowDay: $.datepicker.noWeekends,
			minDate: new Date('2020-02-16'),
			//minDate: 0,
			inline: true
		});
	});
	
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '<Ant',
		nextText: 'Sig>',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);
});

function actualiza_fechas(){

	var tipo = $('#tipo').val();
	var ultima_fecha = '';
	
	if (tipo != ''){
		$("#inicio").prop("disabled", false);

		var id = $('#user_id').val();
		
		$.ajax({
			type: 'GET',
			url: 'bonos/'+id,
			async: false,
			success: function(data) {
				ultima_fecha = data.fin;
			}
		});
	}
	else{
		$("#inicio").prop("disabled", true);
	}

	$("#inicio").val(ultima_fecha);
	
	var dateMomentObject = moment(ultima_fecha, "DD/MM/YYYY");
	var fecha_fecha = dateMomentObject.toDate();

	$('.datepicker').datepicker({
		minDate: new Date(ultima_fecha)
	});

	if ( tipo == 1 || tipo == 2 ) {
		var nueva = valida_mes(fecha_fecha);
		$("#fin").datepicker("setDate", nueva);
	}
	if ( tipo == 3 || tipo == 4 ) {

		var semanal = new Date(fecha_fecha.getFullYear(), fecha_fecha.getMonth(), fecha_fecha.getDate()+6);
		$("#fin").datepicker("setDate", semanal);
	}
}

function valida_mes(fecha){

	var mensual , mensual2 = fecha.getDate();

	if (mensual2 == 29 || mensual2 == 30 || mensual2 == 31) {
		return mensual = resta_dias(fecha);
	}
	else{
		return mensual = new Date(fecha.getFullYear(), fecha.getMonth()+1, fecha.getDate());
	}
}

function resta_dias(fecha) {

	var sumar = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate()+28);
	var ultimo_dia = new Date(sumar.getFullYear(), sumar.getMonth() + 1, 0);
	
	let dias = new Date(ultimo_dia);
	
	let options = {
		weekday: 'long'
	};
	var dia = dias.toLocaleDateString('es-MX', options);

	if (dia == 'sábado') {
		var nueva_fecha = new Date(ultimo_dia.getFullYear(), ultimo_dia.getMonth(), ultimo_dia.getDate()-1);
		return nueva_fecha;
	}
	else if (dia == 'domingo') {
		var nueva_fecha = new Date(ultimo_dia.getFullYear(), ultimo_dia.getMonth(), ultimo_dia.getDate()-2);
		return nueva_fecha;
	}
	else{
		return nueva_fecha = new Date(ultimo_dia.getFullYear(), ultimo_dia.getMonth(), ultimo_dia.getDate());
	}
}

function habilitar(parametro) {
	if (parametro == true) {
		$('#bonos').removeClass('disabledbutton');
		$('#renovar').removeClass('disabledbutton');
	}
	else{
		$('#bonos').addClass('disabledbutton');
		$('#renovar').addClass('disabledbutton');
	}
}


