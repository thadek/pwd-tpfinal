<?php

$PROYECTO = 'pwd/pwd-tpfinal';

$page_title = "TP Final - Grupo 8 - PWD 2023";

//variable que almacena el directorio del proyecto
$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";

include_once ($ROOT . '/utils/functions.php');


// Variable que define la pagina de autenticacion del proyecto
$LOGIN = "http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/vista/login.php";

// variable que define la pagina principal del proyecto (menu principal)
$PRINCIPAL = "http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/index.php";

$ERROR_403 = "http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/vista/error/403.php";

$_SERVER['ROOT'] = $ROOT;
$_SERVER['ERROR_403'] = $ERROR_403;
$_SERVER['LOGIN'] = $LOGIN;
$_SERVER['PRINCIPAL'] = $PRINCIPAL;

include_once($ROOT.'/utils/autorizar.php');