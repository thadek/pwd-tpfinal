<?php

require_once('../../../configuracion.php');

$abmCarrito = new AbmCarrito();

verificarMetodoHttp('POST');

$session = new Session();
    if(!$session->validar()){
        respuestaEstandar(' No hay usuario logueado',401);
    }

    // Obtener el contenido de la petición
$json_data = file_get_contents("php://input");

// Decodificar el JSON
$datos_arr = json_decode($json_data, true); // Si el segundo parámetro es true, se convierte en array asociativo

// Verificar si la decodificación fue exitosa
if ($datos_arr === null && json_last_error() !== JSON_ERROR_NONE) {
    respuestaEstandar("Error al decodificar el JSON", 400);
    exit;
}

// Verificar si el JSON tiene los datos necesarios
if(!isset($datos_arr['idProducto']) || !isset($datos_arr['cantidad'])){
    respuestaEstandar('Faltan datos',400);
}


$resp = $abmCarrito->setearCantItem($datos_arr['idProducto'],$datos_arr['cantidad']);

respuestaEstandar($resp["message"],$resp["status"]);
