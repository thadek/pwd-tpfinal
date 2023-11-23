<?php

class ABMCarrito
{

    //Estado Compra asociado al carrito
    const EN_CARRITO = 0;

    /**
     * Intenta crear un carrito para el usuario logueado, creando un obj compra y 
     * asociandole un compra estado EN_CARRITO CON FECHA ACTUAL a dicho usuario
     * Si el usuario ya posee carrito activo devuelve el carrito existente
     * @return Compra
     */
    public function crearCarrito()
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        //Valido sesion
        $session = new Session();
        $resp = null;
        if ($session->validar()) {

            //Valido que el usuario no tenga carrito previo
            $abmUsuario = new AbmUsuario();
            $usuario = $session->getUsuario();
            $resp = $abmUsuario->cargarCarritoUser();
            if (empty($resp)) {

                //1) Creo e inserto obj compra
                $compra = new Compra();
                $compra->setCoFecha(date("Y-m-d H:i:s"));
                $compra->setUsuario($usuario);
                $compra->insertar();
                //2) Creo e inserto obj compraestado
                $compraEstado = new CompraEstado();
                $compraEstado->setCompra($compra);
                //3) Cargo estado en carrito de compraestadotipo
                $compraEstadoTipo = new CompraEstadoTipo();
                $compraEstadoTipo->setIdCompraEstadoTipo(self::EN_CARRITO);

                // Seteo el estado en el objeto compraestado
                $compraEstado->setCompraEstadoTipo($compraEstadoTipo);
                $compraEstado->setCeFechaIni(date("Y-m-d H:i:s"));

                //Inserto el dato en la tabla
                $compraEstado->insertar();

                //Traigo la compra recien creada
                $compra->buscar();

                //Devuelvo la compra
                $resp = $compra;
            } else {
                $resp = $resp[0];
            }
        }
        return $resp;
    }




    /**
     * Devuelve el carrito(ObjetoCompra) del usuario logueado
     * @return Compra|null
     */
    public function obtenerCarrito()
    {
        $session = new Session();
        $resp = null;
        if ($session->validar()) {
            $abmUsuario = new AbmUsuario();
            $resp = $abmUsuario->cargarCarritoUser();
            if (!empty($resp)) {
                $resp = $resp[0];
            }
        }
        return $resp;
    }


    /**
     * Verifica si un carrito contiene un producto, si lo contiene devuelve el item, sino null
     * @param int $idProducto
     * @return CompraItem|null
     */
    public function verificarProductoEnCarrito($idProducto)
    {
        $session = new Session();
        $resp = null;
        if ($session->validar()) {
            $carrito = $this->obtenerCarrito();
            if (!empty($carrito)) {
                $abmCompraItem = new AbmCompraItem();
                $resp = $abmCompraItem->buscar(["idproducto" => $idProducto, "idcompra" => $carrito->getIdCompra()]);
                if (!empty($resp)) {
                    $resp = $resp[0];
                }
            }
        }
        return $resp;
    }



    /**
     * Modifica la cantidad de un producto en el 
     * carrito del usuario logueado
     * @param int $idProducto
     * @param int $cantidad
     * @return array
     */
    public function setearCantItem($idProducto, $cantidad)
    {
        $abmProducto = new AbmProducto();
        $salida = ["status" => 409, "message" => "No se pudo modificar la cantidad del producto en el carrito "];

        $carrito = $this->obtenerCarrito();
        if (!empty($carrito)) {
            $productoEnCarrito = $this->verificarProductoEnCarrito($idProducto);
            if (!empty($productoEnCarrito)) {
                //Si el producto ya esta en el carrito, actualizo la cantidad, PRIMERO MIRO SI HAY STOCK
                $hayStock = $abmProducto->verificarStock($idProducto, $cantidad);
                if ($hayStock) {
                    if($cantidad == 0){
                       $salida = $this->eliminarItem($productoEnCarrito->getIdCompraItem());
                    }else{

                        if($cantidad == $productoEnCarrito->getCiCantidad()){
                            $salida = ["status" => 200, "message" => "No hubo modificaciones"];
                        }else{
                            $productoEnCarrito->setCiCantidad($cantidad);
                            $productoEnCarrito->modificar();
                            // $salida = $productoEnCarrito;
                            $salida = ["status" => 200, "message" => "Cantidad modificada"];
                        }
                        
                    }    
                    
                } else {
                    $salida = ["status" => 409, "message" => "No hay stock suficiente para el producto"];
                }
            } else {
                $salida = ["status" => 409, "message" => "No se encontró el producto en el carrito"];
            }
        } else {
            $salida = ["status" => 409, "message" => "No se encontró el carrito del usuario"];
        }

        return $salida;
    }


    /**
     * Elimina un producto del carrito del usuario logueado
     * @param int $idCompraItem
     * @return array
     */
    public function eliminarItem($idCompraItem)
    {
        $abmCompraItem = new AbmCompraItem();
        $salida = ["status" => 409, "message" => "No se pudo eliminar el producto del carrito "];

        $carrito = $this->obtenerCarrito();
        if (!empty($carrito)) {
            $productoEnCarrito = $abmCompraItem->buscar(["idcompraitem" => $idCompraItem, "idcompra" => $carrito->getIdCompra()]);
            if (!empty($productoEnCarrito)) {
                $productoEnCarrito = $productoEnCarrito[0];
                $productoEnCarrito->eliminar();

                //Me fijo si quedaron items en el carrito, si no quedaron elimino el carrito
                $itemsEnCarrito = $abmCompraItem->buscar(["idcompra" => $carrito->getIdCompra()]);
                if (empty($itemsEnCarrito)) {
                    $this->vaciarCarrito();
                    $salida = ["status" => 200, "message" => "Producto eliminado del carrito, carrito dado de baja"];
                }else{
                    $salida = ["status" => 200, "message" => "Producto eliminado del carrito"];
                }

               
            } else {
                $salida = ["status" => 409, "message" => "No se encontró el producto en el carrito"];
            }
        } else {
            $salida = ["status" => 409, "message" => "No se encontró el carrito del usuario"];
        }

        return $salida;
    }


    /**
     * Agrega un producto al carrito del usuario logueado, 
     * verificando si existe el carrito, 
     * si el producto ya esta en el carrito,
     * si hay stock suficiente para el producto
     * @param int $idProducto
     * @param int $cantidad
     * @return array
     */
    public function agregarItemAlCarrito($idProducto, $cantidad)
    {
        //Verifico que el usuario tenga un carrito, caso contrario le creo uno
        $abmProducto = new AbmProducto();

        $salida = ["status" => 409, "message" => "No se pudo agregar el producto al carrito "];
        //Creo o obtengo el carrito del usuario
        $carrito = $this->crearCarrito();

        //Me fijo si el producto ya esta en el carrito o no
        $productoEnCarrito = $this->verificarProductoEnCarrito($idProducto);

        //¿El producto ya esta en el carrito? Modifico la cantidad
        if (!empty($productoEnCarrito)) {
            $salida = $this->setearCantItem($idProducto, $cantidad);
        } else {
            //Si el producto no esta en el carrito, lo agrego
            $hayStock = $abmProducto->verificarStock($idProducto, $cantidad);
            if ($hayStock) {
                $abmCompraItem = new AbmCompraItem();
                $prod = new Producto();
                $prod->setIdProducto($idProducto);
                $res = $abmCompraItem->alta(array("compra" => $carrito, "producto" => $prod, "cicantidad" => $cantidad));
                if ($res) {
                    $salida = ["status" => 200, "message" => "Producto agregado al carrito"];
                }
            } else {
                $salida = ["status" => 409, "message" => "No hay stock suficiente para el producto"];
            }
        }


        return $salida;
    }


    public function vaciarCarrito(){

        //hay que sacar el id del usuario logueado.
        $salida = ["status" => 409, "message" => "No se pudo vaciar el carrito "];
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

        $salida = ["status" => 200, "message" => "Carrito vaciado"];

        return $salida;
    
    }


    public function iniciarCompra(){

       $compra = $this->obtenerCarrito();
       $abmCompraEstado = new AbmCompraEstado();
       $salida = $abmCompraEstado->cambiarEstadoDeCompra($compra->getIdCompra(),1);
       return $salida;
      
    }
    



}
