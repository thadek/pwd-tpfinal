<?php

class Producto {

    private $idProducto;
    private $proNombre;
    private $proDetalle;
    private $proCantStock;
    private $mensajeOperacion;

    public function __construct(){
        $this->idProducto = "";
        $this->proNombre = "";
        $this->proDetalle = "";
        $this->proCantStock = "";
        $this->mensajeOperacion = "";
    }

    public function cargar($idProducto, $proNombre, $proDetalle, $proCantStock){
        $this->setIdProducto($idProducto);
        $this->setProNombre($proNombre);
        $this->setProDetalle($proDetalle);
        $this->setProCantStock($proCantStock);
    }

    //getters

    public function getIdProducto(){
        return $this->idProducto;
    }

    public function getProNombre(){
        return $this->proNombre;
    }

    public function getProDetalle(){
        return $this->proDetalle;
    }

    public function getProCantStock(){
        return $this->proCantStock;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //setters

    public function setIdProducto($idProducto){
        $this->idProducto = $idProducto;
    }

    public function setProNombre($proNombre){
        $this->proNombre = $proNombre;
    }

    public function setProDetalle($proDetalle){
        $this->proDetalle = $proDetalle;
    }

    public function setProCantStock($proCantStock){
        $this->proCantStock = $proCantStock;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto WHERE idProducto = ".$this->getIdProducto();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->cargar($row['idProducto'], $row['proNombre'], $row['proDetalle'], $row['proCantStock']);
                    
                }
            }
        } else {
            $this->setMensajeOperacion("Producto->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO producto (idProducto, proNombre, proDetalle, proCantStock)
        VALUES ('" 
        . $this->getIdProducto() . "', '" 
        . $this->getProNombre() . "', '" 
        . $this->getProDetalle() . "', '" 
        . $this->getProCantStock() . "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdProducto($elid);
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("Producto->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->insertar: ".$base->getError());
        }
        return $respuesta;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE producto SET proNombre='".$this->getProNombre()."', proDetalle'".$this->getProDetalle()."', proCantStock'".$this->getProCantStock().
        "'  WHERE idProducto=".$this->getIdProducto();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Producto->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="DELETE FROM Producto WHERE idProducto=".$this->getIdProducto();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("Producto->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Producto->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new Producto();
                    $obj->cargar($row['idProducto'], $row['proNombre'], $row['proDetalle'], $row['proCantStock']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("Producto->listar: ".$base->getError());
        }
        return $arreglo;
    }

}