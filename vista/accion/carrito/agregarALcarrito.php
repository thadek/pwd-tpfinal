<?php

require_once('../../../configuracion.php');
$datos = darDatosSubmitted();

$producto = $datos["idProducto"];

$abmIniciarCompra = new ABMIniciarCompra();

$abmIniciarCompra->abm($producto);

/* $objSession = new Session();
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

    //parametros para el abmCompraestado.
    $param2 = array(
        'accion' => 'nuevo', 
        'idcompraestado' => 0,  // Puedes ajustar esto según tus necesidades
        'idcompra' => $objCompra,  // Puedes ajustar esto según tus necesidades
        'idcompraestadotipo' => $objEstadoTipo,  // Aquí asumo que 'usuario' es el objeto Usuario que necesitas para la relación
        'cefechaini' => $fechaactual,  // Este es un array vacío, puedes ajustarlo si tienes información específica de los ítems de la compra
        'cefechafin' => null,
    );

    //se sube a la base de datos compraestado.
    $abmCompraEstado->abm($param2);

    //traemos el producto de la base de datos.
    $objProducto = new Producto();
    $abmProducto = new AbmProducto();

    $param3 = array(
        'idproducto' => $producto
    );

    $productoArreglo = $abmProducto->buscar($param3);
    print_r($productoArreglo);

    //cargamos el obj producto.
    $objProducto->cargar($productoArreglo[0]->getIdProducto(), $productoArreglo[0]->getProNombre(), $productoArreglo[0]->getProDetalle(), $productoArreglo[0]->getPrecio(), $productoArreglo[0]->getProCantStock());

    //armamos los parametros para el abmCompraItem.
    $param4 = array(
        'accion' => 'nuevo', 
        'idcompraitem' => 0,  // Puedes ajustar esto según tus necesidades
        'idcompra' => $objCompra,  // Puedes ajustar esto según tus necesidades
        'idproducto' => $objProducto,  // Aquí asumo que 'usuario' es el objeto Usuario que necesitas para la relación
        'ciimporte' => $objProducto->getPrecio(),  // Este es un array vacío, puedes ajustarlo si tienes información específica de los ítems de la compra
        'cicantidad' => 1,
    );

    $abmCompraItem->abm($param4);
*/

?>
