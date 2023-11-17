<?php

include_once("../configuracion.php");
include_once("../estructura/header.php");
autorizar(["cliente","deposito"]);
?>


<body class=" bg-dark  ">

    <?php

    include_once("../estructura/menu/menu.php");
    include_once("../estructura/Navbar.php");
    ?>





    <main class="container-fluid container  text-center text-light">



        <div id="detallecompra"></div>


    </main>



    <div class="contenedor">
    </div>


    <?php include_once("../estructura/Footer.php"); ?>

</body>

<script src="./js/compras/detalleCompra.js"></script>


</html>