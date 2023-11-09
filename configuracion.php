<?php

$PROYECTO = 'pwd/pwd-tpfinal';

$page_title = "TP Final - Grupo 8 - PWD 2023";

//variable que almacena el directorio del proyecto
$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";

include_once ($ROOT . 'tp5/utils/functions.php');

// Variable que define la pagina de autenticacion del proyecto
$INICIO = "Location:http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/vista/login/login.php";

// variable que define la pagina principal del proyecto (menu principal)
$PRINCIPAL = "Location:http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/index.php";

$_SERVER['ROOT'] = $ROOT;
