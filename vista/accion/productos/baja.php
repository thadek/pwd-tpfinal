<?php

header('Content-Type: application/json');

include_once('../../../configuracion.php');



//$datos = darDatosSubmitted();

$abmProducto = new AbmProducto();

    verificarMetodoHttp("POST");
    // Obtener el contenido de la petición
    $json_data = file_get_contents("php://input");
    
    // Decodificar el JSON
    $datos_arr = json_decode($json_data, true); // Si el segundo parámetro es true, se convierte en array asociativo

    // Verificar si la decodificación fue exitosa
    if ($datos_arr === null && json_last_error() !== JSON_ERROR_NONE) {
        respuestaEstandar("Error al decodificar el JSON", 400);
        
    }

    $producto = $abmProducto->baja($datos_arr);
    if($producto != null){
        respuestaEstandar("Producto eliminado correctamente", 200);
    }else{
        respuestaEstandar("Error al eliminar producto.", 500);
    }
