
function vacioElCarrito() {
    $.ajax({
        type: "POST",
        url: "accion/carrito/vaciarCarrito.php", // Reemplaza con la URL correcta de tu backend
        success: function(response) {
            console.log(response);
            Swal.fire({
                title: response.mensaje,
                icon: "success",
                text: "El carrito se vacio correctamente",
                timer: 2000,
                timerProgressBar: true,
            });
            setTimeout(function() {
                location.reload();
            }, 2000);
        },
        error: function(error) {
            console.error("Error al vaciar carrito:", error);
        }
    })
}
