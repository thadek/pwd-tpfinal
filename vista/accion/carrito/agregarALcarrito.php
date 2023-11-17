<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$producto = $datos["idProducto"];

$abmIniciarCompra = new ABMIniciarCompra();

$abmIniciarCompra->abm($producto);



?>
