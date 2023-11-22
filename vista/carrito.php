<?php

include_once("../configuracion.php");
include_once("../estructura/header.php");

?>




<body class=" bg-dark  ">

    <?php

    include_once("../estructura/menu/menu.php");
    include_once("../estructura/Navbar.php");
    ?>





    <main class="container-fluid container tablas container text-center text-light" data-bs-theme="dark">


        <h2 class="text-white text-center"> <i class="fa-solid fa-cart-shopping"></i> Carrito</h2>

        <div class="container text-light">
            <div class="row d-flex justify-content-center my-4" id="cont-carrito">

                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Productos</h5>
                        </div>
                        <!-- Lista de productos dinámica -->
                        <div class="card-body" id="listaproductos">
                           
                        </div>
                    </div>


                </div>

                <!-- Resumen de compra -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Resumen</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Subtotal
                                    <span id="subtotal"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Envío Nacional
                                    <span>Gratis</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Total compra</strong>

                                    </div>
                                    <span><strong id="total">$53.98</strong></span>
                                </li>
                            </ul>

                            <button type="button" class="btn btn-outline-light btn-lg btn-block" onclick="enviarCompra()">
                                Enviar compra
                            </button>

                            <button type="button" class="btn btn-outline-light btn-lg btn-block" onclick="vaciarCarrito()">
                                Vaciar carrito
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </main>



    <div class="contenedor">
    </div>

    <script type="text/javascript" src="./js/carrito/listar.js"></script>


    <div class="fixed-bottom">
        <?php include_once("../estructura/footer.php"); ?>
    </div>

</body>



</html>