<?php

class Menu {

    private $idMenu;
    private $meNombre;
    private $meDescripcion;
    private $idPadre; 
    private $meDeshabilitado;
    private $mensajeoperacion;

    public function __construct(){

        $this->idMenu = "";
        $this->meNombre = "";
        $this->meDescripcion = "";
        $this->idPadre = "";
        $this->meDeshabilitado = "";
        $this->mensajeoperacion = "";
        
    }

    public function cargar($idMenu, $meNombre, $meDescripcion, $idPadre, $meDeshabilitado){
        $this->setIdMenu($idMenu);
        $this->setMeNombre($meNombre);
        $this->setMeDescripcion($meDescripcion);
        $this->setIdPadre($idPadre);
        $this->setMeDeshabilitado($meDeshabilitado);
    }

    //setters

    public function setIdMenu($idMenu){
        $this->idMenu = $idMenu;
    }

    public function setMeNombre($meNombre){
        $this->meNombre = $meNombre;
    }

    public function setMeDescripcion($meDescripcion){
        $this->meDescripcion = $meDescripcion;
    }

    public function setIdPadre($idPadre){
        $this->idPadre = $idPadre;
    }

    public function setMeDeshabilitado($meDeshabilitado){
        $this->meDeshabilitado = $meDeshabilitado;
    }

    public function setMensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    //getters

    public function getIdMenu(){
        return $this->idMenu;
    }

    public function getMeNombre(){
        return $this->meNombre;
    }

    public function getMeDescripcion(){
        return $this->meDescripcion;
    }

    public function getIdPadre(){
        return $this->idPadre;
    }

    public function getMeDeshabilitado(){
        return $this->meDeshabilitado;
    }
    
    public function getMensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function buscar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu WHERE idMenu = ".$this->getIdMenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->cargar($row['idMenu'], $row['meNombre'], $row['meDescripcion'], $row['idPadre'], $row['meDeshabilitado']);
                    
                }
            }
        } else {
            $this->setMensajeOperacion("Menu->listar: ".$base->getError());
        }
        return $resp;
    
        
    }

    public function insertar(){
		$base = new BaseDatos();
		$resp = false;
		$sql = "INSERT INTO menu (idMenu, meNombre, meDescripcion, idPadre, meDeshabilitado)
				VALUES ('".$this->getIdMenu()."','".$this->getMeNombre()."','".$this->getMeDescripcion()."','".$this->getIdPadre()."','".$this->getMeDeshabilitado()."')";
        
        if ($base->Iniciar()) {
    		$idUser = $base->Ejecutar($sql);
            if($idUser>-1){
                $this->setIdMenu($idUser);
			    $resp = true;
            }
		
        } else {
            $this->setMensajeOperacion("Menu->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE menu SET meNombre='".$this->getMeNombre()."', meDescripcion='".$this->getMeDescripcion()."', 
        idPadre='".$this->getIdPadre()."', meDeshabilitado='".$this->getMeDeshabilitado().
        "'  WHERE idMenu=".$this->getIdMenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->modificar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="DELETE FROM menu WHERE idMenu=".$this->getIdMenu();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("Menu->eliminar: ".$base->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Menu();
                    $obj->cargar($row['idMenu'], $row['meNombre'], $row['meDescripcion'], $row['idPadre'], $row['meDeshabilitado']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            $this->setMensajeOperacion("Menu->listar: ".$base->getError());
        }
 
        return $arreglo;
    }
    
}