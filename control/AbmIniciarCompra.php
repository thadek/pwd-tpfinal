<?php

class ABMIniciarCompra{

    public function abm($dato) {
        $objSession = new Session();
        $usuario = $objSession->getUsuario();
        $idusuario = $usuario->getIdUsuario();
        
        $producto = $dato; 
        
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
        $objEstadoTipo->setIdCompraEstadoTipo(0);
        
        //parametros para el abmCompraestado.
        $param2 = array(
            'accion' => 'nuevo', 
            'idcompraestado' => 0,  // Puedes ajustar esto según tus necesidades
            'compra' => $objCompra,  // Puedes ajustar esto según tus necesidades
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
        
      
    }

    public function traerCarrito(){
        //funcion que trae los datos de carrito de la base de datos.
        $objSession = new Session();
        $usuario = $objSession->getUsuario();
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
        //print_r($productos);


        //Ahora hay que mostrar los productos en el carrito, una variable que tenga html y muestre en una tabla los productos con su id compra item, nombre, precio, cantidad, subtotal, y un boton para eliminar el producto del carrito.
        $html = "";
        $html .= "<table class='table table-striped table-hover table-dark table-bordered'>";
        $html .= "<thead class='thead-dark'>";
        $html .= "<tr>";
        $html .= "<th scope='col'>#</th>";
        $html .= "<th scope='col'>Nombre</th>";
        $html .= "<th scope='col'>Precio</th>";
        $html .= "<th scope='col'>Cantidad</th>";
        $html .= "<th scope='col'>Subtotal</th>";
        $html .= "<th scope='col'>Eliminar</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";
        $contador = 1;
        $total = 0;
        $n = 0;

        foreach($productos as $producto){
            $html .= "<tr>";
            $html .= "<th scope='row'>".$contador."</th>";
            $html .= "<td>".$producto->getProNombre()."</td>";
            $html .= "<td>$".$producto->getPrecio()."</td>";
            $html .= "<td>$cantidad[$n]</td>";
            $html .= "<td>$".($producto->getPrecio() * $cantidad[$n])."</td>";
            $html .= "<td><button type='button' class='btn btn-outline-danger' onclick='eliminarCompra(" . $idcompraitems[$n] . ")'>Eliminar</button></td>";
            $html .= "</tr>";
            $contador++;
            $total += $producto->getPrecio() * $cantidad[$n];
            $n++;
        }
        $html .= "</tbody>";
        $html .= "</table>";
        $html .= "<h3 class='mt-3 text-white'>Total: $".$total."</h3>";

        return $html;


    }
}