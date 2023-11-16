$(document).ready(function () {
    // Función para registrar una compra
    $("#form_compra").on("submit", function (event) {
        event.preventDefault();

        // Obtener los datos del formulario
        let formulario = $(this).serializeArray();

        // Obtener el carrito almacenado en localStorage
        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        // Agregar los datos del carrito al formulario
        carrito.forEach(function (producto, index) {
            formulario.push({ name: `producto_${index}`, value: JSON.stringify(producto) });
        });

        console.log(formulario);

        // Realizar la solicitud AJAX
        $.ajax({
            type: "POST",
            url: "./accion/registrarCompra.php",
            data: formulario,
            success: function (respuesta) {
                Swal.fire({
                    title: "Compra registrada con éxito",
                    icon: "success",
                    text: "En breve serás redirigido al login",
                    timer: 2000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.href = "./login.php";
                    },
                });
            },
        }).fail(function (jqXHR, textStatus, errorThrown) {
            Swal.fire({
                title: jqXHR.responseJSON.mensaje,
                icon: "error",
            });
        });
    });
});
