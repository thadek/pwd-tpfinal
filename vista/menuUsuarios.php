<?php

include_once("../configuracion.php");
include_once("../estructura/header.php");
autorizar(["admin"]);

$datos = darDatosSubmitted();

$objControl = new ABMUsuario();
$objUsrRol = new abmUsuarioRol();
$lista = $objControl->buscar(null);
$listaUsuariosRol = $objUsrRol->buscar(null);

?>
<body class="bg-dark">
<?php
    include_once("../estructura/menu/menu.php");
    $rutalogo = "./img/";
    include_once("../estructura/Navbar.php");
?>
    <h3 class="text-white text-center my-3">Lista de Usuarios</h3>

    <div class="row float-left">
        <div class="col-md-12 float-left">
        <?php 
        if(isset($datos) && isset($datos['msg']) && $datos['msg']!=null) {
            echo $datos['msg'];
        }
        ?>
        </div>
    </div>

    <div class="row float-right">

        <div class="col-md-12 float-right text-center">
            <a class="btn btn-outline-success m-3" role="button" href="registrarse.php">Nuevo</a>

        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-bordered">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Rol</th>
                <th scope="col">Desabilitado</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>

                <?php

                    if( count($lista)>0){
                        
                        foreach ($lista as $objTabla) {
                            $idUsuario = $objTabla->getidusuario();
                            $idRol = null;
                            echo '<tr><td>'.$objTabla->getidusuario().'</td>';
                            echo '<td>'.$objTabla->getusnombre().'</td>';
                            echo '<td>'.$objTabla->getusmail().'</td>';

                            //busco el id del rol para mostrarlo
                            foreach ($listaUsuariosRol as $objRol){
                                if($objRol->getUsuario()->getIdUsuario() == $idUsuario){
                                    $idRol = $objRol->getRol()->getIdRol();
                                }
                            }
                            echo '<td>'.$idRol.'</td>';
                            echo '<td>'.$objTabla->getusdeshabilitado().'</>';
                            echo '<td><a class="btn btn-outline-info m-2" role="button" href="editar.php?accion=editar&idusuario='.$objTabla->getidusuario().'">editar</a>';
                            echo '<a class="btn btn-outline-danger m-2" role="button" href="editar.php?accion=borrar&idusuario='.$objTabla->getidusuario().'">borrar</a></td></tr>';
                        }
                    }

                ?>
            </tbody>
        </table>
    </div>
    <div class="contenedor">

    </div>
    <div class="fixed-bottom">
        <?php include_once("../estructura/Footer.php"); ?>

    </div>
    </body>
    <script src="./js/usuario/admin_modificaUsr.js"></script>
</html>