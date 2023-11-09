<?php

class Compra {

private $idcompra;
private $cofecha;
private Usuario $usuario;
private $mensajeOperacion;


public function __construct(){
   $this->idcompra = "";
   $this->cofecha = "";
   $this->usuario = new Usuario();
}

public function cargar($idcompra, $cofecha, $usuario){
   $this->setIdCompra($idcompra);
   $this->setCoFecha($cofecha);
   $this->setUsuario($usuario);  
}

public function getIdCompra(){
   return $this->idcompra;
}

public function setIdCompra($idcompra){
   $this->idcompra = $idcompra;
}

public function getCoFecha(){
   return $this->cofecha;
}

public function setCoFecha($cofecha){
   $this->cofecha = $cofecha;
}

public function getUsuario(){
   return $this->usuario;
}

public function setUsuario($usuario){
   $this->usuario = $usuario;
}

public function getMensajeOperacion(){
   return $this->mensajeOperacion;
}

public function setMensajeOperacion($mensajeOperacion){
   $this->mensajeOperacion = $mensajeOperacion;
}




public function buscar(){
    $resp = false;
    $base = new BaseDatos();
    $sql = "SELECT * FROM compra WHERE idcompra = " . $this->getIdCompra();
    if ($base->Iniciar()) {
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                $row = $base->Registro();
                $this->cargar($row['idcompra'], $row['cofecha'], $row['idusuario']);
                $resp = true;
            }
        }
    } else {
        $this->setMensajeOperacion("Compra->buscar: " . $base->getError());
    }
    return $resp;
}



public function insertar(){
    $resp = false;
    $base = new BaseDatos();
    $sql = "INSERT INTO compra(cofecha, idusuario) 
            VALUES (" . $this->getCoFecha() . ", '" . $this->getUsuario()->getId() . "')";
    if ($base->Iniciar()) {

        if($idCompra= $base->Ejecutar($sql)){
            $this->setIdCompra($idCompra);
            $resp = true;
        } else {
            $this->setmensajeoperacion("compra->insertar:".$base->getError());	
        }
    } else {
        $this->setMensajeOperacion("Compra->insertar: " . $base->getError());
    }
    return $resp;
}

public function modificar(){
    $resp = false;
    $base = new BaseDatos();
    $sql = "UPDATE compra SET cofecha = '" . $this->getCoFecha() . "', idusuario=".$this->getUsuario()->getId()." WHERE idcompra = " . $this->getIdCompra();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeOperacion("Compra->modificar: " . $base->getError());
        }
    } else {
        $this->setMensajeOperacion("Compra->modificar: " . $base->getError());
    }
    return $resp;
}

public function eliminar(){
    $resp = false;
    $base = new BaseDatos();
    $sql = "DELETE FROM compra WHERE idcompra = " . $this->getIdCompra();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeOperacion("Compra->eliminar: " . $base->getError());
        }
    } else {
        $this->setMensajeOperacion("Compra->eliminar: " . $base->getError());
    }
    return $resp;
}

public static function listar($parametro = ""){
    $arreglo = array();
    $base = new BaseDatos();
    $sql = "SELECT * FROM compra";
    if ($parametro != "") {
        $sql .= ' WHERE ' . $parametro;
    }
    $res = $base->Ejecutar($sql);
    if ($res > -1) {
        if ($res > 0) {
            while ($row = $base->Registro()) {  
                $obj = new Compra();
                $user = new Usuario();
                $user->setId($row['idusuario']);
                $user->buscar();
                $obj->cargar($row['idcompra'], $row['cofecha'], $user);
                array_push($arreglo, $obj);
            }
        }
    } else {
       throw new Exception("Error al listar las compras: " . $base->getError());
    }
    return $arreglo;
}
}