<?php

include_once("../configuracion.php");
include_once("../estructura/header.php");
//autorizar(["admin"]);
?>




<body class=" bg-dark  ">

    <?php

    include_once("../estructura/menu/menu.php");
    include_once("../estructura/Navbar.php");
    ?>





    <main class="container-fluid cont container text-center text-light">

        <h1>Gestión de Menus</h1>

        <div id="gestionmenu">
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Cargando..</span>
                </div>
            </div>

        </div>

    </main>



    <div class="contenedor">
    </div>


    <!-- Modal -->
    <div class="modal text-light fade" id="modal" tabindex="-1" data-bs-theme="dark" role="dialog">
        <div class="modal-dialog " role="document" data-bs-theme="dark">
            <div class="modal-content p-1">
                <div class="modal-header" data-bs-theme="dark">
                    <h5 class="modal-title" id="titulo_modal"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario dentro del modal -->
                    <form>
                        <!-- Campos del formulario -->
                        <input type="hidden" id="accion">
                        <input type="hidden" id="idMenu">
                        <div class="form-group">
                            <label for="meNombre">Nombre del menú</label>
                            <input type="text" class="form-control" id="meNombre">
                        </div>
                        <div class="form-group">
                            <label for="meDescripcion">Descripción del menú</label>
                            <input type="text" class="form-control" id="meDescripcion">
                        </div>
                        <div class="form-group">
                            <label for="padre">Menú Padre</label>
                            <select class="form-control" id="padre">
                                <option value=""></option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="link">Enlace</label>
                            <input type="text" class="form-control" id="link">
                        </div>


                        <div class="form-group">
                            <input class="form-check-input" type="checkbox" value="" id="meDeshabilitado">
                            <label class="form-check-label" for="meDeshabilitado">
                                ¿Deshabilitado?
                            </label>
                        </div>

                        <!-- Otros campos del formulario -->

                        <!-- Botón de envío del formulario -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-10">
                                    <button type="button" class="btn btn-light" onclick="guardarCambios()">Guardar cambios</button>
                                </div>
                                <div class="col-2">
                                    <div class="spinner-border text-light" id="status" role="status">

                                    </div>
                                </div>


                            </div>






                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>




    <?php include_once("../estructura/Footer.php"); ?>

</body>

<script src="./js/menu/gestionMenus.js"></script>

</html>