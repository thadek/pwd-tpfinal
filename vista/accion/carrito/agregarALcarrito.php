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
$fechaactual = date("Y-m-d");

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

//objEstadoTipo.
$objEstadoTipo = new CompraEstadoTipo();
$objEstadoTipo->cargar(0, "En carrito", "Producto sin iniciar la compra, en carrito");

//parametros para el abmCompraestado
$param2 = array(
    'accion' => 'nuevo', 
    'idcompraestadotipo' => 0,  // Puedes ajustar esto según tus necesidades
    'idcompra' => $objCompra,  // Puedes ajustar esto según tus necesidades
    'idestado' => $objEstadoTipo,  // Aquí asumo que 'usuario' es el objeto Usuario que necesitas para la relación
    'cefechaini' => $fechaactual,  // Este es un array vacío, puedes ajustarlo si tienes información específica de los ítems de la compra
    'cefechafin' => null,
);

$abmCompraEstado->abm($param2);


?>
