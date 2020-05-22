$(document).ready(function () {
    $('.descargar-ajax').on('click', function () {
        
       let token = $('input[name=_token]').val(); 
       
        $.ajax({
            type: "POST",
            data: {"_token": token.toString()},
            url: "/puntos",
            success: function (response) {
                
                $('.puntos').text(--response);
            }
        });

        
    });
});
