<?php

require_once '../../../configuracion.php';


$datos = darDatosSubmitted();

verificarMetodoHttp("GET");

obtenerMisCompras();

function obtenerMisCompras(){
    $session = new Session();
    if($session->validar()){
        $abmCompra = new ABMCompra();
        $compras = $abmCompra->obtenerComprasJSON($session->getUsuario());
        handleResponse($compras,200);
    }
}