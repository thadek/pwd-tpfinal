<?php

include_once("../configuracion.php");
include_once("../estructura/header.php");
autorizar(["cliente", "deposito"]);

?>






<body class=" bg-dark  ">

    <?php
    $rutalogo = "./img/";
    include_once("../estructura/menu/menu.php");
    include_once("../estructura/Navbar.php");
    ?>

    <main class="container-fluid cont container text-light">
        <div class="card col-12 text-center" data-bs-theme="dark">

            <div class="container text-center">

                <div class="row" style="min-height: 50vh;">

                    <div class="d-flex text-center flex-column align-items-center justify-content-center ">

                        <h1> <i class="fa-regular fa-circle-user"></i></h1>
                        <h2><?php echo $session->getUsuario()->getUsNombre() ?></h2>
                        <!-- Formulario para cambiar mail y contraseña con jquery -->





                        <h5> Roles:</h5>

                        <div class="row d-flex">
                        <?php
                        $roles_usr = $session->getRoles();

                        $vistaRoles = "";
                        foreach ($roles_usr as $rol) {
                            $esRolSeleccionado =  ($rol->getIdRol() == $session->getIdRol());
                            $bgSeleccionado = $esRolSeleccionado?"success":"secondary";
                            $vistaActual = $esRolSeleccionado?"<i class='fa-solid fa-check'></i> ":"";
                            $vistaRoles .= <<<COD
                            <div class="col p-3">
                            <span class="badge rounded-pill text-bg-{$bgSeleccionado}">{$vistaActual}
                            <i class='fa-solid fa-user-lock'></i>  {$rol->getIdRol()} - {$rol->getRoDescripcion()}
                            </span>
                                </div>
                        COD;
                        }
                        
                        echo $vistaRoles; ?>
                        </div>
                       









                        <div class="row">
                            <div class="input-group ">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-envelope"></i></span>
                                <input type="text" disabled class="form-control" value="<?php echo $session->getUsuario()->getUsMail() ?>">
                            </div>
                        </div>


                        <h5> </h5>


                        <br>

                    </div>

                    <div class="col d-flex align-items-center justify-content-center gap-3">
                        <button class="btn btn-light" onclick="cambiarCorreo()"> Cambiar correo electrónico</button>
                        <button class="btn btn-light" onclick="cambiarPassword()"> Cambiar contraseña</button>
                        <button class="btn btn-light"> Cambiar rol de visualizacion</button>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <div class="contenedor">
    </div>


    <?php include_once("../estructura/Footer.php"); ?>

</body>

<script src="./js/usuario/menu_usuario.js"></script>


</html>