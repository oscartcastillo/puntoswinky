/*$(function() {
    $("#encuesta").on("change",function(){
        ocultar();
        var fecha1 = $('#fecha1').val();
        var fecha2 = $('#fecha2').val();
        var perfil = $('#tipo_perfil').val();
        var edad = $('#edad').val();
        var sucursal = $('#sucursal').val();
        var horas = $('#horas').val();
        if (fecha1 == '') {
            $('.errorFecha1').show();
        }
        if (fecha2 == '') {
            $('.errorFecha2').show();
        }

        if (fecha1 =! '' && fecha1 != '') {

            $.ajax({
                type:'POST',
                url: 'perfil',
                dataType: 'json',
                data : {
                    'fecha1' : fecha1,
                    'fecha2' : fecha2,
                    'perfil' : perfil,
                    'edad' : edad,
                    'sucursal' : sucursal,
                    'horas' : horas
                },
                success:function(data){
                    
                    avatar(data.avatar);
                    $('#exampleModalCenter').modal('hide');
                }
            });   
        }
    });

    function ocultar(){
        $('.errorFecha1').hide();
        $('.errorFecha2').hide();
    }
});*/


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
                $( "#form-encuesta" ).submit();
            }
            
            botones++;
        }
        
    });

    /*$(".previous").click(function(){
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        previous_fs.show();
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            },
            duration: 600
        });
    });*/

    $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });

    /*$(".submit").click(function(){
        return false;
    });*/


    function primer_form(){
        var result;

        $.ajax({
            type: 'POST',
            url: 'encuestas',
            async: false,
            data: {
                '_token': $('input[name=_token]').val(),
                'nombre': $('#nombre').val(),
                'correo': $('#correo').val(),
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
                    if (data.errors.correo) {
                        $('.errorCorreo').show();
                        $('.errorCorreo').text(data.errors.correo);
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
                    console.log(data);

                    /*Swal.fire({
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

                    $('#general').modal('hide');*/
                }
            });
        }));
    });
});