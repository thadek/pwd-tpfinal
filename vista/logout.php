<?php

require_once('../configuracion.php');

$session = new Session();

if($session->validar()){
    $session->cerrar();
    header("Location:".$PRINCIPAL);
}else{
    header("Location:".$LOGIN);
}