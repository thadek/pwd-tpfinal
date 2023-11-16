<?php

include_once("../../../configuracion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos['idmenu'] = $_POST['idMenu'];
    $datos['menombre'] = $_POST['meNombre'];
    $datos['medescripcion'] = $_POST['meDescripcion'];
    $datos['idpadre'] = $_POST['padre'];
    $datos['medeshabilitado'] = $_POST['meDeshabilitado'];
    $datos['link'] = $_POST['link'];

    if ($datos['idpadre'] == "-1"){
        $sql = "UPDATE `menu` SET `idpadre` = NULL WHERE `menu`.`idmenu` = ".$datos['idmenu'].";";
    }


    echo json_encode($datos);

    $abmMenu = new ABMMenu();
    $respuesta = $abmMenu->modificacion($datos);

    if ($respuesta) {
        echo json_encode(['success' => true, 'msg' => 'Operación exitosa']);
        exit;
    } else {
        echo json_encode(['success' => false, 'msg' => 'Error al cambiar el menú']);
        exit;
    }
}
?>