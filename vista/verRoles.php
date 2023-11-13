<?php
$Titulo = " Gestion de Roles";
include_once("../configuracion.php");
include_once("../estructura/header.php");
include_once("../estructura/menu/menu.php");
$rutalogo = "./img/";
include_once("../estructura/Navbar.php");

$obj= new ABMRol();
$lista = $obj->buscar(null);

?>
<h3>ABM - Roles</h3>



<div class="row float-right">

    <div class="col-md-12 float-right">
        <a class="btn btn-success" role="button" href="editar.php?accion=nuevo&idrol=-1">Nuevo</a>

    </div>
</div>


<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>

<?php
 if( count($lista)>0){
    foreach ($lista as $objTabla) {
        echo '<tr><td>'.$objTabla->getidrol().'</td>';
        echo '<td>'.$objTabla->getrodescripcion().'</td>';
        echo '<td><a class="btn btn-info" role="button" href="editarRol.php?accion=editar&idrol='.$objTabla->getidrol().'">editar</a>';
        echo '<a class="btn btn-primary" role="button" href="editarRol.php?accion=borrar&idrol='.$objTabla->getidrol().'">borrar</a></td></tr>';
	}
}

?>
        </tbody>
    </table>
</div>


<?php

include_once("../estructura/footer.php");
?>