$(document).ready(function(){
	$("select[name=color1]").change(function(){

        var datos  = $(this).val();
        
        $.ajax({
            type: 'POST',
            url: 'promociones',
            data: {
                'datos': datos,
            },
            success: function(data) {
                
                $("#calendario").empty();
                $("#calendario").load('calendario').fadeIn('slow');
            },
        });
    });
});