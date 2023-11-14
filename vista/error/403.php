<?php

include_once("../../configuracion.php");
include_once("../../estructura/header.php");



$response["status"] = 403;
$response["message"] = "No tiene permisos para acceder a este recurso";

http_response_code($response["status"]);

echo json_encode($response);