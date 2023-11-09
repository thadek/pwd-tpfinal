<?php

class CompraItem {

    private $idCompraItem;
    private $idProducto;
    private $idCompra;
    private $ciCantidad;
    private $mensajeOperacion;

    public function __construct(){
        $this->idCompraItem = "";
        $this->idProducto = "";
        $this->idCompra = "";
        $this->ciCantidad = "";
        $this->mensajeOperacion = "";
    }

    public function cargar($idCompraItem, $idProducto, $idCompra, $ciCantidad){
        $this->setIdCompraItem($idCompraItem);
        $this->setIdProducto($idProducto);
        $this->setIdCompra($idCompra);
        $this->setCiCantidad($ciCantidad);
    }

    //getters

    public function getIdCompraItem(){
        return $this->idCompraItem;
    }

    public function getIdProducto(){
        return $this->idProducto;
    }

    public function getIdCompra(){
        return $this->idCompra;
    }

    public function getCiCantidad(){
        return $this->ciCantidad;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //setters

    public function setIdCompraItem($idCompraItem){
        $this->idCompraItem = $idCompraItem;
    }

    public function setIdProducto($idProducto){
        $this->idProducto = $idProducto;
    }

    public function setIdCompra($idCompra){
        $this->idCompra = $idCompra;
    }

    public function setCiCantidad($ciCantidad){
        $this->ciCantidad = $ciCantidad;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem WHERE idcompraitem = ".$this->getIdCompraItem();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->cargar($row['idcompraitem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
                    
                }
            }
        } else {
            $this->setMensajeOperacion("CompraItem->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraitem (idcompraitem, idproducto, idcompra, cicantidad)
        VALUES ('" 
        . $this->getIdCompraItem() . "', '" 
        . $this->getIdProducto() . "', '" 
        . $this->getIdCompra() . "', '" 
        . $this->getCiCantidad() . "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdCompraItem($elid);
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("CompraItem->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->insertar: ".$base->getError());
        }
        return $respuesta;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE compraitem SET idproducto='".$this->getIdProducto()."', idcompra'".$this->getIdCompra()."', cicantidad'".$this->getCiCantidad().
        "'  WHERE idcompraitem=".$this->getIdCompraItem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraItem->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="DELETE FROM compraitem WHERE idcompraitem=".$this->getIdCompraItem();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("CompraItem->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraItem->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new CompraItem();
                    $obj->cargar($row['idcompraitem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            throw new Exception("Error al listar las compraItem: " . $base->getError());
        }
        return $arreglo;
    }

}