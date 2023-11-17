<?php

require_once '../../../configuracion.php';
//autorizar(['admin']);

$datos = darDatosSubmitted();


$abmMenu = new ABMMenu();

$salida = $abmMenu->obtenerMenuRolJSON();

handleResponse($salida);