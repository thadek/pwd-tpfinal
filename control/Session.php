<?php

class Session {


    public function __construct()
    {
        if(!self::activa()){
            session_start();
        }   
  
    }
    

    public function iniciar($usr,$password){
        $resp = false;
        $obj = new ABMUsuario();
        $param['usnombre'] = $usr;
        $param['usdeshabilitado'] = null;
        $res = $obj->buscar($param);
        
        if(count($res)>0 && Hash::verificar_hash($password,$res[0]->getUsPass())){
            $_SESSION['idusuario'] = $res[0]->getIdUsuario();
           $roles = $this->getRoles();
           //Seteo el rol por defecto del usuario
           $this->setIdRol($roles[0]->getIdRol());
            $resp = true;
        }else{
            $this->cerrar();
        }

        return $resp;
    }

 
    public function cerrar(){
        session_unset();
        session_destroy();
    }


    public function getUsuario(){
        $resp = null;
        if(isset($_SESSION['idusuario'])){
            $obj = new ABMUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $resp = $obj->buscar($param);
        }
        return $resp[0];
    }

    /**
     * Devuelve un arreglo de objetos rol del usuario actual.
     * @return Array<Roles>
     */
    public function getRoles(){
        $resp = null;
        if(isset($_SESSION['idusuario'])){
            $obj = new ABMUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $resp = $obj->darRoles($param);
        }else{
            $rolVisitante = AbmRol::obtenerRolVisitante();
            $resp = array($rolVisitante);
        }

        return $resp;

    }


    public function getRolesJSON(){
       
        $roles = $this->getRoles();
        $rolesJSON = array_map(function($rol){
            return $rol->jsonSerialize();
        },$roles);
        return $rolesJSON;
    }


    /**
     * Si el usuario posee multiples roles, esta funcion recibe el id rol
     * seleccionado para visualizar el sitio
     * @param int $idRol
     * @return boolean
     */
    public function setIdRol($idRol){
        $resp = false;
        if($this->validar()){
            $roles = $this->getRoles();
            $roles = array_map(function($rol){
                return $rol->getIdRol();
            },$roles);
            
            if(in_array($idRol,$roles)){
                $resp = true;
                $_SESSION['idrol'] = $idRol;
            }
        }
        return $resp;
    }

    /**
     * Devuelve el id de rol seleccionado para visualizar el sitio
     */
    public function getIdRol(){
        $resp = null;
        if(isset($_SESSION['idrol'])){
            $resp= $_SESSION['idrol'];
        }else{
            $rolVisitante = AbmRol::obtenerRolVisitante();
            $resp = $rolVisitante->getIdRol();
        }
        return $resp;
    }


    /**
     * Valida que la sesion sea válida y obtiene el objeto rol perteneciente al usuario logueado.
     */
    public function getRol(){
        if($this->validar()){
            $obj = new ABMRol();
            $param['idrol'] = $this->getIdRol();
            $rol = $obj->buscar($param);
            return $rol[0];
        }
    }


      /**
     * Valida si la sesión actual tiene un usuario cargado. Devuelve true o false.
     */
    public function validar(){
        $resp = false;
        if($this->activa() && isset($_SESSION['idusuario']))
            $resp=true;
        return $resp;
    }



    public static function activa(){
        return session_status() === PHP_SESSION_ACTIVE;
    }



    public function cambiarRolVisualizar($idRol){
        $salida = [];  
        if($this->validar() && $this->setIdRol($idRol)){
                $salida["mensaje"] = "Rol de visualizacion modificado.";
                $salida["error"] = false;    
       }else{
          $salida["mensaje"] = "Error al modificar el rol.";
          $salida["error"] = true;
        }
        return $salida;
    }


    public function autorizarPeticion(){  
        $autorizado = false;
        $abmRol = new AbmRol();
        $autorizado = $abmRol->obtenerAutorizacionPorRol($this->getIdRol());
        if(!$autorizado){
            header('Location:'.$_SERVER['RUTAVISTA']);
        }
        return $autorizado;
    }

    
}