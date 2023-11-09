<?php

class CompraEstadoTipo {

    private $idCompraEstadoTipo;
    private $cetDescripcion;
    private $cetDetalle;
    private $mensajeOperacion;

    public function __construct(){
        $this->idCompraEstadoTipo = "";
        $this->cetDescripcion = "";
        $this->cetDetalle = "";
        $this->mensajeOperacion = "";
    }

    public function cargar($idCompraEstadoTipo, $cetDescripcion, $cetDetalle){
        $this->setIdCompraEstadoTipo($idCompraEstadoTipo);
        $this->setCetDescripcion($cetDescripcion);
        $this->setCetDetalle($cetDetalle);
    }

    //getters

    public function getIdCompraEstadoTipo(){
        return $this->idCompraEstadoTipo;
    }

    public function getCetDescripcion(){
        return $this->cetDescripcion;
    }

    public function getCetDetalle(){
        return $this->cetDetalle;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    //setters

    public function setIdCompraEstadoTipo($idCompraEstadoTipo){
        $this->idCompraEstadoTipo = $idCompraEstadoTipo;
    }

    public function setCetDescripcion($cetDescripcion){
        $this->cetDescripcion = $cetDescripcion;
    }

    public function setCetDetalle($cetDetalle){
        $this->cetDetalle = $cetDetalle;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }


    public function buscar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo WHERE idCompraEstadoTipo = ".$this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->cargar($row['idCompraEstadoTipo'], $row['cetDescripcion'], $row['cetDetalle']);
                    
                }
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraestadotipo (idCompraEstadoTipo, cetDescripcion, cetDetalle)
        VALUES ('" 
        . $this->getIdCompraEstadoTipo() . "', '" 
        . $this->getCetDescripcion() . "', '" 
        . $this->getCetDetalle() . "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdCompraEstadoTipo($elid);
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("CompraEstadoTipo->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->insertar: ".$base->getError());
        }
        return $respuesta;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE compraestadotipo SET cetDescripcion='".$this->getCetDescripcion()."', cetDetalle='".$this->getCetDetalle().
        "'  WHERE idCompraEstadoTipo=".$this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraEstadoTipo->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="DELETE FROM compraestadotipo WHERE idCompraEstadoTipo=".$this->getIdCompraEstadoTipo();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("CompraEstadoTipo->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new CompraEstadoTipo();
                    $obj->cargar($row['idCompraEstadoTipo'], $row['cetDescripcion'], $row['cetDetalle']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("CompraEstadoTipo->listar: ".$base->getError());
        }
        return $arreglo;
    }

}