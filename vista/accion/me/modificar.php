<?php

require_once '../../../configuracion.php';
autorizar(['cliente','deposito']);

$datos = darDatosSubmitted();

verificarMetodoHttp("POST");


if(isset($datos['password']) and isset($datos['accion'])){
    if($datos['accion'] == 'modificar_password'){
        modificarPassword($datos['password']);
    }else{
        respuestaEstandar("La accion no es valida", 400);
    }
}else{
    respuestaEstandar("Faltan datos", 400);
}
    


function modificarPassword($password){
    $abmUsuario = new AbmUsuario();
    $salida = $abmUsuario->modificarPassword($password);
    if($salida['error']){
        respuestaEstandar($salida['mensaje'], 424);
    }
    respuestaEstandar($salida['mensaje'], 200);
}