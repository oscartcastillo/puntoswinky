$(document).ready(function(){
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity, respuesta, botones = 1;

    $(".next").click(function(){

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        
        if (botones == 1) {
            respuesta = primer_form();
        }
        if (botones == 2) {
            respuesta = segundo_form();
        }
        if (botones == 3) {
            respuesta = tercer_form();
        }
        
        if (respuesta) {
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            next_fs.show();
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                    opacity = 1 - now;
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({'opacity': opacity});
                },
                duration: 600
            });

            if (botones == 3) {
                $("#form-encuesta").submit();
                $("#fin").fadeIn(3000).show();
            }
            
            botones++;
        }
        
    });

    $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });

    function primer_form(){
        var result;

        $.ajax({
            type: 'POST',
            url: 'encuestas',
            async: false,
            data: {
                '_token': $('input[name=_token]').val(),
                'nombre': $('#nombre').val(),
                'email': $('#correo').val(),
                'sexo': $('#sexo').val(),
                'edad': $('#edad').val(),
                'tipo': $('#tipo').val(),
                'sucursal': $('#sucursal').val(),
                'difusion': $('#difusion').val(),
                'operation' : 1
            },
            success: function(data) {

                ocultar();
                
                if ((data.errors)) {
                    if (data.errors.nombre) {
                        $('.errorNombre').show();
                        $('.errorNombre').text(data.errors.nombre);
                    }
                    if (data.errors.email) {
                        $('.errorCorreo').show();
                        $('.errorCorreo').text(data.errors.email);
                    }
                    if (data.errors.sexo) {
                        $('.errorSexo').show();
                        $('.errorSexo').text(data.errors.sexo);
                    }
                    if (data.errors.edad) {
                        $('.errorEdad').show();
                        $('.errorEdad').text(data.errors.edad);
                    }
                    if (data.errors.tipo) {
                        $('.errorTipo').show();
                        $('.errorTipo').text(data.errors.tipo);
                    }
                    if (data.errors.sucursal) {
                        $('.errorSucursal').show();
                        $('.errorSucursal').text(data.errors.sucursal);
                    }
                    if (data.errors.difusion) {
                        $('.errorNosotros').show();
                        $('.errorNosotros').text(data.errors.difusion);
                    }
                    result = false;
                }
                else{
                    result = true;
                } 
            }
        });

        return result;
    }
    function segundo_form(){
        var result;
        $.ajax({
            type: 'POST',
            url: 'encuestas',
            async: false,
            data: {
                '_token': $('input[name=_token]').val(),
                'pregunta_1': $("input[name='pregunta_1']:checked").val(),
                'pregunta_2': $("input[name='pregunta_2']:checked").val(),
                'pregunta_3': $("input[name='pregunta_3']:checked").val(),
                'pregunta_4': $("input[name='pregunta_4']:checked").val(),
                'pregunta_5': $("input[name='pregunta_5']:checked").val(),
                'pregunta_6': $("input[name='pregunta_6']:checked").val(),
                'operation' : 2
            },
            success: function(data) {

                ocultar();
                
                if ((data.errors)) {
                    if (data.errors.pregunta_1) {
                        $('.errorPregunta1').show();
                        $('.errorPregunta1').text(data.errors.pregunta_1);
                    }
                    if (data.errors.pregunta_2) {
                        $('.errorPregunta2').show();
                        $('.errorPregunta2').text(data.errors.pregunta_2);
                    }
                    if (data.errors.pregunta_3) {
                        $('.errorPregunta3').show();
                        $('.errorPregunta3').text(data.errors.pregunta_3);
                    }
                    if (data.errors.pregunta_4) {
                        $('.errorPregunta4').show();
                        $('.errorPregunta4').text(data.errors.pregunta_4);
                    }
                    if (data.errors.pregunta_5) {
                        $('.errorPregunta5').show();
                        $('.errorPregunta5').text(data.errors.pregunta_5);
                    }
                    if (data.errors.pregunta_6) {
                        $('.errorPregunta6').show();
                        $('.errorPregunta6').text(data.errors.pregunta_6);
                    }
                    result = false;
                }
                else{
                    result = true;
                } 
            }
        });

        return result;
    }
    function tercer_form(){
        var result;
        $.ajax({
            type: 'POST',
            url: 'encuestas',
            async: false,
            data: {
                '_token': $('input[name=_token]').val(),
                'pregunta_7': $("input[name='pregunta_7']:checked").val(),
                'pregunta_8': $("input[name='pregunta_8']:checked").val(),
                'pregunta_9': $("input[name='pregunta_9']:checked").val(),
                'pregunta_10': $("#pregunta_10").val(),
                'operation' : 3
            },
            success: function(data) {

                ocultar();
                
                if ((data.errors)) {
                    if (data.errors.pregunta_7) {
                        $('.errorPregunta7').show();
                        $('.errorPregunta7').text(data.errors.pregunta_7);
                    }
                    if (data.errors.pregunta_8) {
                        $('.errorPregunta8').show();
                        $('.errorPregunta8').text(data.errors.pregunta_8);
                    }
                    if (data.errors.pregunta_9) {
                        $('.errorPregunta9').show();
                        $('.errorPregunta9').text(data.errors.pregunta_9);
                    }
                    if (data.errors.pregunta_10) {
                        $('.errorPregunta10').show();
                        $('.errorPregunta10').text(data.errors.pregunta_10);
                    }
                    result = false;
                }
                else{
                    result = true;
                } 
            }
        });

        return result;

    }
    function ocultar(){

        $('.errorNombre').hide();
        $('.errorCorreo').hide();
        $('.errorSexo').hide();
        $('.errorEdad').hide();
        $('.errorTipo').hide();
        $('.errorSucursal').hide();
        $('.errorNosotros').hide();

        $('.errorPregunta1').hide();
        $('.errorPregunta2').hide();
        $('.errorPregunta3').hide();
        $('.errorPregunta4').hide();
        $('.errorPregunta5').hide();
        $('.errorPregunta6').hide();
        $('.errorPregunta7').hide();
        $('.errorPregunta8').hide();
        $('.errorPregunta9').hide();
        $('.errorPregunta10').hide();

        $('.errorFecha2').hide();
        $('.errorFecha2').hide();
    }

    $(document).ready(function (e) {
        $('#form-encuesta').on('submit',(function(e) {
                
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: 'encuestas',
                data:formData,
                cache:false,
                dataType: 'json',
                contentType: false,
                processData: false,
                success:function(data){
                    $('#gracias_nombre').text(data.original.nombre);
                }
            });
        }));
    });

    $("#encuesta").on("change",function(){

        ocultar();
        
        var fecha1 = $('#fecha1').val();
        var fecha2 = $('#fecha2').val();
        
        if (fecha1 == '') {
            $('.errorFecha1').show();
        }
        if (fecha2 == '') {
            $('.errorFecha2').show();
        }

        $('.exportToExcel').attr('disabled', true);

        if (fecha1 != '' && fecha2 != '') {

            $('.exportToExcel').attr('disabled', false);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: 'encuestas',
                data : {
                    'operation' : 'Auth',
                    'fecha1' : $('#fecha1').val() ,
                    'fecha2' : $('#fecha2').val(),
                    'perfil' : $('#tipo_perfil').val(),
                    'edad' : $('#edad').val(),
                    'sucursal' : $('#sucursal').val(),
                    'horas' : $('#horas').val()
                },
                dataType: 'json',
                success:function(data){
                    
                    $('#personas').text('');
                    $('#pregunta1,#pregunta2,#pregunta3,#pregunta4,#pregunta5,#pregunta6,#pregunta7,#pregunta8,#pregunta9').empty();
                    $('#v-1,#v-2,#v-3,#v-4,#v-5,#v-6,#v-7').empty();
                    $('.reset-repor').text('');

                    $('#lista-opciones').empty();
                    
                    if (data.respuesta) {
                        $('#personas').text(0);
                    }
                    else{
                        
                        $('#personas').text(data.total);
                        
                        var num_personas = data.total,
                            comienzo = 1,
                            nombre = "#pregunta",
                            resultado = '', 
                            cadena = '',
                            listado = '',
                            plati = '';

                            $('#v-1').text(num_personas);
                            $('#v-2').text($('#fecha1').val());
                            $('#v-3').text($('#fecha2').val());
                            $('#v-4').text($('select[name="sucursal"] option:selected').text());
                            $('#v-5').text($('select[name="horas"] option:selected').text());
                            $('#v-6').text($('select[name="tipo_perfil"] option:selected').text());
                            $('#v-7').text($('select[name="edad"] option:selected').text());
                        
                        jQuery.each(data, function(i, val){
                            
                            if(typeof val === "object"){
                                cadena = '', inicio = 0, inicio2 = 2;
                                
                                $.each(val, function (ind, elem) {
                                    resultado = 0;
                                    resultado = ((elem * 100) / num_personas).toFixed(2);
                                    var clase = '';
                                    $(".p"+comienzo+"-"+inicio2).text(elem + " = " +resultado +"%"); 
                                    cadena += '<div class="progress-bar '+clase+'" role="progressbar" style="width: '+resultado+'%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">'+elem+' = '+resultado+' % </div>';
                                    inicio++;
                                    inicio2++;
                                });

                                $(nombre+comienzo).append(cadena);
                            }
                            comienzo++;
                        });


                        jQuery.each(data.platillos, function(index, platillo) {

                            listado += '<li class="list-group-item">'+platillo+'</li>';
                            plati += platillo +" , ";
                        });

                        $('.p10').text(plati);

                        $('#lista-opciones').append(listado);
                    }
                }
            });
        }
    });

    $(function() {
        $(".exportToExcel").click(function(e){
            var table = $('#reporte_excel');
            if(table && table.length){
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename : "Reporte Excel.xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: true
                });
            }
        });
        
    });

});



