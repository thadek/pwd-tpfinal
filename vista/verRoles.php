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

<div class="container mt-4 cont">
    <h3 class="mb-4 text-light">ABM - Roles</h3>

    <div class="row justify-content-end mb-3">
        <div class="col-md-12">
            <a class="btn btn-success btn-nuevo" role="button" id="btn-nuevo">Nuevo</a>
            <div id="nuevo-rol-container" style="display: none;">
                <input type="text" class="form-control" id="input-nuevo-rol" placeholder="Nuevo Rol">
                <button class="btn btn-success btn-aplicar-nuevo" id="btn-aplicar-nuevo">Aplicar</button>
            </div>
        </div>
    </div>

   
        <table class="table  table-dark" id="tabla-roles">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listaRoles as $rol) : ?>
                <tr>
                    <td><?= $rol->getIdRol() ?></td>
                    <td>
                        <span class="nombre-rol"><?= $rol->getRoDescripcion() ?></span>
                        <input type="text" class="form-control input-nombre-rol" style="display: none;">
                    </td>
                    <td>
                        <button class="btn btn-info btn-editar" data-id="<?= $rol->getIdRol() ?>">Editar</button>
                        <button class="btn btn-danger btn-borrar" data-id="<?= $rol->getIdRol() ?>">Borrar</button>
                        <button class="btn btn-success btn-aplicar" data-id="<?= $rol->getIdRol() ?>" style="display: none;">Aplicar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    
</div>

<?php include_once("../estructura/footer.php"); ?>

<script src="js/jquery.js"></script>
<script src="js/rol/alterar_rol.js"></script> <!-- Archivo JavaScript para manejar eventos -->
</body>
</html>