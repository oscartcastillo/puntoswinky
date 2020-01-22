(function () {
	"use strict";
	var treeviewMenu = $('.app-menu');
	$('[data-toggle="sidebar"]').click(function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
	});
	$("[data-toggle='treeview']").click(function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});
	$("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');
	$("[data-toggle='tooltip']").tooltip();
})();

actualiza_td();

function actualiza_td(){
	
	$(".fecha-t").each(function(index) {
		var si = CheckDate($(this).text())
		if (si) {
			var fecha = new Date($(this).text().replace(/-/g, '\/'));
			var options = { year: 'numeric', month: 'long', day: 'numeric' };
			$(this).text(fecha.toLocaleDateString("es-MX", options));
		}
	});

	$("td:contains(B)").css({
		'color': 'red',
		'font-weight': '700',
	});

	$(".times-t").each(function(index) {
		var si = CheckDate($(this).text())
		if (si) {
			var fecha = new Date($(this).text());
			var options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute:'numeric', second: 'numeric'};
			$(this).text(fecha.toLocaleDateString("es-MX", options));
		}
	});

	$(".rol-a").each(function(index) {
		var rol = $(this).text();
		switch (rol) { 
			case 'admin': 
				$(this).text('ADMINISTRADOR');
				break;
			
			case 'super': 
				$(this).text('SUPERVISOR');
				break;
			
			case 'geren': 
				$(this).text('GERENTE');
				break;
			
			case 'cajero': 
				$(this).text('CAJERO');
				break;
		}
	});

	$(".tipo_perfil").each(function(index) {
		var tipo = $(this).text();
		switch (tipo) { 
			case '1': 
				$(this).text('Personal');
				break;
			
			case '2': 
				$(this).text('Ex Alumno');
				break;
			
			case '3': 
				$(this).text('Docente');
				break;
			
			case '4': 
				$(this).text('Alumno');
				break;

			case '5': 
				$(this).text('Externo');
				break;

			case '6': 
				$(this).text('Administrativo');
				break;
		}
	});

	$(".user-img").each(function(index) {
		
		var url = location.origin;
		
		if ($(this).hasClass('avatar-0')) {
			$(this).attr('src', url+'/img/avatar-0.png');
		}
		if ($(this).hasClass('avatar-1')) {
			$(this).attr('src', url+'/img/avatar-1.png');
		}
		if ($(this).hasClass('avatar-2')) {
			$(this).attr('src', url+'/img/avatar-2.png');
		}
		if ($(this).hasClass('avatar-3')) {
			$(this).attr('src', url+'/img/avatar-3.png');
		}
		if ($(this).hasClass('avatar-4')) {
			$(this).attr('src', url+'/img/avatar-4.png');
		}
		if ($(this).hasClass('avatar-5')) {
			$(this).attr('src', url+'/img/avatar-5.png');
		}
		if ($(this).hasClass('avatar-6')) {
			$(this).attr('src', url+'/img/avatar-6.png');
		}
		if ($(this).hasClass('avatar-7')) {
			$(this).attr('src', url+'/img/avatar-7.png');
		}
		if ($(this).hasClass('avatar-8')) {
			$(this).attr('src', url+'/img/avatar-8.png');
		}
	});

	$(".tarjeta").each(function(index) {
		var input = $(this).hasClass( "form-control");
		if (input) {
			var numero_val = $(this).val();
			if(numero_val.length > 10) {
				$(this).val('');
			}
		}
		else{
			var numero_text = $(this).text().length;
			if (numero_text > 10 ) {
				$(this).empty();
			}
		}
	});
	$(".folio_premio").each(function(index) {
		var folio = $(this).text().length;
		if (folio > 10 ) {
			$(this).empty();
		}
	});

	console.log("se actualizaron los datos");
}

(function($) {
	$.fn.inputFilter = function(inputFilter) {
		return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
			if (inputFilter(this.value)) {
				this.oldValue = this.value;
				this.oldSelectionStart = this.selectionStart;
				this.oldSelectionEnd = this.selectionEnd;
			}
			else if (this.hasOwnProperty("oldValue")) {
				this.value = this.oldValue;
				this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
			}
		});
	};
}(jQuery));

$(".entero").inputFilter(function(value) {
	return /^\d*$/.test(value);
});

function CheckDate(fecha){
    var d = new Date(fecha);
    if(d == 'Invalid Date'){
    	return false;
    }
    else{
    	return true;
    }
}


$('.numero').keypress(function (tecla) {
	if ((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 46) && (tecla.charCode != 8)) {
		return false;
	}
	else{
		var len   = $('.numero').val().length;
		var index = $('.numero').val().indexOf('.');
		if (index > 0 && tecla.charCode == 46) {
			return false;
		}
		if (index > 0) {
			var CharAfterdot = (len + 1) - index;
			if (CharAfterdot > 3) {
				return false;
			}
		}
	}
	return true;
});


