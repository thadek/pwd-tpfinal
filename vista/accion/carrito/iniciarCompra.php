<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$abmCarrito = new ABMCarrito();

$abmCarrito->iniciarCompra();

respuestaEstandar("Compra iniciada",200);


