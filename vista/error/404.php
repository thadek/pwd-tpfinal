<?php

include_once("../../configuracion.php");
include_once("../../estructura/header.php");

http_response_code(404);
?>


<body class=" bg-dark  ">

    <?php
    $rutalogo = "./img/";
    include_once("../../estructura/menu/menu.php");
    include_once("../../estructura/Navbar.php");
    ?>

    <main class="container-fluid cont container text-center text-light roboto" >

        <h1>
            404
        </h1>
        <br />
        <h2>
            El recurso solicitado no fue encontrado.
        </h2>
        <p>
           ¿Necesitas un mapa?
        </p>

    </main>


    


    <?php include_once("../../estructura/Footer.php"); ?>

</body>



</html>


