<?php
            header('Content-Type: application/json');
            require_once('../../configuracion.php');
            $datos = darDatosSubmitted();
        
              if(isset($datos["usnombre"]) && isset($datos["usmail"]) && isset($datos["uspass"]) && $_SERVER["REQUEST_METHOD"] === "POST"){
                        $nombreUsuario = $datos["usnombre"];
                        $mail = $datos["usmail"];
                        $pass = $datos["uspass"];

                        $abmUsuario = new AbmUsuario();
                        $resultado = $abmUsuario->agregarNuevoUsuario($nombreUsuario, $pass, $mail);     
                        if(isset($resultado["error"])){
                          http_response_code(409);
                        }      
                        echo json_encode($resultado);
              }else{
                       $resp["resultado"] = "Faltan datos para realizar el registro.";
                       $resp["error"] = true;
                       http_response_code(400);
                       echo json_encode($resp);
              }
            
    ?>
         