<?php

class ABMTablaCarrito {

    public function eliminarCompra($dato){

        $compra = $dato;

        //primero sacamos el idcompra de la tabla compra item.
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

    }

    public function vaciarCarrito(){

        //hay que sacar el id del usuario logueado.
        $session = new Session();
        $usuario = $session->getUsuario();
        $idusuario = $usuario->getIdUsuario();

        $abmUsuario = new AbmUsuario();

        $arreglo = [];
        $arreglo["idusuario"] = $idusuario;

        //El usuario solo debe tener 1 carrito, por lo que el arreglo solo va a tener 1 elemento.
        $carrito = $abmUsuario->cargarCarritoUser();
    
        $estado = $carrito[0]->getEstados()[0];    


        $estado->setCeFechaFin(date("Y-m-d H:i:s"));
        $estado->modificar();
    
    }

    public function iniciarCompra(){

        $session = new Session();
        $usuario = $session->getUsuario();
        $idusuario = $usuario->getIdUsuario();

        $abmCompra = new AbmCompra();
        $abmCompraEstado = new AbmCompraEstado();

        $arreglo = [];
        $arreglo["idusuario"] = $idusuario;

        $compras = $abmCompra->buscar($arreglo);

        $ultimaCompra = end($compras);

        $abmCompraEstado->cambiarEstadoDeCompra($ultimaCompra->getIdCompra(),1);

       
    }
}