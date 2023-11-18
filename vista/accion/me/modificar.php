<?php

require_once '../../../configuracion.php';


$datos = darDatosSubmitted();

verificarMetodoHttp("POST");


if(isset($datos['accion'])){
    if(isset($datos['password']) && $datos['accion'] == 'modificar_password'){
        modificarPassword($datos['password']);
    }else if(isset($datos['email']) && $datos['accion'] == 'modificar_email'){
        modificarEmail($datos['email']);
    }else if(isset($datos['idrol']) && $datos['accion'] == 'cambiar_rol_visualizar'){
        cambiarRolVisualizar($datos['idrol']);
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


function modificarEmail($email){
    $abmUsuario = new AbmUsuario();
    $salida = $abmUsuario->modificarEmail($email);
    if($salida['error']){
        respuestaEstandar($salida['mensaje'], 424);
    }
    respuestaEstandar($salida['mensaje'], 200);
}

function cambiarRolVisualizar($idRol){
    $session = new Session();
    $salida = $session->cambiarRolVisualizar($idRol);
    if($salida['error']){
        respuestaEstandar($salida['mensaje'], 424);
    }
    respuestaEstandar($salida['mensaje'], 200);
}