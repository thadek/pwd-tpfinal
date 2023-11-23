<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$abmCarrito = new ABMCarrito();

$res = $abmCarrito->iniciarCompra();

respuestaEstandar($res['msg'],200);


