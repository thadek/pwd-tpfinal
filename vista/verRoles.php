<?php
$titulo = "Gestión de Roles";
include_once("../configuracion.php");
include_once("../estructura/header.php");
include_once("../estructura/menu/menu.php");
$rutaLogo = "./img/";
include_once("../estructura/Navbar.php");
$datos = darDatosSubmitted();

$obj = new ABMRol();
$listaRoles = $obj->buscar(null);
?>
<body class="bg-dark">

<div class="row float-left">
    <div class="col-md-12 float-left">
      <?php 
      if(isset($datos) && isset($datos['msg']) && $datos['msg']!=null) {
        echo $datos['msg'];
      }
     ?>
    </div>
</div>

<div class="container mt-4">
    <h3 class="mb-4 text-light">ABM - Roles</h3>

    <div class="row justify-content-end">
        <div class="col-md-12">
            <a class="btn btn-success" role="button" href="editarRol.php?accion=nuevo&idrol=-1">Nuevo</a>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-stripped table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($listaRoles) > 0) : ?>
                    <?php foreach ($listaRoles as $rol) : ?>
                        <tr>
                            <td><?= $rol->getidrol() ?></td>
                            <td><?= $rol->getrodescripcion() ?></td>
                            <td>
                                <a class="btn btn-info" role="button" href="editarRol.php?accion=editar&idrol=<?= $rol->getidrol() ?>">Editar</a>
                                <a class="btn btn-primary" role="button" href="editarRol.php?accion=borrar&idrol=<?= $rol->getidrol() ?>">Borrar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3">No hay roles disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="contenedor">
    </div>
<?php include_once("../estructura/footer.php"); ?>
</body>
