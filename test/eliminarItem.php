<?php

include_once '../configuracion.php';

/*$abmUsuario = new AbmUsuario();

$salida = $abmUsuario->cargarCarritoUser();

*/

/*$abmCompra = new ABMCarrito();

$compra = $abmCompra->crearCarrito();

print_r($compra);*/

$abmCarrito = new ABMCarrito();

$res = $abmCarrito->eliminarItem(17);

print_r($res);
