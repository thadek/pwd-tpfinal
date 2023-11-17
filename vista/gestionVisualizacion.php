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


        <h1>Gestión de Visualización de menus</h1>
        <table class="table table-dark table-striped" id="tablamenus">
            <thead>
                <tr>
                    <th> # </th>
                    <th>Nombre Menu</th>
                    <th>Rol autorizado</th>
                    <th>Acciones</th>

                </tr>
            </thead>
        </table>

    </main>



    <div class="contenedor">
    </div>


    <?php include_once("../estructura/Footer.php"); ?>

</body>

<script type="text/javascript" src="./js/menurol/gestion.js">
</script>


</html>