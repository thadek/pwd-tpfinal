<?php

include_once '../configuracion.php';

$abmUsuario = new AbmUsuario();

$salida = $abmUsuario->cargarCarritoUser();


print_r($salida[0]->getItems());