<?php

require_once '../../../configuracion.php';


$datos = darDatosSubmitted();

    verificarMetodoHttp("GET");
    //Obtener una unica compra
    if(isset($datos["id"])){
       buscarCompraPorId($datos["id"]);
    }

    if(isset($datos["estado"])){
        buscarPorEstado($datos["estado"]);
    }
     //Obtener todas las compras
    listarCompras();


//Funciones auxiliares

function buscarCompraPorId($id){
    $abmCompra = new AbmCompra();
    $compra = $abmCompra->buscar(["idcompra"=>$id]);
    //Si no encuentro resultados devuelvo 404.
     if(count($compra) == 0){
         respuestaEstandar("Compra no encontrada",404);
     }
     //Si encuentro resultados devuelvo el primero.
     $compraJSON = $compra[0]->jsonSerialize();
     handleResponse($compraJSON);
}

function buscarPorEstado($estado){
    $abmCompra = new AbmCompra();
    $compra = $abmCompra->obtenerComprasPorEstado($estado);
    $compraJSON = array();
    foreach ($compra as $compra) {
        array_push($compraJSON,$compra->jsonSerialize());
    }
    handleResponse($compraJSON);
}

function listarCompras(){
    $abmCompra = new AbmCompra();
    $compra = $abmCompra->buscar(null);
    $compraJSON = array();
    foreach ($compra as $compra) {
        array_push($compraJSON,$compra->jsonSerialize());
    }
    handleResponse($compraJSON);
}