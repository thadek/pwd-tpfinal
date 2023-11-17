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

        $abmCompra = new AbmCompra();
        $abmCompraItem = new AbmCompraItem();
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

        //ahora se recuperan todos los idcompraitem de las compras.
        $idcompraitems = [];
        foreach($idcomprasEnCarrito as $idcompra){
            $arreglo3 = [];
            $arreglo3["idcompra"] = $idcompra;
            $compraitems = $abmCompraItem->buscar($arreglo3);
            foreach($compraitems as $compraitem){
                array_push($idcompraitems, $compraitem->getIdCompraItem());
            }
        }
        //print_r($idcompraitems);

        //Se recupera la cantidad de cada $idcomprasitem.
        $cantidad = [];
        foreach($idcompraitems as $idcompraitem){
            $arreglo4 = [];
            $arreglo4["idcompraitem"] = $idcompraitem;
            $compraitems = $abmCompraItem->buscar($arreglo4);
            foreach($compraitems as $compraitem){
                array_push($cantidad, $compraitem->getCiCantidad());
            }
        }
        //print_r($cantidad);

        //ahora se recuperan todos los productos de los idcompraitem.
        $productos = [];
        foreach($idcompraitems as $idcompraitem){
            $arreglo4 = [];
            $arreglo4["idcompraitem"] = $idcompraitem;
            $compraitems = $abmCompraItem->buscar($arreglo4);
            foreach($compraitems as $compraitem){
                array_push($productos, $compraitem->getProducto());
            }
        }

        //ahora hay que eliminar todas las filas que coincidan con la compra del usuario.
        //empezamos con la tabla compra item.
        foreach($idcompraitems as $idcompraitem){
            $arreglo4 = [];
            $arreglo4["idcompraitem"] = $idcompraitem;
            $compraitems = $abmCompraItem->buscar($arreglo4);
            foreach($compraitems as $compraitem){
                $compraitem->eliminar();
            }
        }

        //seguimos con la tabla comprae estado.
        foreach($idcomprasEnCarrito as $idcompra){
            $arreglo2 = [];
            $arreglo2["idcompra"] = $idcompra;
            $compraestados = $abmCompraEstado->buscar($arreglo2);
            foreach($compraestados as $compraestado){
                $compraestado->eliminar();
            }
        }

        //terminamos con la tabla compra.
        foreach($idcomprasEnCarrito as $idcompra){
            $arreglo = [];
            $arreglo["idcompra"] = $idcompra;
            $compras = $abmCompra->buscar($arreglo);
            foreach($compras as $compra){
                $compra->eliminar();
            }
        }

    }

    public function iniciarCompra(){

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
    }
}