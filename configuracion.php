<?php

$PROYECTO = 'pwd/pwd-tpfinal';

$page_title = "TP Final - Grupo 8 - PWD 2023";

//variable que almacena el directorio del proyecto
$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";

include_once ($ROOT . '/utils/functions.php');


// Variable que define la pagina de autenticacion del proyecto
$INICIO = "Location:http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/vista/login/login.php";

// variable que define la pagina principal del proyecto (menu principal)
$PRINCIPAL = "Location:http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/index.php";

$ERROR_403 = "Location:http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/vista/error/403.php";

$_SERVER['ROOT'] = $ROOT;
$_SERVER['ERROR_403'] = $ERROR_403;

include_once($ROOT.'/utils/autorizar.php');