<?php

header('Content-Type: application/json');
require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$nombreUsuario = $datos["usnombre"];
$pass = $datos["uspass"];

$session = new Session();
$session = $session->iniciar($nombreUsuario, $pass);


if(isset($datos["producto"]) && isset($datos["cantidad"]) && isset($datos["precio"]) && $_SERVER["REQUEST_METHOD"] === "POST"){
          $producto = $datos["producto"];
          $cantidad = $datos["cantidad"];
          $precio = $datos["precio"];

          $abmUsuario = new AbmUsuario();
          $resultado = $abmUsuario->agregarNuevoUsuario($nombreUsuario, $pass, $mail);     
          if(isset($resultado["error"])){
            http_response_code(409);
          }      
          echo json_encode($resultado);
        }