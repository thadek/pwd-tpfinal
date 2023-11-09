<?php

class MenuRol {

    private $idMenu;
    private $idRol;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idMenu = new Menu();
        $this->idRol = new Rol();
        $this->mensajeOperacion = "";
    }
    
    public function cargar($idMenu, $idRol){
        $this->setIdMenu($idMenu);
        $this->setIdRol($idRol);
    }

    public function getIdMenu(){
        return $this->idMenu;
    }

    public function getIdRol(){
        return $this->idRol;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setIdMenu($idMenu){
        $this->idMenu = $idMenu;
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
        $sql = "SELECT * FROM menurol WHERE idMenu = ".$this->getIdMenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->cargar($row['idMenu'], $row['idRol']);
                }
            }
        } else {
            $this->setMensajeOperacion("MenuRol->listar: ".$base->getError());
        }
        return $resp;
    
        
    }

    public function insertar(){
        $respuesta = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO menurol (idMenu, idRol)
        VALUES ('" 
        . $this->getIdMenu() . "', '" 
        . $this->getIdRol() . 
         "')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdMenu($elid);
                $respuesta = true;
            } else {
                $this->setMensajeOperacion("MenuRol->insertar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->insertar: ".$base->getError());
        }
        return $respuesta;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE menurol SET idMenu='".$this->getIdMenu()."', idRol='".$this->getIdRol();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("MenuRol->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="DELETE FROM menurol WHERE idMenu=".$this->getIdMenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("MenuRol->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("MenuRol->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menurol ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new MenuRol();
                    $obj->cargar($row['idMenu'], $row['idRol']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            $this->setmensajeoperacion("MenuRol->listar: ".$base->getError());
        }
 
        return $arreglo;
    }
}