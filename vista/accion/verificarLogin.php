<?php

require_once('../../configuracion.php');

$datos = darDatosSubmitted();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreUsuario = $datos["usnombre"];
    $password = $datos["uspass"];

    $session = new Session();
    $session->iniciar($nombreUsuario, $password);
    if ($session->validar()) {
       header("Location: ../index.php");
    } else {
        header("Location: ../login.php?error=1");
    }

}