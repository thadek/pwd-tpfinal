
function inicioLaCompra() {
    $.ajax({
        type: "POST",
        url: "accion/carrito/iniciarCompra.php", // Reemplaza con la URL correcta de tu backend
        success: function(response) {
            console.log(response);
            Swal.fire({
                title: response.mensaje,
                icon: "success",
                text: "La compra se envió correctamente.",
                timer: 2000,
                timerProgressBar: true,
            });
            setTimeout(function() {
                location.reload();
            }, 2000);
        },
        error: function(error) {
            console.error("Error al enviar compra:", error);
        }
    })
}
