<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

verificarMetodoHttp("POST");

$abmCarrito = new AbmCarrito();
$salida = $abmCarrito->vaciarCarrito();

respuestaEstandar($salida['message'],$salida['status']);






