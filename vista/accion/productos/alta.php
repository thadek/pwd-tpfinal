<?php
header('Content-Type: application/json');

include_once('../../../configuracion.php');

autorizar(["deposito"]);

//$datos = darDatosSubmitted();

$abmProducto = new AbmProducto();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    
    // Obtener el contenido de la petición
    $json_data = file_get_contents("php://input");
    
    // Decodificar el JSON
    $datos_arr = json_decode($json_data, true); // Si el segundo parámetro es true, se convierte en array asociativo

    // Verificar si la decodificación fue exitosa
    if ($datos_arr === null && json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Error al decodificar el JSON"]);
        exit;
    }

    
        $producto = $abmProducto->alta($datos_arr);
        if($producto != null){
            $response["status"] = 200;
            $response["message"] = "Producto agregado correctamente";
            http_response_code($response["status"]);
            echo json_encode($response);
        }else{
            $response["status"] = 500;
            $response["message"] = "Error al agregar producto.";
            http_response_code($response["status"]);
            echo json_encode($response);
        }

} else {
    // Si la petición no es POST, puedes devolver un código de respuesta HTTP apropiado
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Método no permitido"]);
}

?>








