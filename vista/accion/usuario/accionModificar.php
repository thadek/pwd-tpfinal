<?php

include_once("../../../configuracion.php");

$datos = darDatosSubmitted();

verificarMetodoHttp('GET');
if(isset($datos['idusuario'])){

    $abmMenu = new ABMUsuario();
    $respuesta = $abmMenu->modificacion($datos);

    respuestaEstandar('Operacion exitosa', 200);
    if ($respuesta) {
        respuestaEstandar('Operacion exitosa', 200);

    } else {
        respuestaEstandar('Hubo un error en la operacion', 400);
    }
}

?>