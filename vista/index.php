<?php

include_once("../configuracion.php");
include_once("../estructura/header.php");
//autorizar(["visitante","admin","cliente"]);
?>




<body class=" bg-dark  ">

    <?php

    include_once("../estructura/menu/menu.php");
    include_once("../estructura/Navbar.php");
    ?>



  

    <main class="container-fluid cont container text-center text-light">

        <h1>
            ¡Hola!
        </h1>
        <br />
        <h2>
            Te damos la bienvenida al Trabajo Práctico Final.
        </h2>
        <p>
            Desplazate por el menu superior para acceder a los ejercicios.
        </p>

    </main>



    <div class="contenedor">
    </div>


    <?php include_once("../estructura/Footer.php"); ?>

</body>



</html>