<?php

require_once('../../../configuracion.php');
header('Content-Type: application/json');
$datos = darDatosSubmitted();
autorizar(['admin']);

$abmMenu = new AbmMenu();


if(isset($datos['idMenu'])){
    $menu = $abmMenu->buscar(['id' => $datos['idMenu']]);
    if(count($menu) > 0){
        $menu = $menu[0];
        echo json_encode($menu->jsonSerialize());
    }else{
        echo json_encode(null);
    }
    die();
}else{
    $menus = $abmMenu->buscar(null);

    $menusJSON = array();
    
    foreach ($menus as $menu) {
        array_push($menusJSON, $menu->jsonSerialize());
    }
    
    echo json_encode($menusJSON);
}



