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
        
        /*if (botones == 1) {
            respuesta = envia();
        }
        if (botones == 2) {
            respuesta = segundo_form();
        }
        if (botones == 3) {
            respuesta = tercer_form();
        }
        
        if (respuesta) {*/
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
            
           /* botones++;
        }*/
        
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

    $(".submit").click(function(){
        return false;
    });


    function envia(){

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
                'nombre': $('#nombre').val(),
                'correo': $('#correo').val(),
                'sexo': $('#sexo').val(),
                'edad': $('#edad').val(),
                'tipo': $('#tipo').val(),
                'sucursal': $('#sucursal').val(),
                'difusion': $('#difusion').val(),
                'operation' : 2
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
    function tercer_form(){

    }
    function ocultar(){
        $('.errorNombre').hide();
        $('.errorCorreo').hide();
        $('.errorSexo').hide();
        $('.errorEdad').hide();
        $('.errorTipo').hide();
        $('.errorSucursal').hide();
        $('.errorNosotros').hide();
    }
});