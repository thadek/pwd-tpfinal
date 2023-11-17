<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$producto = $datos["idProducto"];


$objSession = new Session();
$usuario = $objSession->getUsuario();
$idusuario = $usuario->getIdUsuario();


$abmCompra = new AbmCompra();
$abmCompraItem = new AbmCompraItem();
$abmCompraEstado = new AbmCompraEstado();

//0000-00-00 00:00:00
//$fechaactual = date("Y-d-m", strtotime("now"));
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fechaactual = date("Y-m-d H:i:s");

$param = array(
    'accion' => 'nuevo', 
    'cofecha' => $fechaactual,  // Puedes ajustar esto según tus necesidades
    'idusuario' => $usuario,  // Aquí asumo que 'usuario' es el objeto Usuario que necesitas para la relación
    'items' => []  // Este es un array vacío, puedes ajustarlo si tienes información específica de los ítems de la compra
);

$abmCompra->abm($param);

$arreglo = [];
$arreglo["idusuario"] = $idusuario; 

$compra = $abmCompra->buscar($arreglo);


// Obtén el último elemento del array
$ultimaCompra = end($compra);

// Obtén el idcompra de la última compra
$ultimoIdCompra = $ultimaCompra->getIdCompra();

//objCompra.
$objCompra = new Compra();
$objCompra->setIdCompra($ultimoIdCompra);
$objCompra->setCoFecha($fechaactual);
$objCompra->setUsuario($usuario);


//parametros para el abmCompraestado
$param2 = array(
    'accion' => 'nuevo', 
    'idcompraestadotipo' => 0,  // Puedes ajustar esto según tus necesidades
    'compra' => $objCompra,  // Puedes ajustar esto según tus necesidades
    'idestado' => $objEstadoTipo,  // Aquí asumo que 'usuario' es el objeto Usuario que necesitas para la relación
    'cefechaini' => $fechaactual,  // Este es un array vacío, puedes ajustarlo si tienes información específica de los ítems de la compra
    'cefechafin' => null,
);

$abmCompraEstado->abm($param2);


?>
