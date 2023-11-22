<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$session = new Session();
    if(!$session->validar()){
        respuestaEstandar(' No hay usuario logueado',401);
    }
   


$idproducto = $datos["idProducto"];

$abmCarrito = new AbmCarrito();
$resp = $abmCarrito->agregarItemAlCarrito($idproducto,1);

if($resp){
    respuestaEstandar($resp['message'],$resp['status']);
}

?>
