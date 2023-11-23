<?php
/*
class ABMIniciarCompra{

    public function abm($dato) {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $objSession = new Session();
        $usuario = $objSession->getUsuario();
        $idusuario = $usuario->getIdUsuario();
        
        $producto = $dato; 
        
        $abmCompra = new AbmCompra();
        $abmCompraItem = new AbmCompraItem();
        $abmCompraEstado = new AbmCompraEstado();
        
        //0000-00-00 00:00:00
        //$fechaactual = date("Y-d-m", strtotime("now"));
        $fechaactual = date("Y-m-d H:i:s");
        

        $param = array(
            'accion' => 'nuevo', 
            'cofecha' => $fechaactual,  
            'usuario' => $usuario,  
            'items' => []  
        );
        
        $abmCompra->abm($param);
        
        //buscamos la compra que se acaba de crear.
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
        
        return ['status' => 200, 'message' => 'Compra iniciada'];
      
    }

    public function traerCarrito(){
       

        $abmUsuario = new AbmUsuario();
        $carrito = $abmUsuario->cargarCarritoUser();

        if(empty($carrito)){
            return "<h3 class='text-white'>No hay productos en el carrito</h3>";
        }

        $compraItems = $carrito[0]->getItems();
      

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


        foreach($compraItems as $compraItem){
            $html .= "<tr>";
            $html .= "<th scope='row'>".$contador."</th>";
            $html .= "<td>".$compraItem->getProducto()->getProNombre()."</td>";
            $html .= "<td>$".$compraItem->getProducto()->getPrecio()."</td>";
            $html .= "<td>".$compraItem->getCiCantidad()."</td>";
            $html .= "<td>$".($compraItem->getProducto()->getPrecio() * $compraItem->getCiCantidad())."</td>";
            $html .= "<td><button type='button' class='btn btn-outline-danger' onclick='eliminarCompra(" . $compraItem->getIdCompraItem() . ")'>Eliminar</button></td>";
            $html .= "</tr>";
            $contador++;
            $total += $compraItem->getProducto()->getPrecio() * $compraItem->getCiCantidad();
            
        }
        $html .= "</tbody>";
        $html .= "</table>";
        $html .= "<h3 class='mt-3 text-white'>Total: $".$total."</h3>";

        return $html;


    } }
    
*/
