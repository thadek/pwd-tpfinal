<?php

class Usuario {

private $idUsuario;
private $usNombre;
private $usPass;
private $usMail;
private $usDeshabilitado;
private $mensajeOperacion;

public function __construct(){
    $this->idUsuario = "";
    $this->usNombre = "";
    $this->usPass = "";
    $this->usMail = "";
    $this->usDeshabilitado = "";
}


public function cargar($idUsuario, $usNombre, $usPass, $usMail, $usDeshabilitado){
    $this->setIdUsuario($idUsuario);
    $this->setUsNombre($usNombre);
    $this->setUsPass($usPass);
    $this->setUsMail($usMail);
    $this->setUsDeshabilitado($usDeshabilitado);

}

public function getId(){
    return $this->idUsuario;
}

public function setId($idUsuario){
    $this->idUsuario = $idUsuario;
}

public function getUsNombre(){
    return $this->usNombre;
}

public function setUsNombre($usNombre){
    $this->usNombre = $usNombre;
}

public function getUsPass(){
    return $this->usPass;
}

public function setUsPass($usPass){
    $this->usPass = $usPass;
}

public function getUsMail(){
    return $this->usMail;
}

public function setUsMail($usMail){
    $this->usMail = $usMail;
}

public function getUsDeshabilitado(){
    return $this->usDeshabilitado;
}   

public function setUsDeshabilitado($usDeshabilitado){
    $this->usDeshabilitado = $usDeshabilitado;
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
    $sql = "SELECT * FROM usuario WHERE idusuario = " . $this->getId();
    if ($base->Iniciar()) {
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                $row = $base->Registro();
                $this->setId($row['idusuario']);
                $this->setUsNombre($row['usnombre']);
                $this->setUsPass($row['uspass']);
                $this->setUsMail($row['usmail']);
                $this->setUsDeshabilitado($row['usdeshabilitado']);
            }
        }
    } else {
        $this->setMensajeOperacion("Usuario->buscar: " . $base->getError());
    }
    return $resp;
}


public static function listar($condicion = ""){
    $arregloUsuarios = array();
    $base = new BaseDatos();
    $sql = "SELECT * FROM usuario ";
    if ($condicion != "") {
        $sql .= 'WHERE ' . $condicion;
    }
    $res = $base->Ejecutar($sql);
    if ($res > -1) {
        if ($res > 0) {
            while ($row = $base->Registro()) {
                $obj = new Usuario();
                $obj->cargar($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                array_push($arregloUsuarios, $obj);
            }
        }
    } else {
        throw new Exception("Usuario->listar: " . $base->getError());
    }
    return $arregloUsuarios;

}


public function insertar(){
    $resp = false;
    $base = new BaseDatos();
    $sql = "INSERT INTO usuario(usnombre, uspass, usmail, usdeshabilitado)  VALUES('" . $this->getUsNombre() . "','" . $this->getUsPass() . "','" . $this->getUsMail() . "','" . $this->getUsDeshabilitado() . "')";
    if ($base->Iniciar()) {
        if ($id = $base->Ejecutar($sql)) {
            $this->setId($id);
            $resp = true;
        } else {
            $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
        }
    } else {
        $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
    }
    return $resp;
}


public function modificar(){
    $resp = false;
    $base = new BaseDatos();
    $sql = "UPDATE usuario SET usnombre = '" . $this->getUsNombre() . "', uspass = '" . $this->getUsPass() . "', usmail = '" . $this->getUsMail() . "', usdeshabilitado = '" . $this->getUsDeshabilitado() . "' WHERE idusuario = " . $this->getId();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeOperacion("Usuario->modificar: " . $base->getError());
        }
    } else {
        $this->setMensajeOperacion("Usuario->modificar: " . $base->getError());
    }
    return $resp;
}


public function eliminar(){
    $resp = false;
    $base = new BaseDatos();
    $sql = "DELETE FROM usuario WHERE idusuario = " . $this->getId();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeOperacion("Usuario->eliminar: " . $base->getError());
        }
    } else {
        $this->setMensajeOperacion("Usuario->eliminar: " . $base->getError());
    }
    return $resp;
}









}