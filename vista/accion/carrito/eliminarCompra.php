<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$compra = $datos["idCompraItem"];

$abmTablaCarrito = new ABMTablaCarrito();

$abmTablaCarrito->eliminarCompra($compra);

//ahora hay que eliminar la compra de la base de datos, de la tabla comprar item, de la tabla compra estado, y de la tabla compra.

/*
$abmCompraItem = new AbmCompraItem();
$arreglo = [];
$arreglo["idcompraitem"] = $compra;
$compraitems = $abmCompraItem->buscar($arreglo);
foreach($compraitems as $compraitem){
    $idcompra = $compraitem->getCompra()->getIdCompra();
}

//echo "idcompra: $idcompra";

//necesito el obj del producto para poder eliminar la fila de tabla compra item. tengo que buscar el idProducto del idcompraitem.
$abmCompraItem = new AbmCompraItem();
$arreglo = [];
$arreglo["idcompraitem"] = $compra;
$compraitems = $abmCompraItem->buscar($arreglo);
foreach($compraitems as $compraitem){
    $idproducto = $compraitem->getProducto()->getIdProducto();
}
echo "idproducto: $idproducto";


//Hay que eliminar la fila correspondiente al idcompraitem de la tabla compra item.
$abmCompraItem = new AbmCompraItem();
$arreglo = [];
$arreglo["idcompraitem"] = $compra;
$compraitems = $abmCompraItem->buscar($arreglo);
foreach($compraitems as $compraitem){
    $compraitem->eliminar();
}

//Hay que eliminar la fila correspondiente al idcomprade la tabla compra estado.
$abmCompraEstado = new AbmCompraEstado();
$arreglo = [];
$arreglo["idcompra"] = $idcompra;
$compraestados = $abmCompraEstado->buscar($arreglo);
foreach($compraestados as $compraestado){
    $compraestado->eliminar();
}

//Hay que eliminar la fila correspondiente al idcompra de la tabla compra.
$abmCompra = new AbmCompra();
$arreglo = [];
$arreglo["idcompra"] = $idcompra;
$compras = $abmCompra->buscar($arreglo);
foreach($compras as $compra){
    $compra->eliminar();
}

*/


