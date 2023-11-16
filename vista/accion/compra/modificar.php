<?php

require_once '../../../configuracion.php';
header('Content-Type: application/json');

$datos = darDatosSubmitted();


    verificarMetodoHttp("POST");

    if(isset($datos["accion"]) && isset($datos["idcompra"])){

        if($datos["accion"] === "modificarEstado" && isset($datos["idcompraestadotipo"])){
            modificarEstadoCompra($datos["idcompra"],$datos["idcompraestadotipo"]);   
        }else if($datos["accion"]==="confirmarCompra"){
            confirmarCompra($datos["idcompra"]);     
        }else{
            respuestaEstandar("Faltan datos",400);
        }

    }else{
        respuestaEstandar("Faltan datos",400);
    }



/**
 * Modifica el estado de una compra
 */
function modificarEstadoCompra($idCompra,$idCompraEstadoTipo){

       //Chequeo que la compra exista
       $abmCompra = new AbmCompra();
       $compra = $abmCompra->buscar(["idcompra"=>$idCompra]);
       if(count($compra) == 0){
           respuestaEstandar("Compra no encontrada",404);
       }

       //Si existe la compra, cambio el estado.
       $abmCompraEstado = new AbmCompraEstado();
       $response = $abmCompraEstado->cambiarEstadoDeCompra(intval($idCompra),intval($idCompraEstadoTipo));

       if($response["status"]){
           respuestaEstandar($response['msg'],200);
       }else{
           respuestaEstandar($response['msg'],424);
       }

}


function confirmarCompra($idCompra){

            $abmCompra = new AbmCompra();
            $compra = $abmCompra->buscar(["idcompra"=>$idCompra]);
            if(count($compra) == 0){
                respuestaEstandar("Compra no encontrada",404);
            }

            //Si existe la compra, cambio el estado.
            $abmCompraEstado = new AbmCompraEstado();
            $response = $abmCompraEstado->confirmarCompra(intval($idCompra));
            if($response["status"]){
                respuestaEstandar($response['msg'],200);
            }else{
                respuestaEstandar($response['msg'],424);
            }
}