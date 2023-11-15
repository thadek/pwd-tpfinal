<?php
    $titulo = "Modificar usuario";
    header('Content-Type: application/json');
    require_once('../../../configuracion.php');

    $datos = darDatosSubmitted();

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(
            isset($datos["idusuario"])&& 
            isset($datos["usnombre"]) && 
            isset($datos["usmail"]) && 
            isset($datos["usrol"]) && 
            isset($datos["usdeshabilitado"])
        ){
            $idUser = $datos["idusuario"];
            $nombreUsuario = $datos["usnombre"];
            $mail = $datos["usmail"];
            $rol = $datos["rol"];
            $deshabilitado["usdeshabilitado"];

            $abmUsuario = new AbmUsuario();
            $abmUsuarioRol = new abmUsuarioRol();

            $datosUsuario = array(
                "idusuario" => $idUser,
                "usnombre" => $nombreUsuario,
                "usmail" => $mail,
                "usdeshabilitado" => $deshabilitado
            );

            $datosRol = array(
                "idusuario" => $idUser,
                "idrol" => $rol
            );

            $resultadoUsuario = $abmUsuario->modificacion($datosUsuario);
            $resultadoRol = $abmUsuarioRol->modificacion($datosRol);

            if($resultadoRol){
                $resp['resultado'] = "Los cambios se realizaron con éxito";
                $resp['error'] = false;
                echo json_encode($resp);
            }else{
                $resp['resultado'] = "No se pudieron realizar los cambios";
                $resp['error'] = true;
                http_response_code(400);
                echo json_encode($resp);
            }

        }else{
            $resp["resultado"] = "Faltan datos para realizar la modificacion.";
            $resp["error"] = true;
            http_response_code(400);
            echo json_encode($resp);
        }
    }

?>