<?php

require_once('../../../configuracion.php');



$abmCarrito = new ABMCarrito();

$carritoUsr = $abmCarrito->obtenerCarrito();

if($carritoUsr == null){
    $carritoUsr = [];
    handleResponse($carritoUsr);
}else{
    handleResponse($carritoUsr->jsonSerialize());
}
