<?php
require_once('../configuracion.php');
include_once('../estructura/header.php');
autorizar(["cliente"]);
?>

<body class="bg-dark">

    <?php
    include_once('../estructura/menu/menu.php');
    include_once('../estructura/Navbar.php');
    ?>

    <main class="container-fluid container tablas text-center text-light">
        <h3>Mis Compras</h3>
        <div id="misCompras"></div>
    </main>

    <?php include_once('../estructura/Footer.php'); ?>
    <script src="./js/compras/gestionComprasCliente.js"></script>
</body>
</html>