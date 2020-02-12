$(document).on('click', '.add-modal', function() {
    // Empty input fields
    $('#rol_add').val('');
    $('#ciudad_add').val('');
    $('#empresa_add').val('');
    $('#nombre_add').val('');
    $('#apellidos_add').val('');
    $('#correo_add').val('');
    $('#cumpleanos_add').val('');
    $('#genero_add').val('');
    $('#estatus_add').val('');
    
    $('.modal-title').text('Agregar Nuevo Usuario');
    $('#addModal').modal('show');
    
    $('.errorRol').hide();
    $('.errorCiudad').hide();
    $('.errorEmpresa').hide();
    $('.errorNombre').hide();
    $('.errorApellidos').hide();
    $('.errorCorreo').hide();
    $('.errorCumpleanos').hide();
    $('.errorGenero').hide();
    $('.errorEstatus').hide();
    
});
$('.modal-footer').on('click', '.add', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: 'usuarios',
        data: {
            //'_token': $('input[name=_token]').val(),
            'rol': $('#rol_add').val(),
            'ciudad' : $('#ciudad_add').val(),
            'empresa' : $('#empresa_add').val(),
            'nombre': $('#nombre_add').val(),
            'apellidos': $('#apellidos_add').val(),
            'email' : $('#correo_add').val(),
            'cumpleanos': $('#cumpleanos_add').val(),
            'genero': $('#genero_add').val(),
            'estatus': $('#estatus_add').val()
        },
        success: function(data) {

             ocultar();
            if ((data.errors)) {
                setTimeout(function () {
                    $('#addModal').modal('show');
                    toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                }, 500);

                if (data.errors.rol) {
                    $('.errorRol').show();
                    $('.errorRol').text(data.errors.rol);
                }
                if (data.errors.ciudad) {
                    $('.errorCiudad').show();
                    $('.errorCiudad').text(data.errors.ciudad);
                }
                if (data.errors.empresa) {
                    $('.errorEmpresa').show();
                    $('.errorEmpresa').text(data.errors.empresa);
                }
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
                if (data.errors.estatus) {
                    $('.errorEstatus').show();
                    $('.errorEstatus').text(data.errors.estatus);
                }
                if (data.errors.genero) {
                    $('.errorGenero').show();
                    $('.errorGenero').text(data.errors.genero);
                }
            }
            else {
                toastr.success('Usuario agregado con Exito!', 'Success Alert', {timeOut: 5000});

                if (data.rol == 'admin' || data.rol == 'super') {
                    $('#postTable').prepend("<tr class='item" + data.id + "'><td style='display: table-cell;' class='rol-a footable-first-visible'>" + data.rol + "</td><td class='text-capitalize' style='display: table-cell;'>"+ data.nombre +" "+ data.apellidos + "</td><td class='text-capitalize' style='display: table-cell;'>"+ data.ciudad_nombre +"</td><td class='text-capitalize' style='display: table-cell;'>"+ data.empresa_nombre +"</td><td class='text-lowercase' style='display: table-cell;'>"+ data.email +"</td><td style='display: table-cell;' class='fecha-t'>"+ data.cumpleanos +"</td><td class='text-capitalize' style='display: table-cell;'>"+ data.genero +"</td><td style='display: table-cell;' class='estatus_general'>"+ data.estatus +"</td><td style='display: table-cell;' class='footable-last-visible'><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.rol + "' data-email='" + data.email + "' data-nombre='" + data.nombre + "' data-apellidos='" + data.apellidos + "' data-ciudad='" + data.ciudad + "' data-empresa='" + data.empresa + "' data-estatus='" + data.estatus + "' data-cumpleanos='" + data.cumpleanos + "' data-genero='" + data.genero + "'><span class='glyphicon glyphicon-edit'></span> Editar</button></td></tr>");
                }
                else if (data.rol == 'geren'){

                    $('#postTable').prepend("<tr class='item" + data.id + "'><td style='display: table-cell;' class='footable-first-visible'>"+ data.nombre +" "+ data.apellidos + "</td><td class='text-lowercase' style='display: table-cell;'>"+ data.email +"</td><td style='display: table-cell;' class='fecha-t'>"+ data.cumpleanos +"</td><td style='display: table-cell;'>"+ data.genero +"</td><td style='display: table-cell;' class='estatus_general'>"+ data.estatus +"</td><td style='display: table-cell;' class='footable-last-visible'><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.rol + "' data-email='" + data.email + "' data-nombre='" + data.nombre + "' data-apellidos='" + data.apellidos + "'  data-estatus='" + data.estatus + "' data-cumpleanos='" + cumple + "' data-genero='" + data.genero + "'><span class='glyphicon glyphicon-edit'></span> Editar</button></td></tr>");
                }
                actualiza_td();
            }
        },
    });
});

