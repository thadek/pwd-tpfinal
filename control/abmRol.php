<?php


class ABMRol{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    
    public function abm($datos){
        $resp = false;
        if($datos['accion']=='editar'){
            if($this->modificacion($datos)){
                $resp = true;
            }
        }
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
            if($this->alta($datos)){
                $resp =true;
            }
            
        }
        return $resp;

    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Tabla
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('idrol',$param)  and array_key_exists('rodescripcion',$param) ){
            $obj = new Rol();
            $obj->cargar($param['idrol'],$param['rodescripcion']);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Tabla
     */
    
    private function cargarObjetoConClave($param){
        $obj = null;
        if( isset($param['idrol']) ){
            $obj = new Rol();
            $obj->cargar($param['idrol'], null);
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idrol']))
            $resp = true;
        return $resp;
    }
    
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idrol'] =null;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla!=null ){
            $resp = $elObjtTabla->insertar();
        }
        return $resp;
        
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla!=null and $elObjtTabla->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjeto($param);
            if($elObjtTabla!=null and $elObjtTabla->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    

    public function darUsuarios($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idusuario']))
                $where.=" and idusuario =".$param['idusuario'];
            if  (isset($param['idrol']))
                 $where.=" and idrol ='".$param['idrol']."'";
        }
        $obj = new UsuarioRol();
        $arreglo = $obj->listar($where);
        return $arreglo;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idrol']))
                $where.=" and idrol =".$param['idrol'];
            if  (isset($param['rodescripcion']))
                 $where.=" and rodescripcion ='".$param['rodescripcion']."'";
         }
        $obj = new Rol();
        $arreglo = $obj->listar($where);
        return $arreglo;   
    }
    

     /**
     * Funcion que recibe el id de rol, y realiza una consulta sql especifica entre
     * la tabla menurol y menu para obtener el link del menu que se quiere acceder y si el mismo posee el id de rol asignado para visualizar
     * devuelve true, caso contrario devuelve false   
     * @param int $idRol
     * @return boolean
     */
    public function obtenerAutorizacionPorRol($idRol){
        $salida = false;
        $bd = new BaseDatos();
        $link = basename($_SERVER['SCRIPT_NAME']);  
        $sql = "SELECT * FROM menurol mr INNER JOIN menu m ON mr.idmenu = m.idmenu WHERE mr.idrol = ".$idRol." AND m.link LIKE '%".$link."%'";
        $resultado = $bd->Ejecutar($sql);
        if($resultado  >0 && $resultado > -1){
            $salida = true;
        }
        return $salida;

    }





    /**
     * Devuelve un objeto rol con el nombre 'Visitante'
     * @return Rol
     */
    public static function obtenerRolVisitante(){
        $obj = new AbmRol();
        $param['rodescripcion'] = 'visitante';
        $arreglo = $obj->buscar($param);
        $salida = null;
        if(count($arreglo)>0){
            $salida = $arreglo[0];
        }
        return $salida;
    }


    /**
     * Devuelve un objeto rol con el nombre 'Cliente'
     */
    public static function obtenerRolCliente(){
        $obj = new AbmRol();
        $param['rodescripcion'] = 'cliente';
        $arreglo = $obj->buscar($param);
        $salida = null;
        if(count($arreglo)>0){
            $salida = $arreglo[0];
        }
        return $salida;
    }



    function obtenerRolesJSON(){
        $roles = $this->buscar(null);
        $rolesJSON = array();
        foreach ($roles as $rol) {
            array_push($rolesJSON,$rol->jsonSerialize());
        }
        return $rolesJSON;
    }

}