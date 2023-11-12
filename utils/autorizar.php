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

    //Si el usuario tiene el rol de administrador, no necesita verificar ningún otro rol.
   
        //Mapeo los roles a un arreglo de strings
        $arr_roles = array_map(function ($rol_usr) {
            return strtolower($rol_usr->getRoDescripcion());
        }, $roles_usr);


        if (!in_array("admin", $arr_roles)) {
        //Intersección entre los roles del usuario y los roles que se pasaron como parámetro
        $interseccion = array_intersect($arr_roles, $roles);
        //Si la intersección es vacía, el usuario no tiene ninguno de los roles que se pasaron como parámetro
        if (empty($interseccion)) {
            header($_SERVER['ERROR_403']);
        }
    }
}