// Edit a post
$(document).on('click', '.edit-modal', function() {

    $('.modal-title').text('Editar');
    $('#id_edit').val($(this).data('id'));
    
    var ciudad_id = $(this).data('ciudad');

    $('#ciudad_edit option[value='+($(this).data('ciudad'))+']').attr('selected','selected');
    $('#empresa_edit option[value='+($(this).data('empresa'))+']').attr('selected','selected');
    $('#correo_edit').val($(this).data('email'));
    $('#nombre_edit').val($(this).data('nombre'));
    $('#apellidos_edit').val($(this).data('apellidos'));
    $('#cumpleanos_edit').val($(this).data('cumpleanos'));

    $('#rol_edit option:selected').removeAttr('selected');
    $('#rol_edit option[value='+($(this).data('name'))+']').attr('selected','selected');

    $('#estatus_edit option:selected').removeAttr('selected');
    $('#estatus_edit option[value='+($(this).data('estatus'))+']').attr('selected','selected');
    
    $('#genero_edit option:selected').removeAttr('selected');
    $('#genero_edit option[value='+($(this).data('genero'))+']').attr('selected','selected');

    id = $('#id_edit').val();

    select_edit_ciudad(ciudad_id);

    $('.errorRol').hide();
    $('.errorCiudad').hide();
    $('.errorEmpresa').hide();
    $('.errorNombre').hide();
    $('.errorApellidos').hide();
    $('.errorCorreo').hide();
    $('.errorCumpleanos').hide();
    $('.errorGenero').hide();
    $('.errorEstatus').hide();
    $('#editModal').modal('show');

});
$('.modal-footer').on('click', '.edit', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'PUT',
        url: 'usuarios/' + id,
        data: {
            //'_token': $('input[name=_token]').val(),
            'rol': $('#rol_edit').val(),
            'ciudad' : $('#ciudad_edit').val(),
            'empresa' : $('#empresa_edit').val(),
            'nombre': $('#nombre_edit').val(),
            'apellidos': $('#apellidos_edit').val(),
            'email' : $('#correo_edit').val(),
            'cumpleanos': $('#cumpleanos_edit').val(),
            'genero': $('#genero_edit').val(),
            'estatus': $('#estatus_edit').val()
        },
        success: function(data) {


            ocultar();

            if ((data.errors)) {

                setTimeout(function () {
                    $('#editModal').modal('show');
                    toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                }, 500);

                if (data.errors.rol) {
                    $('.errorRol').show();
                    $('.errorRol').text(data.errors.rol);
                }
                if (data.errors.ciudad) {
                    $('.errorCiudad').show();
                    $('.errorCiudad').text(data.errors.ciudad);
                }
                if (data.errors.empresa) {
                    $('.errorEmpresa').show();
                    $('.errorEmpresa').text(data.errors.empresa);
                }
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
                if (data.errors.genero) {
                    $('.errorGenero').show();
                    $('.errorGenero').text(data.errors.genero);
                }
                if (data.errors.estatus) {
                    $('.errorEstatus').show();
                    $('.errorEstatus').text(data.errors.estatus);
                }
            }
            else {
                toastr.success('Usuario Editado con Exito!', 'Success Alert', {timeOut: 5000});

                //var fecha = update_td(data.perfil.perfil_nacimiento);

                if (data.rol_id == 'admin' || data.rol_id == 'super') {
                    
                    $('.item' + data.id).replaceWith("<tr class='item"+data.id+"'><td style='display: table-cell;' class='footable-first-visible rol-a'>"+data.name+"</td><td class='text-capitalize' style='display: table-cell;'>"+data.perfil.perfil_nombre+" "+data.perfil.perfil_apellidos+"</td><td class='text-capitalize' style='display: table-cell;'>"+data.ciudad_nombre+"</td><td class='text-capitalize' style='display: table-cell;'>"+data.empresa_nombre+"</td><td class='text-lowercase' style='display: table-cell;'>"+data.email+"</td><td class='text-lowercase fecha-t' style='display: table-cell;'>"+data.perfil.perfil_nacimiento+"</td><td class='text-lowercase text-capitalize' style='display: table-cell;'>"+data.perfil.perfil_genero+"</td><td style='display: table-cell;' class='estatus_general'>"+data.estatus+"</td><td style='display: table-cell;' class='footable-last-visible'><button class='edit-modal btn btn-info' data-id='" + data.id + "'data-name = '"+ data.name +"' data-ciudad= '" + data.perfil.ciudad_id + "' data-empresa= '" + data.perfil.empressa_id + "' data-nombre= '" + data.perfil.perfil_nombre + "' data-apellidos= '" + data.perfil.perfil_apellidos + "' data-email= '" + data.email + "' data-cumpleanos= '" + data.perfil.perfil_nacimiento + "' data-genero= '" + data.perfil.perfil_genero + "' data-estatus= '" + data.estatus + "' ><span class='glyphicon glyphicon-edit'></span> Editar</button></td><tr>");
                }
                else if ( data.rol_id == 'geren'){

                    $('.item' + data.id).replaceWith("<tr class='item"+data.id+"'><td style='display: table-cell;' class='footable-first-visible'>"+data.perfil.perfil_nombre+" "+data.perfil.perfil_apellidos+"</td><td class='text-lowercase' style='display: table-cell;'>"+data.email+"</td><td class='text-lowercase fecha-t' style='display: table-cell;'>"+data.perfil.perfil_nacimiento+"</td><td class='text-lowercase text-uppercase' style='display: table-cell;'>"+data.perfil.perfil_genero+"</td><td style='display: table-cell;' class='estatus_general'>"+data.estatus+"</td><td style='display: table-cell;' class='footable-last-visible'><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'data-nombre= '" + data.perfil.perfil_nombre + "' data-apellidos= '" + data.perfil.perfil_apellidos + "' data-email= '" + data.email + "' data-cumpleanos= '" + data.perfil.perfil_nacimiento + "' data-genero= '" + data.perfil.perfil_genero + "' data-estatus= '" + data.estatus + "' ><span class='glyphicon glyphicon-edit'></span> Editar</button></td><tr>");
                }

                $("#form-edit").trigger("reset");
                $('#rol_edit option:selected').removeAttr('selected');
                $('#estatus_edit option:selected').removeAttr('selected');
                $('#genero_edit option:selected').removeAttr('selected');

                actualiza_td();

            }
        }
    });
});

function ocultar(){

    $('.errorRol').hide().empty();
    $('.errorCiudad').hide().empty();
    $('.errorEmpresa').hide().empty();
    $('.errorNombre').hide().empty();
    $('.errorApellidos').hide().empty();
    $('.errorCorreo').hide().empty();
    $('.errorCumpleanos').hide().empty();
    $('.errorGenero').hide().empty();
    $('.errorEstatus').hide().empty();
}


function select_edit_ciudad(id){
    var url = 'perfil/'+id+ '/empresa/';
    $.get(url, function(data) {
        var select = $('#empresa_edit');
        select.empty();
        $.each(data,function(key, value) {
            select.append('<option value=' + value.id + '>' + value.empresa_nombre + '</option>');
        });
    });
}
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
   