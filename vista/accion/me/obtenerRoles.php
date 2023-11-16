<?php

require_once '../../../configuracion.php';
autorizar(['cliente','deposito','visitante']);

$datos = darDatosSubmitted();

verificarMetodoHttp("GET");

obtenerRoles();

function obtenerRoles(){
    $session = new Session();
    if($session->validar()){
        $roles = $session->getRolesJSON();
        handleResponse($roles,200);
    }
}
 




