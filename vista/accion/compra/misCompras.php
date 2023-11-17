<?php

require_once '../../../configuracion.php';



$datos = darDatosSubmitted();

    verificarMetodoHttp("GET");
    $abmusuario = new ABMUsuario();