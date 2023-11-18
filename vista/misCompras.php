<?php

include_once("../configuracion.php");
include_once("../estructura/header.php");

?>




<body class=" bg-dark  ">

    <?php

    include_once("../estructura/menu/menu.php");
    include_once("../estructura/Navbar.php");
    ?>





    <main class="container-fluid tablas container text-center text-light">


        <h1>Mis Compras</h1>
        <table class="table table-dark table-striped" id="tablamiscompras">
            <thead>
                <tr>
                    <th> # </th>
                    <th>Fecha Compra</th>
                    <th>Cant Items</th>          
                    
                    <th>Estado</th>
                    <th>Total Compra</th>
                    <th>Acciones</th>

                </tr>
            </thead>
        </table>

    </main>



    <div class="contenedor">
    </div>


    <?php include_once("../estructura/Footer.php"); ?>

</body>

<script type="text/javascript" src="./js/compras/miscompras.js">
</script>


</html>