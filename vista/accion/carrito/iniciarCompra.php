<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$objAbmtablacarrito = new ABMTablaCarrito();

$objAbmtablacarrito->iniciarCompra();


