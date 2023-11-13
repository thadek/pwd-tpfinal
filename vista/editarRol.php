<?php
$Titulo = " Especie ";
include_once("../configuracion.php");
include_once("../estructura/header.php");
include_once("../estructura/menu/menu.php");
$rutalogo = "./img/";
include_once("../estructura/Navbar.php");
$datos = darDatosSubmitted();

$objC = new ABMRol();
$obj =NULL;
print_r($datos);
if (isset($datos['idrol']) && $datos['idrol'] <> -1){
    $listaTabla = $objC->buscar($datos);
    if (count($listaTabla)==1){
        $obj= $listaTabla[0];
    }
}

?>	
<form method="post" action="accion/accionEditarRol.php">
    <input id="idrol" name ="idrol" type="hidden" value="<?php echo ($obj !=null) ? $obj->getidrol() : "-1"?>" readonly required >
    <input id="accion" name ="accion" value="<?php echo ($datos['accion'] !=null) ? $datos['accion'] : "nose"?>" type="hidden">
    <div class="row mb-12">
        <div class="col-sm-12 ">
            <div class="form-group has-feedback">
                <label for="nombre" class="control-label">Nombre:</label>
                <div class="input-group">
                    <input id="rodescripcion" name="rodescripcion" type="text" class="form-control" value="<?php echo ($obj !=null) ? $obj->getrodescripcion() : ""?>" required >

                </div>
            </div>
        </div>
    </div>
	
	<input type="submit" class="btn btn-primary btn-block" value="<?php echo ($datos['accion'] !=null) ? $datos['accion'] : "nose"?>">
</form>
<a href="index.php">Volver</a>

<?php
include_once("../estructura/footer.php");
?>