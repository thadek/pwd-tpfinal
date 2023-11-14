<?php

require_once '../../../configuracion.php';
header('Content-Type: application/json');

$datos = darDatosSubmitted();


//Obtener lista de productos
if($_SERVER["REQUEST_METHOD"] === "GET"){
    $abmProducto = new AbmProducto();
    $salida = array();

    if(isset($datos["id"])){
        $producto = $abmProducto->buscar(["idproducto"=>$datos["id"]]);
        if(count($producto) == 0){
            $response["status"] = 404;
            $response["message"] = "Producto no encontrado";
            http_response_code($response["status"]);
            echo json_encode($response);
            die();
        }
        $productoJSON = $producto[0]->jsonSerialize();
        echo json_encode($productoJSON);
        die();
    }
    $listaProductos = $abmProducto->buscar(null);
    $listaProductosJSON = array();
    foreach ($listaProductos as $producto) {
        array_push($listaProductosJSON,$producto->jsonSerialize());
    }

    echo json_encode($listaProductosJSON);

}else{
    $response["status"] = 501;
    $response["message"] = "Metodo no implementado";
    http_response_code($response["status"]);
    echo json_encode($response);
}