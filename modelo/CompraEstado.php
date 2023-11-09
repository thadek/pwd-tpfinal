<?php

class CompraEstado {

    private $idCompraEstado;
    private $idCompra;
    private $idCompraEstadoTipo;
    private $ceFechaIni;
    private $ceFechaFin;
    private $mensajeoperacion;

    public function __construct(){

        $this->idCompraEstado = "";
        $this->idCompra = "";
        $this->idCompraEstadoTipo = "";
        $this->ceFechaIni = "";
        $this->ceFechaFin = "";
        $this->mensajeoperacion = "";
        
    }

    public function cargar($idCompraEstado, $idCompra, $idCompraEstadoTipo, $ceFechaIni, $ceFechaFin){
        $this->setIdCompraEstado($idCompraEstado);
        $this->setIdCompra($idCompra);
        $this->setIdCompraEstadoTipo($idCompraEstadoTipo);
        $this->setCeFechaIni($ceFechaIni);
        $this->setCeFechaFin($ceFechaFin);
    }

    //setters

    public function setIdCompraEstado($idCompraEstado){
        $this->idCompraEstado = $idCompraEstado;
    }

    public function setIdCompra($idCompra){
        $this->idCompra = $idCompra;
    }

    public function setIdCompraEstadoTipo($idCompraEstadoTipo){
        $this->idCompraEstadoTipo = $idCompraEstadoTipo;
    }

    public function setCeFechaIni($ceFechaIni){
        $this->ceFechaIni = $ceFechaIni;
    }

    public function setCeFechaFin($ceFechaFin){
        $this->ceFechaFin = $ceFechaFin;
    }

    public function setMensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //getters

    public function getIdCompraEstado(){
        return $this->idCompraEstado;
    }

    public function getIdCompra(){
        return $this->idCompra;
    }

    public function getIdCompraEstadoTipo(){
        return $this->idCompraEstadoTipo;
    }

    public function getCeFechaIni(){
        return $this->ceFechaIni;
    }

    public function getCeFechaFin(){
        return $this->ceFechaFin;
    }
    
    public function getMensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function buscar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado WHERE idcompraestado = ".$this->getIdCompraEstado();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->cargar($row['idcompraestado'], $row['idcompra'], $row['idcompraestadotipo'], $row['cefechaini'], $row['cefechafin']);
                    
                }
            }
        } else {
            $this->setMensajeOperacion("CompraEstado->listar: ".$base->getError());
        }
        return $resp;
    
        
    }

    public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		$sql = "INSERT INTO compraestado (idcompraestado, idcompra, idcompraestadotipo, cefechaini, cefechafin)
				VALUES ('".$this->getIdCompraEstado()."','".$this->getIdCompra()."','".$this->getIdCompraEstadoTipo()."','".$this->getCeFechaIni()."','".$this->getCeFechaFin()."')";
        
        if ($base->Iniciar()) {
    		$idUser = $base->Ejecutar($sql);
            if($idUser>-1){
                $this->setIdCompraEstado($idUser);
			    $resp = true;
            }
		
        } else {
            $this->setMensajeOperacion("CompraEstado->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE compraestado SET idcompra='".$this->getIdCompra()."', idcompraestadotipo='".$this->getIdCompraEstadoTipo()."', 
        cefechaini='".$this->getCeFechaIni()."', cefechafin='".$this->getCeFechaFin().
        "'  WHERE idcompraestado=".$this->getIdCompraEstado();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("CompraEstado->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstado->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="DELETE FROM compraestado WHERE idcompraestado=".$this->getIdCompraEstado();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("CompraEstado->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("CompraEstado->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new CompraEstado();
                    $obj->cargar($row['idcompraestado'], $row['idcompra'], $row['idcompraestadotipo'], $row['cefechaini'], $row['cefechafin']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            throw new Exception("Error al listar los compraEstado: " . $base->getError());
        }
 
        return $arreglo;
    }
    
}