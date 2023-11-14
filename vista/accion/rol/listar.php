<?php
require_once '../../../configuracion.php';

header('Content-Type: application/json');

$datos = darDatosSubmitted();

if($_SERVER["REQUEST_METHOD"] === "GET"){
    $abmRol = new ABMRol();




?>