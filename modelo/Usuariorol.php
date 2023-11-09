<?php

class UsuarioRol {

    private $idUsuario;
    private $idRol;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idUsuario = new Usuario();
        $this->idRol = new Rol();
        $this->mensajeOperacion = "";
    }
    
    public function cargar($idUsuario, $idRol){
        $this->setIdUsuario($idUsuario);
        $this->setIdRol($idRol);
    }

    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function getIdRol(){
        return $this->idRol;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    public function setIdRol($idRol){
        $this->idRol = $idRol;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol WHERE idUsuario = ".$this->getIdUsuario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->cargar($row['idUsuario'], $row['idRol']);
                }
            }
        } else {
            $this->setMensajeOperacion("usuariorol->listar: ".$base->getError());
        }
        return $resp;
    
        
    }

    public function insertar(){
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuariorol (idUsuario, idRol)
        VALUES ('" 
        . $this->getIdUsuario() . "', '" 
        . $this->getIdRol() . 
         "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdUsuario($elid);
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("usuariorol->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->insertar: ".$base->getError());
        }
        return $respuesta;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE usuariorol SET idUsuario='".$this->getIdUsuario()."', idRol='".$this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuariorol->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="DELETE FROM usuariorol WHERE idUsuario=".$this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("usuariorol->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuariorol->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new UsuarioRol();
                    $obj->cargar($row['idUsuario'], $row['idRol']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            throw new Exception("Error al listar las compras: " . $base->getError());
        }
 
        return $arreglo;
    }
}