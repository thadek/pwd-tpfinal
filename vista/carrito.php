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
        
    <?php
    $html = new ABMIniciarCompra();
    $html = $html->traerCarrito();
    echo $html;
    ?>

    </div>

    <table>
        <tr>
            <td>
                <button class="btn btn-success" onclick="vaciarCarrito()">Vaciar carrito</button>
            </td>
            <td>
                <button class="btn btn-success" onclick="iniciarCompra()">Iniciar compra</button>
            </td>
        </tr>
    </table>
   <!-- <div class="row float-right">
        <div class="col-md-12 float-right">
            <button class="btn btn-success" onclick="vaciarCarrito()">Vaciar carrito</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 float-right">
            <button class="btn btn-success" onclick="iniciarCompra()">Iniciar compra</button>
        </div>
    </div>
-->
    <script>

        // Función para vaciar el carrito
        function vaciarCarrito() {
            vaciarCarrito();
            console.log("Vaciar carrito");
        }

        // Función para iniciar la compra (puedes redirigir a otra página aquí)
        function iniciarCompra() {
            // Aquí puedes agregar lógica para enviar los datos a tu backend y realizar acciones adicionales
            // Luego, puedes redirigir al usuario a otra página, por ejemplo, "iniciar_compra.php"
            iniciarCompra();
            console.log("Iniciar compra");
        }

    </script>

<div class="contenedor">
    

</div>
<div class="fixed-bottom">
    <?php include_once("../estructura/footer.php"); ?>
</div>

</body>
<script src="js/carrito/vaciarCarrito.js"></script>
<script src="js/carrito/iniciarCompra.js"></script>
<script src="js/carrito/eliminarCompra.js"></script>
</html>
