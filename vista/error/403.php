<?php

include_once("../../configuracion.php");

$page_title = "Acceso Denegado.";

 echo <<<HEADER
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   <link rel="stylesheet" href="../css/styles.css">
   <link rel="stylesheet" href="../css/inicio.css">
   <link rel="stylesheet" href="../css/bootstrap.min.css">

   <link type="text/css" rel="stylesheet" href="../css/jsgrid.min.css" />
   <link type="text/css" rel="stylesheet" href="../css/jsgrid-theme.min.css" />

   <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
   <script type="text/javascript" src="../js/jquery.js"></script>
   <script type="text/javascript" src="../js/sweetalert2.js"></script>
   



    <title>$page_title</title>

    
</head>

HEADER;

http_response_code(403);
?>


<body class=" bg-dark  ">

    <?php
    $rutalogo = "./img/";
    include_once("../../estructura/menu/menu.php");
    include_once("../../estructura/Navbar.php");
    ?>

    <main class="container-fluid cont container text-center text-light roboto" >

        <h1>
            403
        </h1>
        <br />
        <h2>
            No tienes permiso para acceder a este recurso.
        </h2>
        <p>
              ¿Necesitas un mapa?
        </p>

    </main>


    


    <?php include_once("../../estructura/Footer.php"); ?>

</body>



</html>


