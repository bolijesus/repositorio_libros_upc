$(document).ready(function () {
    $('.descargar-ajax').on('click', function () {
        
       let libro = $(this).data('libro');
       let token = $('input[name=_token]').val(); 
       
        $.ajax({
            type: "POST",
            data: {"_token": token.toString()},
            url: "/puntos/"+libro,
            success: function (response) {
                
                $('.puntos').text(--response);
            }
        });

        
    });
});
