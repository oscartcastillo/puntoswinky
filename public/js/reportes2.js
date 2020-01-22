function destroy_table(){
    $('#div-body').empty();
    $('#div-body').append('<table id="example" class="table table-hover table-striped table-bordered table-dark" cellspacing="0" width="100%"><thead id="thead"><th></th></thead><tbody id="tbody"><td></td></tbody></table>');
}

function exportar(){
	$('#example').DataTable({
		"responsive": true,
		"language": {
			"decimal": "",
			"emptyTable": "No hay información",
			"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
			"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
			"infoFiltered": "(Filtrado de _MAX_ total entradas)",
			"infoPostFix": "",
			"thousands": ",",
			"lengthMenu": "Mostrar _MENU_ Entradas",
			"loadingRecords": "Cargando...",
			"processing": "Procesando...",
			"search": "Buscar:",
			"zeroRecords": "Sin resultados encontrados",
			"paginate": {
				"first": "Primero",
				"last": "Ultimo",
				"next": "Siguiente",
				"previous": "Anterior"
			}
		},
		"processing": true,

		"pageLength": 10,
		"dom": 'lBfrtip',
		"paging": true,
		"autoWidth": true,
		"buttons": [{
			extend: 'collection',
			text: 'Export',
			buttons: [
				{
					extend: 'excel',
					messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.'
				},
				{
					text: 'Custom PDF',
					extend: 'pdfHtml5',
					filename: 'dt_custom_pdf',
					download: 'open',
					pageSize: 'A4',
					exportOptions: {
						columns: ':visible',
						search: 'applied',
						order: 'applied'
					},
					customize: function (doc) {
						doc.content.splice(0,1);
						var now = new Date();
						var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();

						var logo = 'data:image/jpeg;base64,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AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD//Z';
						doc.pageMargins = [20,100,20,30];
						doc.defaultStyle.fontSize = 7;
						doc.styles.tableHeader.fontSize = 7;
						doc['header']=(function() {
							return {
								columns: [
									{
										image: logo,
										width: 100
									},
									{
										alignment: 'left',
										text: 'Winky Coffee' + '\n' + 'Dirección : 3 sur 5758 El cerrito' + '\n' + 'Puebla Puebla MEXICO' + '\n' + 'Teléfono: 2140601' + '\n' + 'Fecha : ' + $('#reporte_fecha').text(),
										fontSize: 12,
										margin: [0,0]
									},
									{
										alignment: 'right',
										fontSize: 14,
										text: 'Reportes'
									}
								],
								margin: 20
							}
						});
						var tbl = $('.table');
						
						var colCount = new Array();
						$(tbl).find('tbody tr:first-child td').each(function(){
						    if($(this).attr('colspan')){
						        for(var i=1;i<=$(this).attr('colspan');$i++){
						            colCount.push('*');
						        }
						    }else{ colCount.push('*'); }
						});
						doc.content[0].table.widths = colCount;
						var objLayout = {};
						objLayout['hLineWidth'] = function(i) { return .5; };
						objLayout['vLineWidth'] = function(i) { return .5; };
						objLayout['hLineColor'] = function(i) { return '#aaa'; };
						objLayout['vLineColor'] = function(i) { return '#aaa'; };
						objLayout['paddingLeft'] = function(i) { return 4; };
						objLayout['paddingRight'] = function(i) { return 4; };
						doc.content[0].layout = objLayout;
					}
				}
			]
		}]
	});
}

$(function() {
    $("#datos_reporte").on("change",function(){
        ocultar();
        var tipo = $('#tipo').val();
        
        if (tipo != '') {
            destroy_table();
            switch(tipo) {
                case '1':// categoria
                    $('#thead').empty();
                    $('#tbody').empty();
                    $('#div-categoria').show();
                    if ( $('#categoria').val() !=  '') {
                        var data = {
                            'tipo':tipo, 
                            'categoria': $('#categoria').val()
                        }
                        procesa_datos(data);
                    }
                break;
                    
                case '2':// clasificacion
                    
                    $('#thead').empty();
                    $('#tbody').empty();
                    
                    $('#div-clasificacion').show();
                    if ( $('#clasificacion').val() !=  '') {
                        
                        var data = {
                            'tipo':tipo, 
                            'clasificacion': $('#clasificacion').val()
                        }
                        procesa_datos(data);
                    }
                break;

                case '3': //sin tarjeta
                    $('#thead').empty();
                    $('#tbody').empty();
                    var data = {
                        'tipo':tipo, 
                    }
                    procesa_datos(data);
                break;

                case '4': //transacciones por dia

                    $('#thead').empty();
                    $('#tbody').empty();
                    
                    $('#div-inicio').show();
                    $('#div-fin').show();
                    $('#div-personal').show();

                    if ($('#inicio').val() !=  '' && $('#fin').val() !=  '' && $('#personal').val() !=  '' ) {
                        var data = {
                            'tipo':tipo,
                            'inicio': $('#inicio').val(),
                            'fin': $('#fin').val(),
                            'personal' : $('#personal').val()
                        }
                        procesa_datos(data);
                    }
                break;

                case '5': //registros

                    $('#thead').empty();
                    $('#tbody').empty();
                    
                    $('#div-inicio').show();
                    $('#div-fin').show();
                    $('#div-personal').show();
                    
                    if ($('#inicio').val() !=  '' && $('#fin').val() !=  '' && $('#personal').val() !=  '' ) {
                        var data = {
                            'tipo':tipo,
                            'inicio': $('#inicio').val(),
                            'fin': $('#fin').val(),
                            'personal' : $('#personal').val()
                        }
                        procesa_datos(data);
                    }
      
                break;

                case '6': //clientes por vendedor

                    $('#thead').empty();
                    $('#tbody').empty();
                    
                    $('#div-inicio').show();
                    $('#div-fin').show();

                    if ($('#inicio').val() !=  '' && $('#fin').val() !=  '') {
                        var data = {
                            'tipo':tipo,
                            'inicio': $('#inicio').val(),
                            'fin': $('#fin').val()
                        }
                        procesa_datos(data);
                    }     
                break;
                
                default:
            }
        }
    });
});

function ocultar(){
    $('#div-categoria').hide();
    $('#div-clasificacion').hide();
    $('#div-personal').hide();
    $('#div-inicio').hide();
    $('#div-fin').hide();
}

function procesa_datos(data){
    
    $.ajax({
        url: 'genera_reporte',
        method:"GET",
        data:{
            data
        },
        success: function(data) {
            var titulo, contenido;   
            $.each(data.thead, function (ind, elem) { 
                titulo += '<td>'+elem+'</td>'; 
            }); 
            $('#thead').append('<tr>'+titulo+'</tr>');
            jQuery.each(data.tbody, function(i, val){
                contenido += '<tr>'
                $.each(val, function (ind, elem) { 
                    contenido += '<td>'+elem+'</td>'; 
                });
                contenido+= '</tr>';
            });
            $('#tbody').append(contenido);
            exportar();
        },
    });
}