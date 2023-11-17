<?php
require_once '../../../configuracion.php';

header('Content-Type: application/json');

$datos = darDatosSubmitted();

$abmRol = new AbmRol();

$roles = $abmRol->obtenerRolesJSON();

handleResponse($roles);



