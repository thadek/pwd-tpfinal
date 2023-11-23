<?php

class abmCompra {

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
           
        if( array_key_exists('idcompra',$param)){
            $obj = new Compra();
            $obj->cargar($param['idcompra'],$param['cofecha'],$param['usuario']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de 
     * las variables instancias del objeto que son claves
     * @param array $param
     * @return Tabla
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idcompra'])) {
            $obj = new Compra();
            $obj->cargar($param['idcompra'], null, null);
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
        if (isset($param['idcompra']))
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
        $param['idcompra'] = null;
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
            if  (isset($param['idcompra']))
                $where.=" and idcompra ='".$param['idcompra']."'"; 
            if  (isset($param['cofecha']))
                    $where.=" and cofecha ='".$param['cofecha']."'";
            if  (isset($param['idusuario']))
                    $where.=" and idusuario ='".$param['idusuario']."'";
        }
        $obj = new Compra();
        $arreglo =  $obj->listar($where);  
        return $arreglo;
    }








    /**
     * Devuelve un arreglo de compras que poseen ese estado enviado por parametro como estado actual.
     */
    public function obtenerComprasPorEstado($estado_code){
        $arr_compras = [];
        $bd = new BaseDatos();
        $sql = "SELECT * FROM compraestado ce, compra c WHERE ce.idcompra = c.idcompra AND ce.idcompraestadotipo = $estado_code AND ce.cefechafin IS NULL";

        $res = $bd->Ejecutar($sql);
        if ($res > 0) {
            while ($row = $bd->Registro()) {  
                $obj = new Compra();
                $usr = new Usuario();
                $usr->setIdUsuario($row['idusuario']);
                $usr->buscar();
                $items = CompraItem::listar("idcompra = ".$row['idcompra']);
                $estados = CompraEstado::listar("idcompra = ".$row['idcompra']);
                $obj->cargar($row['idcompra'], $row['cofecha'], $usr, $items, $estados);
                array_push($arr_compras, $obj);
            }
        }

       return $arr_compras;
       
    }


    public function obtenerComprasPorEstadoSerializadas($estado_code){
        $arr_compras = [];
        $bd = new BaseDatos();
        $sql = "SELECT * FROM compraestado ce, compra c WHERE ce.idcompra = c.idcompra AND ce.idcompraestadotipo = $estado_code AND ce.cefechafin IS NULL";

        $res = $bd->Ejecutar($sql);
        $compra = [];
        if ($res > 0) {
            while ($row = $bd->Registro()) {  
                
                $usr = new Usuario();
                $usr->setIdUsuario($row['idusuario']);
                $usr->buscar();
                $compra['idcompra'] = $row['idcompra'];
                $compra['usuario'] = $usr->getUsNombre();
                $compra['items'] = $this->obtenerCantidadItems($row['idcompra']);
                $estados = CompraEstado::listar("idcompra = ".$row['idcompra']." AND cefechafin IS NULL");
                $compra['estado'] = array('id'=>$estados[0]->getCompraEstadoTipo()->getIdCompraEstadoTipo(),'descripcion'=>$estados[0]->getCompraEstadoTipo()->getCetDescripcion());
               // $obj->cargar($row['idcompra'], $row['cofecha'], $usr, $items, $estados);
                array_push($arr_compras, $compra);
            }
        }

       return $arr_compras;
       
    }


    public function obtenerCantidadItems($idCompra){
        $bd = new BaseDatos();
        $sql = "SELECT SUM(ci.cicantidad) as cantidad FROM compraitem ci WHERE ci.idcompra = $idCompra";
        $res = $bd->Ejecutar($sql);
        $cantidad = 0;
        if ($res > 0) {   
            $cantidad = intval($bd->Registro()['cantidad']);
        }
        return $cantidad;
    }




    /**
     * Funcion que se usa en el area de administracion para listar las compras por estado
     * Devuelve un arreglo de compras agrupadas por estado, sin incluir las compras en estado carrito.
     * @return array
     */
    public function obtenerComprasPorTodosLosEstados(){
        $arr_compras = [];
        $arr_porconfirmar = $this->obtenerComprasPorEstadoSerializadas(COMPRA_PORCONFIRMAR);
        $arr_confirmadas = $this->obtenerComprasPorEstadoSerializadas(COMPRA_CONFIRMADA);
        $arr_enviadas = $this->obtenerComprasPorEstadoSerializadas(COMPRA_ENVIADA);
        $arr_canceladas = $this->obtenerComprasPorEstadoSerializadas(COMPRA_CANCELADA);

        $arr_compras = array("porconfirmar"=>$arr_porconfirmar, "confirmadas"=>$arr_confirmadas, "enviadas"=>$arr_enviadas, "canceladas"=>$arr_canceladas);
        return $arr_compras;
    }




    /**
     * Listar todas las compras en JSON
     */
    public function listarCompras(){
        $compra = $this->buscar(null);
        $compraJSON = array();
        foreach ($compra as $compra) {
            array_push($compraJSON,$compra->jsonSerialize());
        }
        handleResponse($compraJSON);
    }


    /**
     * Devuelve un string del ultimo estado de la compra
     */
    public function obtenerUltimoEstadoCompra($compra){
        $arr_estados = $compra->getEstados();
        $ultimo_estado = end($arr_estados);
        if($ultimo_estado == false){
            $ultimo_estado = new CompraEstado();
            $ultimo_estado->setCompraEstadoTipo(new CompraEstadoTipo());
            $ultimo_estado->getCompraEstadoTipo()->setIdCompraEstadoTipo(COMPRA_EN_CARRITO);
        }
        return $ultimo_estado;
    }



    public function obtenerTotalCompra($compra){
        $total = 0;
        $items = $compra->getItems();
        foreach($items as $item){
            $total += $item->getProducto()->getPrecio()*$item->getCiCantidad();
        }
        return $total;
    }

    public function obtenerCantItemsCompra($compra){
        $items = $compra->getItems();
        $cantItems  = 0;
        foreach($items as $item){
            $cantItems += $item->getCiCantidad();
        }
        return $cantItems;
    }

    public function obtenerComprasJSON($idusuario){
        $arr_compras = Compra::listar("idusuario = ".$idusuario->getIdUsuario() );
        $salida = [];
       
       foreach($arr_compras as $compra){
        $estado = $this->obtenerUltimoEstadoCompra($compra);
        if($estado->getCompraEstadoTipo()->getIdCompraEstadoTipo() != 0){
            $total = $this->obtenerTotalCompra($compra);
         
            $cantItems = $this->obtenerCantItemsCompra($compra);
            $comp = ["idcompra" => $compra->getIdCompra(), "cofecha" => $compra->getCoFecha(), "cantitems"=> $cantItems, "total" => $total, "estado"=>$estado->getCompraEstadoTipo()->getCetDescripcion(), "acciones"=>renderBotonesAccionesCompra($compra->getIdCompra())];
                array_push($salida, $comp);
        }
          
       }    
        return $salida;
    }


   


}


