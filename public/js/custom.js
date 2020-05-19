$(document).ready(function () {
    $('.descargar-ajax').on('click', function () {
        
       let user = $(this).data('user');
       let token = $('input[name=_token]').val(); 
       
        $.ajax({
            type: "POST",
            data: {"_token": token.toString()},
            url: "/puntos/"+user.id,
            success: function (response) {
                $('.puntos').text(--response.puntos_descarga);
            }
        });

        
    });
});
