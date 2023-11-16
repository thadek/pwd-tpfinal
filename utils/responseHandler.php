<?php

/**
 * Recibe un objeto o array, lo parsea a json y lo muestra por salida.
 */
function handleResponse($response,$status = 200){
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($response);
    die();
}


/**
 * Recibe el mensaje a enviar y el codigo http de respuesta
 */
function respuestaEstandar($message,$status){
    $response["status"] = $status;
    $response["message"] = $message;
    handleResponse($response,$status);
}

/**
 * Verifica que el metodo http sea enviado por parametro
 */
function verificarMetodoHttp($metodo){
    if($_SERVER["REQUEST_METHOD"] !== $metodo){
        respuestaEstandar("Metodo no permitido",405);
    }
}