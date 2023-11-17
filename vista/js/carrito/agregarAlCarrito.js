$(document).on('click', '[data-id]', function() {
    var idProducto = $(this).data('id');
    
    
    $.ajax({
        type: "POST",
        url: 'accion/carrito/agregarAlCarrito.php',
        data: { idProducto: idProducto },
        success: function(response){
            console.log(response);
            Swal.fire({
                title: response.message,
                icon: "success",
                text: "Bicicleta Agregada al carrito",
                timer: 2000,
                timerProgressBar: true,
            });
        }
    }).fail(function(jqXHR, textStatus, errorThrown){
        Swal.fire({
            title: "Error",
            icon: "error",
            text: jqXHR.responseJSON.message,
            timer: 2000,
            timerProgressBar: true,
        })
    });         
   });