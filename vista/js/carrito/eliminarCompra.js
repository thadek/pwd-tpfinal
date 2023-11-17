

    function eliminarCompra(idCompraItem) {
        $.ajax({
            type: "POST",
            url: "accion/carrito/eliminarCompra.php", // Reemplaza con la URL correcta de tu backend
            data: { idCompraItem: idCompraItem },
            success: function(response) {
                console.log(response);
                Swal.fire({
                    title: response.mensaje,
                    icon: "success",
                    text: "Bicicleta eliminada del carrito",
                    timer: 2000,
                    timerProgressBar: true,
                });
                setTimeout(function() {
                    location.reload();
                }, 2000);
            },
            error: function(error) {
                console.error("Error al eliminar compra:", error);
            }
        })
    }
