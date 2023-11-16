<?php

/**
 * Esta función de acceso global recibe un arreglo con nombres de rol a verificar y 
 * redirecciona a un sitio de error si el usuario no tiene ese rol.
 * @param array $roles
 */
function autorizar($roles)
{
    $session = new Session();
    $roles_usr = $session->getRoles();



    //Mapeo los roles a un arreglo de strings
    $arr_roles = array_map(function ($rol_usr) {
        return strtolower($rol_usr->getRoDescripcion());
    }, $roles_usr);


    //Si el usuario tiene rol de visitante, redirecciona a login.
    if (in_array("visitante", $arr_roles)) {
        header("Location:" . $_SERVER['LOGIN']);
        die();
    } else {
        //Si el usuario no tiene rol de admin, se verifica que tenga alguno de los roles que se pasaron como parámetro
        if (!in_array("admin", $arr_roles)) {
            //Intersección entre los roles del usuario y los roles que se pasaron como parámetro
            $interseccion = array_intersect($arr_roles, $roles);
            //Si la intersección es vacía, el usuario no tiene ninguno de los roles que se pasaron como parámetro
            if (empty($interseccion)) {
                
                header("Location:" . $_SERVER['ERROR_403']);
                die();
            }
        }
    }
}
