<?php
$Titulo = " Especie ";
include_once("../../configuracion.php");
include_once("../../estructura/header.php");
include_once("../../estructura/menu/menu.php");
$rutalogo = "./../img/";
include_once("../../estructura/Navbar.php");
$datos = darDatosSubmitted();
$resp = false;
$objTrans = new ABMRol();
print_r($datos);
    if (isset($datos['accion'])){
        $resp = $objTrans->abm($datos);
        if($resp){
            $mensaje = "La accion ".$datos['accion']." se realizo correctamente.";
        }else {
            $mensaje = "La accion ".$datos['accion']." no pudo concretarse.";
        }
        //echo $mensaje;
        echo("<script>location.href = './verRoles.php?msg=$mensaje';</script>");
    }
?>
