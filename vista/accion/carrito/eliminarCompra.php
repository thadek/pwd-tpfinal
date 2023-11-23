<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$compra = $datos["idCompraItem"];

$abmTablaCarrito = new ABMTablaCarrito();

$abmTablaCarrito->eliminarCompra($compra);

