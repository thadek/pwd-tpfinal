<?php

include_once("../configuracion.php");
include_once("../estructura/header.php");
?>




<body class=" bg-dark  ">

    <?php
    $rutalogo = "./img/";
    include_once("../estructura/menu/menu.php");
    include_once("../estructura/Navbar.php");
    ?>


<div id="slider" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./img/slider/banner3.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./img/slider/banner1.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./img/slider/banner2.png" class="d-block w-100" alt="...">
            </div>
        </div>
    </div>




<!--<div class="banner-bicis " >
<h1 class="text-center text-light titulo-prod">Productos</h1></div> -->

    <main class="container-fluid cont2 container text-center text-light">

        <div class="container ">
            <div class="row">
                <div class="col-md-12">
                    
                    
                </div>
                <div class="row" id="products">

                </div>
            </div>




        </div>


    </main>


    <div class="contenedor">
    </div>


    <?php include_once("../estructura/Footer.php"); ?>

</body>

<script type="text/javascript" src="./js/productos/listar.js"></script>


</html>