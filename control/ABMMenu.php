<?php
class ABMMenu{
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
           
        if( array_key_exists('idmenu',$param) and array_key_exists('menombre',$param) and array_key_exists('medescripcion',$param) and array_key_exists('idpadre',$param) and array_key_exists('link',$param) and array_key_exists('medeshabilitado',$param)){
            $obj = new Menu();
            $menuPadre = new Menu();
            $menuPadre->setIdMenu($param['idpadre']);
            $obj->cargar($param['idmenu'], $param['menombre'], $param['medescripcion'], $menuPadre, $param['link'], $param['medeshabilitado']);
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
        
        if( isset($param['idmenu']) ){
            $obj = new Menu();
            $obj->setIdMenu($param['idmenu']);
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
        if (isset($param['idmenu'])){
            $resp = true;
        }
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idmenu'] =null;
        $elObjtTabla = $this->cargarObjeto($param);
//        verEstructura($elObjtTabla);
        if ($elObjtTabla!=null and $elObjtTabla->insertar()){
            $resp = true;
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
        //echo "Estoy en modificacion";
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtTabla = $this->cargarObjeto($param);
            if($elObjtTabla!=null and $elObjtTabla->modificar()){
                if ($elObjtTabla->getPadre() != NULL && $elObjtTabla->getPadre()->getIdMenu() == -1){
                    $elObjtTabla->setearPadreNulo();
                }
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idmenu']))
                $where.=" and idmenu =".$param['idmenu'];
            if  (isset($param['menombre']))
                $where.=" and menombre =".$param['menombre'];
            if  (isset($param['medescripcion']))
                $where.=" and medescripcion =".$param['medescripcion'];
            if  (isset($param['idpadre']))
                 $where.=" and idpadre ='".$param['nombre']."'";
            if  (isset($param['medeshabilitado']))
                $where.=" and medeshabilitado IS NULL";
        }

        $obj = new Menu();
        $arreglo = $obj->listar($where);

        return $arreglo;  
    }
    

    /**
     * Dado un id de rol, devuelve un arreglo de objetos Menu asociados a ese rol
     * @param int $idRol
     * @return array<Menu>
     */
    public function obtenerMenuPorRol($idRol){

        $obj = new MenuRol();
        $arr_menurol = $obj->listar("idrol = ".$idRol);
        $arr_menus = array();
        foreach ($arr_menurol as $menurol) {
            $param['idmenu'] = $menurol->getMenu()->getIdMenu();
            $param['medeshabilitado'] = 'NULL';
            $menu = $this->buscar($param);
            if($menu!=null){
                $menu = $menu[0];
                array_push($arr_menus,$menu);
            }
          
           
        }
        return $arr_menus;
    }



    /**
     * Dado un id de rol y id de menu, inserta la tupla en la base de datos para 
     * dar acceso a ese menu al rol correspondiente
     */
    public function asignarMenuRol($idRol,$idMenu){
        $obj = new MenuRol();
        $obj->cargar(null,$idRol,$idMenu);
        $obj->insertar();
        $response = [
            'status' => 200,
            'msg' => 'Menu asignado correctamente'
        ];
        return $response;      
    }

    /**
     * Dado un id de rol y id de menu, elimina la tupla en la base de datos para 
     * quitar el acceso a ese menu al rol correspondiente
     */
    public function quitarMenuRol($idRol,$idMenu){
        $obj = new MenuRol();
        $obj->cargar(null,$idRol,$idMenu);
        $obj->eliminar();
        $response = [
            'status' => 200,
            'msg' => 'Menu quitado correctamente'
        ];
        return $response;
    }
  


    public function obtenerMenuRolJSON(){
        $menusRol = MenuRol::listar();
        $menuJSON = array();
        foreach ($menusRol as $menuRol) {
            $menuRol->getMenu()->buscar();
            array_push($menuJSON,$menuRol->jsonSerialize());
        }
        return $menuJSON;
    }

}
?>