<?php
require_once ('../configuracion.php');
include_once("../estructura/header.php");
autorizar(["cliente"]);
?>

<body class="bg-dark">

    <?php
    include_once("../estructura/menu/menu.php");
    include_once("../estructura/Navbar.php");
    ?>

    <main class="container-fluid container text-center text-light">
        <div id="detallecompra"></div>
    </main>

    <?php include_once("../estructura/Footer.php"); ?>
    <script src="./js/compras/detalleCompraCliente.js"></script>
</body>
</html>