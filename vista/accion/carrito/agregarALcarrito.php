<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$session = new Session();
    if(!$session->validar()){
        respuestaEstandar(' No hay usuario logueado',401);
    }
   


$idproducto = $datos["idProducto"];

$abmIniciarCompra = new ABMIniciarCompra();

$resp = $abmIniciarCompra->abm($idproducto);

if($resp){
    respuestaEstandar($resp['message'],$resp['status']);
}

?>
