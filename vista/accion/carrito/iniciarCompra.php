<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$objAbmtablacarrito = new ABMTablaCarrito();

$objAbmtablacarrito->iniciarCompra();


/*
$session = new Session();
$usuario = $session->getUsuario();
$idusuario = $usuario->getIdUsuario();


//vamos a cambiar el estado de las compras del usuario a 1, que significa que estan confirmadas.
$abmCompra = new AbmCompra();
$abmCompraEstado = new AbmCompraEstado();

$arreglo = [];
$arreglo["idusuario"] = $idusuario;

$compras = $abmCompra->buscar($arreglo);

//ahora se recuperan todos los idcompra de las compras.
$idcompras = [];
foreach($compras as $compra){
    array_push($idcompras, $compra->getIdCompra());
}

//ahora se verifican los estados de los idcompra, y se guaran en un array todos los idcompra que tengan idcompraestadotipo = 0.
$idcomprasEnCarrito = [];
foreach($idcompras as $idcompra){
    $arreglo2 = [];
    $arreglo2["idcompra"] = $idcompra;
    $compraestados = $abmCompraEstado->buscar($arreglo2);
    foreach($compraestados as $compraestado){
        if($compraestado->getCompraEstadoTipo()->getIdCompraEstadoTipo() == 0){
            array_push($idcomprasEnCarrito, $compraestado->getCompra()->getIdCompra());
        }
    }
}

//print_r($idcomprasEnCarrito);


//se crea un obj estadotipo para pasarlo por param a la modificacion de la compra.
$objEstadoTipo = new CompraEstadoTipo();
$objEstadoTipo->cargar(1, "Iniciada", "Compra iniciada");

//ahora se cambia el estado de las compras del usuario a 1, que significa que estan confirmadas.
foreach($idcomprasEnCarrito as $idcompra){
    $arreglo3 = [];
    $arreglo3["idcompra"] = $idcompra;
    $compraestados = $abmCompraEstado->buscar($arreglo3);
    foreach($compraestados as $compraestado){
        $compraestado->setCompraEstadoTipo($objEstadoTipo);
        $compraestado->modificar();
    }
}

*/


