$(document).on('click', '.add-modal', function() {
    $('#nombre_add').val('');
    $('#apellidos_add').val('');
    $('#correo_add').val('');
    $('#cumpleanos_add').val('');
    $('#telefono_add').val('');
    $('#compania_add').val('');
    $('#tipo_add').val('');
    $('#genero_add').val('');
    $('#estatus_add').val('');
    $('#tarjeta_add').val('');
    
    $('.modal-title').text('Agregar Nuevo Usuario');
    $('#addModal').modal('show');
    $('.errorNombre').hide();
    $('.errorApellidos').hide();
    $('.errorCorreo').hide();
    $('.errorCumpleanos').hide();
    $('.errorTelefono').hide();
    $('.errorCompania').hide();
    $('.errorTipo').hide();
    $('.errorGenero').hide();
    $('.errorEstatus').hide();
    $('.errorTarjeta').hide();
    
});
$('.modal-footer').on('click', '.add', function() {
    $.ajax({
        type: 'POST',
        url: 'clientes',
        data: {
            '_token': $('input[name=_token]').val(),
            'nombre': $('#nombre_add').val(),
            'apellidos': $('#apellidos_add').val(),
            'email' : $('#correo_add').val(),
            'cumpleanos': $('#cumpleanos_add').val(),
            'telefono': $('#telefono_add').val(),
            'compania': $('#compania_add').val(),
            'tipo': $('#tipo_add').val(),
            'genero': $('#genero_add').val(),
            'estatus': $('#estatus_add').val(),
            'perfil_tarjeta': $('#tarjeta_add').val()
        },
        success: function(data) {
            if ((data.errors)) {

                //$('#addModal').modal('show');
                setTimeout(function () {
                    
                    $('#addModal').modal('show');

                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error en Validación!!!',
                        showConfirmButton: false,
                        timer: 500
                    });
                    
                    //toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                
                }, 500);

                /*Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error en Validación!!!',
                    showConfirmButton: false,
                    timer: 2000
                });*/

                if (data.errors.nombre) {
                    $('.errorNombre').show();
                    $('.errorNombre').text(data.errors.nombre);
                }
                if (data.errors.apellidos) {
                    $('.errorApellidos').show();
                    $('.errorApellidos').text(data.errors.apellidos);
                }
                if (data.errors.email) {
                    $('.errorCorreo').show();
                    $('.errorCorreo').text(data.errors.email);
                }
                if (data.errors.cumpleanos) {
                    $('.errorCumpleanos').show();
                    $('.errorCumpleanos').text(data.errors.cumpleanos);
                }
                if (data.errors.telefono) {
                    $('.errorTelefono').show();
                    $('.errorTelefono').text(data.errors.telefono);
                }
                if (data.errors.compania) {
                    $('.errorCompania').show();
                    $('.errorCompania').text(data.errors.compania);
                }
                if (data.errors.genero) {
                    $('.errorGenero').show();
                    $('.errorGenero').text(data.errors.genero);
                }
                if (data.errors.estatus) {
                    $('.errorEstatus').show();
                    $('.errorEstatus').text(data.errors.estatus);
                }
                if (data.errors.tipo) {
                    $('.errorTipo').show();
                    $('.errorTipo').text(data.errors.tipo);
                }
                if (data.errors.perfil_tarjeta) {
                    $('.errorTarjeta').show();
                    $('.errorTarjeta').text(data.errors.perfil_tarjeta);
                }
            }
            else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Transaccion Realizada!!!',
                    showConfirmButton: false,
                    timer: 5000
                });
                //toastr.success('Usuario agregado con Exito!', 'Success Alert', {timeOut: 5000});

                $('#postTable').prepend("<tr class='item" + data.id + "'><td style='display: table-cell;' class='footable-first-visible tarjeta'>" + data.tarjeta + "</td><td style='display: table-cell; text-transform: capitalize;'>" + data.nombre +" "+ data.apellidos + "</td><td style='display: table-cell;'>" + data.email + "</td><td style='display: table-cell;' class='fecha-t'>" + data.cumpleanos + "</td><td style='display: table-cell;'>"+ data.estatus +"</td><td style='display: table-cell;' class='footable-last-visible'><button class='show-modal btn btn-success' data-id='" + data.id + "' data-nombre= '" + data.nombre + "' data-apellidos= '" + data.apellidos + "' data-email= '" + data.email + "' data-cumpleanos= '" + data.cumpleanos + "' data-telefono= '" + data.telefono + "' data-compania= '" + data.compania + "' data-genero= '" + data.genero + "' data-estatus= '" + data.estatus + "' data-tipo= '" + data.tipo + "' data-tarjeta= '" + data.tarjeta + "'style='min-width: 100px;'><span class='glyphicon glyphicon-eye-open'></span> Ver </button> <button class='edit-modal btn btn-info' data-id='" + data.id + "' data-nombre= '" + data.nombre + "' data-apellidos= '" + data.apellidos + "' data-email= '" + data.email + "' data-cumpleanos= '" + data.cumpleanos + "' data-telefono= '" + data.telefono + "' data-compania= '" + data.compania + "' data-genero= '" + data.genero + "' data-estatus= '" + data.estatus + "'data-tipo= '" + data.tipo + "' data-tarjeta= '" + data.tarjeta + "' style='min-width: 100px;'><span class='glyphicon glyphicon-edit'></span> Editar </button></td></tr>");

                actualiza_td();
            }
        },
    });
});

