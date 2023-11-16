<?php

include_once("../configuracion.php");
include_once("../estructura/header.php");
autorizar(["admin"]);
?>




<body class=" bg-dark  ">

    <?php
    $rutalogo = "./img/";
    include_once("../estructura/menu/menu.php");
    include_once("../estructura/Navbar.php");
    ?>

    <main class="container-fluid cont container text-center text-light">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                    
                </div>

                <div class="row float-right">

                    <div class="col-md-12 float-right text-center">
                        <a class="btn btn-outline-success m-3" role="button" href="registrarse.php">Nuevo</a>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-bordered" id="tabla">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Deshabilitado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>    
                    </table>

                </div>
        </div>
    </main>


    <div class="contenedor">
    </div>


    <?php include_once("../estructura/Footer.php"); ?>

</body>

<script type="text/javascript" src="./js/usuario/listar_usuarios.js"></script>


</html>