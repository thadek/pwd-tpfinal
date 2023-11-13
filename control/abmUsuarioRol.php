<?php

class abmUsuarioRol {

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
     * @return Usuariorol
     */
    private function cargarObjeto($param)
    {
        $obj = null;
        if (isset($param['idrol']) && isset($param['idusuario'])) {

            $obj = new Usuariorol();
            $usuario = new Usuario();
            $usuario->setIdUsuario($param['idusuario']);
            $rol = new Rol();
            $rol->setIdRol($param['idrol']);
            $obj->cargar($usuario, $rol);
         
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de 
     * las variables instancias del objeto que son claves
     * @param array $param
     * @return Producto
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idusuariorol'])) {
            $obj = new Usuariorol();
            $obj->cargar($param['idusuariorol'], null, null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idusuariorol']))
            $resp = true;
        return $resp;
    }

    /**
     * Inserta un objeto
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $param['idusuariorol'] = null;
        $obj = $this->cargarObjeto($param);
        if ($obj != null and $obj->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null and $obj->eliminar()) {
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
            $obj= $this->cargarObjeto($param);
            if($obj!=null && $obj->modificar()){
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
            $where .= '';
            if  (isset($param['idusuario']))
                    $where.=" and idusuario ='".$param['idusuario']."'";
            if  (isset($param['idrol']))
                    $where.=" and idrol ='".$param['idrol']."'";
        }
        $obj = new Usuariorol();
        $arreglo =  $obj->listar($where);  
        return $arreglo;
    }

    /**
     * Setea el rol cliente por defecto al usuario que se registra.
     */
    public function setearRolDefault($idUsuario){
        $salida = false;
        $param['idusuario'] = $idUsuario;
        $abmRol = new abmRol();   
        $rolCliente = $abmRol->obtenerRolCliente();
        $param['idrol'] = $rolCliente->getIdRol();

        $obj = $this->cargarObjeto($param);
        if ($obj != null && $obj->getUsuario()->getIdUsuario() != null && $obj->getRol()->getIdRol() != null && $obj->insertar()) {
           $salida = true;
        }
        return $salida;
    }
    
}