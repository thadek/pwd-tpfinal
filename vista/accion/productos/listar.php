<?php

require_once '../../../configuracion.php';
header('Content-Type: application/json');

$datos = darDatosSubmitted();


//Obtener lista de productos
    verificarMetodoHttp("GET");
    $abmProducto = new AbmProducto();
    $salida = array();

    if(isset($datos["id"])){
        $producto = $abmProducto->buscar(["idproducto"=>$datos["id"]]);
        if(count($producto) == 0){
            respuestaEstandar("Producto no encontrado",404);
        }
        $productoJSON = $producto[0]->jsonSerialize();
        handleResponse($productoJSON);
    } 
   
    renderizarProductos();



function renderizarProductos(){
    $abmProd = new AbmProducto();
    $lista = $abmProd->renderProductosJSON();
    handleResponse($lista);
}