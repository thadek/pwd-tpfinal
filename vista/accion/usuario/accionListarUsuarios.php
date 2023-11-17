<?php

    require_once '../../../configuracion.php';
    header('Content-Type: application/json');
    $datos = darDatosSubmitted();
    autorizar(['admin']);

    $abmUsuario = new ABMUsuario();
    //obtengo lista de usuarios y roles
    if(isset($datos['idUsuario'])){
        $usuario = $abmUsuario->buscar(['id'=> $datos['idUsuario']]);
        if(count($usuario)>0){
            $usuario = $usuario[0];
            echo json_encode($usuario->jsonSerialize());
        }else{
            echo json_encode(null);
        }
        die();
    }else{
        $usuarios = $abmUsuario->buscar(null);

        $usuariosJSON = array();

        foreach($usuarios as $usuario) {
            array_push($usuariosJSON, $usuario->jsonSerialize());
        }

        echo json_encode($usuariosJSON);
    }


        /*$listaUsuarios = $abmUsuario->buscar(null);
        $listaUsuariosJSON = array();
        
        foreach ($listaUsuarios as $usuario) {
            array_push($listaUsuariosJSON, $usuario->jsonSerialize());
        }

        echo json_encode($listaUsuariosJSON);
        die();


    }else{
        $response["status"] = 501;
        $response["message"] = "Metodo no implementado";
        http_response_code($response["status"]);
        echo json_encode($response);
    }*/

    

