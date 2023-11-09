<?php

class Menu {

    private $idMenu;
    private $meNombre;
    private $meDescripcion;
    private $idPadre;
    private $link;
    private $meDeshabilitado;
    private $mensajeoperacion;

    public function __construct(){

        $this->idMenu = "";
        $this->meNombre = "";
        $this->meDescripcion = "";
        $this->idPadre = "";
        $this->link = "";
        $this->meDeshabilitado = "";
        $this->mensajeoperacion = "";
        
    }

    public function cargar($idMenu, $meNombre, $meDescripcion, $idPadre, $link, $meDeshabilitado){
        $this->setIdMenu($idMenu);
        $this->setMeNombre($meNombre);
        $this->setMeDescripcion($meDescripcion);
        $this->setIdPadre($idPadre);
        $this->setLink($link);
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

    public function setLink($link){
        $this->link = $link;
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

    public function getLink(){
        return $this->link;
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
        $sql = "SELECT * FROM menu WHERE idmenu = ".$this->getIdMenu();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->cargar($row['idmenu'], $row['menombre'], $row['medescripcion'], $row['idpadre'], $row['link'], $row['medeshabilitado']);
                    
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
		$sql = "INSERT INTO menu (idmenu, meNombre, medescripcion, idpadre, link, medeshabilitado)
				VALUES ('".$this->getIdMenu()."','".$this->getMeNombre()."','".$this->getMeDescripcion()."','".$this->getIdPadre()."','".$this->getLink()."','".$this->getMeDeshabilitado()."')";
        
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
        $sql="UPDATE menu SET menombre='".$this->getMeNombre()."', medescripcion='".$this->getMeDescripcion()."', 
        idpadre='".$this->getIdPadre()."', link='".$this->getLink()."', medeshabilitado='".$this->getMeDeshabilitado().
        "'  WHERE idmenu=".$this->getIdMenu();
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
        $sql="DELETE FROM menu WHERE idmenu=".$this->getIdMenu();
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
                    $obj->cargar($row['idmenu'], $row['menombre'], $row['medescripcion'], $row['idpadre'], $row['link'], $row['medeshabilitado']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            throw new Exception("Error al listar los menus: " . $base->getError());
        }
 
        return $arreglo;
    }
    
}