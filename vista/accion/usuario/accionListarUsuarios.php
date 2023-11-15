<?php

    require_once '../../../configuracion.php';
    header('Content-Type: application/json');

    $datos = darDatosSubmitted();


    //obtengo lista de usuarios y usuarios roles
    if($_SERVER["REQUEST_METHOD"] === "GET"){
        $abmUsuario = new ABMUsuario();
        $abmUsuarioRol = new abmUsuarioRol();
        $salida= array();

            $usuarios = $abmUsuario->buscar(null);
            $usuariosRol = $abmUsuarioRol->buscar(null);
            $usuariosYRoles = [];

            foreach ($usuarios as $objUsuario) {
                $idUsuario = $objUsuario->getIdUsuario();
                $usNombre = $objUsuario->getUsNombre();
                $usMail = $objUsuario->getUsMail();
                $usDeshabilitado = $objUsuario->getUsDeshabilitado();
                $idRol = null;
                foreach ($usuariosRol as $objRol){
                    if($objRol->getUsuario()->getIdUsuario() == $idUsuario){
                        $idRol = $objRol->getRol()->getrodescripcion();
                        break;
                    }
                }
                $usuarioConRol = [
                    'idUsuario' => $idUsuario,
                    'usNombre' => $usNombre,
                    'usMail' => $usMail,
                    'usRol' => $idRol,
                    'usDeshabilitado' => $usDeshabilitado
                ];
                array_push($usuariosYRoles, $usuarioConRol);
            }
            echo json_encode($usuariosYRoles);
            die();
    }else{
        $response["status"] = 501;
        $response["message"] = "Metodo no implementado";
        http_response_code($response["status"]);
        echo json_encode($response);
    }
