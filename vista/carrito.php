<?php
$Titulo = "Carrito";
include_once("../configuracion.php");
include_once("../estructura/header.php");
include_once("../estructura/menu/menu.php");
$rutalogo = "./img/";
include_once("../estructura/Navbar.php");
$datos = darDatosSubmitted();

autorizar(['cliente', 'deposito']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-dark">
    <h3 class="text-white text-center my-3">Carrito</h3>

    <div class="table-responsive">
        <table class="table table-striped table-sm table-dark table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                </tr>
            </thead>
            <tbody id="tablaCarrito">
                <!-- La tabla se llenará dinámicamente con JavaScript -->
            </tbody>
        </table>
    </div>

    <div class="row float-right">
        <div class="col-md-12 float-right">
            <button class="btn btn-success" onclick="vaciarCarrito()">Vaciar carrito</button>
        </div>
    </div>

    <div class="row float-">
        <div class="col-md-12 float-right">
            <button class="btn btn-success" onclick="iniciarCompra()">Iniciar compra</button>
        </div>
    </div>

    <script>
        // Obtener el carrito almacenado en localStorage
        var carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        // Función para mostrar el carrito en la tabla
        function mostrarCarrito() {
            var tablaCarrito = document.getElementById('tablaCarrito');
            tablaCarrito.innerHTML = ''; // Limpiar la tabla

            carrito.forEach(function(producto, index) {
                var fila = '<tr>' +
                    '<th scope="row">' + (index + 1) + '</th>' +
                    '<td>' + producto.nombre + '</td>' +
                    '<td>' + producto.cantidad + '</td>' +
                    '<td>' + producto.precio + '</td>' +
                    '</tr>';

                tablaCarrito.innerHTML += fila;
            });
        }

        // Función para vaciar el carrito
        function vaciarCarrito() {
            localStorage.removeItem('carrito');
            carrito = [];
            mostrarCarrito();
            console.log("Carrito vaciado");
        }

        // Función para iniciar la compra (puedes redirigir a otra página aquí)
        function iniciarCompra() {
            // Aquí puedes agregar lógica para enviar los datos a tu backend y realizar acciones adicionales
            // Luego, puedes redirigir al usuario a otra página, por ejemplo, "iniciar_compra.php"
            
            
            console.log("Iniciar compra");
        }

        // Mostrar el carrito al cargar la página
        mostrarCarrito();
    </script>

<div class="contenedor">
    
</div>

<div class="fixed-bottom">
    <?php include_once("../estructura/footer.php"); ?>
</div>

</body>
</html>
