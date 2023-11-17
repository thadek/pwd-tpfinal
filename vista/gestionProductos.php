<?php

include_once("../configuracion.php");
include_once("../estructura/header.php");
autorizar(["deposito"]);
?>




<body class=" bg-dark  ">

    <?php

    include_once("../estructura/menu/menu.php");
    include_once("../estructura/Navbar.php");
    ?>





    <main class="container-fluid tablas container text-center text-light">


        <h1>Gestión de productos</h1>
        <table class="table table-dark table-striped" id="tablaprod">
            <thead>
                <tr>
                    <th>
                        <div class="btn btn-outline-success" onclick="nuevoProducto()">Nuevo</div>
                    </th>
                </tr>
                <tr>
                    <th> # </th>
                    <th>Nombre</th>
                    <th>Link</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>

                </tr>
            </thead>
        </table>

    </main>



    <div class="contenedor">
    </div>


    <?php include_once("../estructura/Footer.php"); ?>

</body>

<script type="text/javascript" src="./js/productos/gestionProductos.js">
</script>


</html>