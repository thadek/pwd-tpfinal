<?php

include_once '../configuracion.php';

/*$abmUsuario = new AbmUsuario();

$salida = $abmUsuario->cargarCarritoUser();

*/

/*$abmCompra = new ABMCarrito();

$compra = $abmCompra->crearCarrito();

print_r($compra);*/

$abmCarrito = new ABMCarrito();

$resultado1 = $abmCarrito->agregarItemAlCarrito(1,0);
$resultado2 = $abmCarrito->agregarItemAlCarrito(3,3);

print_r($resultado1);
print_r($resultado2);