// Show a post

$(document).on('click', '.show-modal', function() {

    $('.modal-title').text('Perfil');
    $('#telefono_show').text( $(this).data('telefono'));
    $('#cumpleanos_show').text( $(this).data('cumpleanos'));
    $('#compania_show').text( $(this).data('compania'));
    $('#tipo_show').text( $(this).data('tipo'));
    $('#genero_show').text( $(this).data('genero'));
    $('#tarjeta_show').text( $(this).data('tarjeta'));
    $('#showModal').modal('show');

    actualiza_td();
});


// Edit a post
$(document).on('click', '.edit-modal', function() {

    $('.modal-title').text('Editar');
    $('#id_edit').val($(this).data('id'));
    $('#correo_edit').val($(this).data('email'));
    $('#nombre_edit').val($(this).data('nombre'));
    $('#apellidos_edit').val($(this).data('apellidos'));
    $('#telefono_edit').val($(this).data('telefono'));
    $('#cumpleanos_edit').val($(this).data('cumpleanos'));
    $('#tarjeta_edit').val($(this).data('tarjeta'));
    
    $('#compania_edit option:selected').removeAttr('selected');
    $('#compania_edit option[value='+($(this).data('compania'))+']').attr('selected','selected');
    
    $('#tipo_edit option:selected').removeAttr('selected');
    $('#tipo_edit option[value='+($(this).data('tipo'))+']').attr('selected','selected');
    
    $('#estatus_edit option:selected').removeAttr('selected');
    $('#estatus_edit option[value='+($(this).data('estatus'))+']').attr('selected','selected');
    
    $('#genero_edit option:selected').removeAttr('selected');
    $('#genero_edit option[value='+($(this).data('genero'))+']').attr('selected','selected');

    id = $('#id_edit').val();

    $('.errorNombre').hide();
    $('.errorApellidos').hide();
    $('.errorCorreo').hide();
    $('.errorCumpleanos').hide();
    $('.errorTelefono').hide();
    $('.errorCompania').hide();
    $('.errorTipo').hide();
    $('.errorGenero').hide();
    $('.errorEstatus').hide();
    $('.errorTarjeta').hide();
    $('#editModal').modal('show');

    actualiza_td();

});
$('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'PUT',
        url: 'clientes/' + id,
        data: {
            '_token': $('input[name=_token]').val(),
            'nombre': $('#nombre_edit').val(),
            'apellidos': $('#apellidos_edit').val(),
            'email' : $('#correo_edit').val(),
            'cumpleanos': $('#cumpleanos_edit').val(),
            'telefono': $('#telefono_edit').val(),
            'compania': $('#compania_edit').val(),
            'tipo': $('#tipo_edit').val(),
            'genero': $('#genero_edit').val(),
            'estatus': $('#estatus_edit').val(),
            'perfil_tarjeta': $('#tarjeta_edit').val()
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
                if (data.errors.apellidos) {
                    $('.errorApellidos').show();
                    $('.errorApellidos').text(data.errors.apellidos);
                }
                if (data.errors.email) {
                    $('.errorCorreo').show();
                    $('.errorCorreo').text(data.errors.email);
                }
                if (data.errors.cumpleanos) {
                    $('.errorCumpleanos').show();
                    $('.errorCumpleanos').text(data.errors.cumpleanos);
                }
                if (data.errors.telefono) {
                    $('.errorTelefono').show();
                    $('.errorTelefono').text(data.errors.telefono);
                }
                if (data.errors.compania) {
                    $('.errorCompania').show();
                    $('.errorCompania').text(data.errors.compania);
                }
                if (data.errors.tipo) {
                    $('.errorTipo').show();
                    $('.errorTipo').text(data.errors.tipo);
                }
                if (data.errors.genero) {
                    $('.errorGenero').show();
                    $('.errorGenero').text(data.errors.genero);
                }
                if (data.errors.estatus) {
                    $('.errorEstatus').show();
                    $('.errorEstatus').text(data.errors.estatus);
                }
                if (data.errors.perfil_tarjeta) {
                    $('.errorTarjeta').show();
                    $('.errorTarjeta').text(data.errors.perfil_tarjeta);
                }
            }
            else {
                toastr.success('Usuario Editado con Exito!', 'Success Alert', {timeOut: 5000});
                
                $('.item' + data.id).replaceWith("<tr class='item"+data.id+"'><td style='display: table-cell;' class='footable-first-visible tarjeta'>"+ data.perfil.perfil_tarjeta +"</td><td style='display: table-cell; text-transform: capitalize;'>"+data.perfil.perfil_nombre+" "+data.perfil.perfil_apellidos+"</td><td style='display: table-cell;'>"+data.email+"</td><td style='display: table-cell;' class='fecha-t'>"+data.perfil.perfil_nacimiento+"</td><td style='display: table-cell;' id='red'>"+data.estatus+"</td><td style='display: table-cell;' class='footable-last-visible'><button class='show-modal btn btn-success' data-id='" + data.id + "' data-nombre= '" + data.perfil.perfil_nombre + "' data-apellidos= '" + data.perfil.perfil_apellidos + "' data-email= '" + data.email + "' data-cumpleanos= '" + data.perfil.perfil_nacimiento + "' data-telefono= '" + data.perfil.perfil_celular + "' data-compania= '" + data.perfil.perfil_compania + "' data-tipo= '" + data.perfil.tipo_perfil_id + "' data-genero= '" + data.perfil.perfil_genero + "' data-estatus= '" + data.estatus + "' data-tarjeta= '" + data.perfil.perfil_tarjeta + "' style='min-width: 100px;'><span class='glyphicon glyphicon-eye-open'></span> Ver</button> <button class='edit-modal btn btn-info' data-id='" + data.id + "' data-nombre= '" + data.perfil.perfil_nombre + "' data-apellidos= '" + data.perfil.perfil_apellidos + "' data-email= '" + data.email + "' data-cumpleanos= '" + data.perfil.perfil_nacimiento + "' data-telefono= '" + data.perfil.perfil_celular + "' data-compania= '" + data.perfil.perfil_compania + "' data-tipo= '" + data.perfil.tipo_perfil_id + "' data-genero= '" + data.perfil.perfil_genero + "' data-estatus= '" + data.estatus + "' data-tarjeta= '" + data.perfil.perfil_tarjeta + "' style='min-width: 100px;'><span class='glyphicon glyphicon-edit'></span> Editar</button></td><tr>");

                $("#form-edit").trigger("reset");
                $('#compania_edit option:selected').removeAttr('selected');
                $('#tipo_edit option:selected').removeAttr('selected');
                $('#estatus_edit option:selected').removeAttr('selected');
                $('#genero_edit option:selected').removeAttr('selected');
            }
            actualiza_td();
        }
    });
});
$(function() {
    $('#ciudad_add').change(function() {
        var url = 'perfil/'+ $(this).val() + '/empresa/';
        $.get(url, function(data) {
            var select = $('#empresa_add');
            select.empty();
            $.each(data,function(key, value) {
                select.append('<option value=' + value.id + '>' + value.empresa_nombre + '</option>');
            });
        });
    });
});
$(function() {
    $('#ciudad_edit').change(function() {
        var url = 'perfil/'+ $(this).val() + '/empresa/';
        $.get(url, function(data) {
            var select = $('#empresa_edit');
            select.empty();
            $.each(data,function(key, value) {
                select.append('<option value=' + value.id + '>' + value.empresa_nombre + '</option>');
            });
        });
    });
});
   