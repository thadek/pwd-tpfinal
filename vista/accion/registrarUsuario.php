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

                        $resp["resultado"] = $resultado;
                      echo json_encode($resp);
              }else{
                $resp["resultado"] = "Faltan datos";
                       echo json_encode($resp);
              }
            
    ?>
         