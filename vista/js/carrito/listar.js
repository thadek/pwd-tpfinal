


    const obtenerCarrito = async () => {
        const url = './accion/carrito/listar.php';
        const respuesta = await fetch(url);
        const carrito = await respuesta.json();
        return carrito;
    }

    const renderizarCarrito = (carrito) => {
        const contenedor = $('#listaproductos');


        

        if (carrito.length == 0 ) {
            const contGeneral = $('#cont-carrito');
            const html = `<h3 class='text-white'>No hay productos en el carrito</h3>`;
            contGeneral.html(html);
        } else {

            let total = 0;
            let cardproducto = ``;

            carrito.items.forEach((item, index) => {


                cardproducto += `
                <!-- Single item -->
                <div class="row">
                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                        <!-- Imagen -->
                        <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                            <img src="${item.producto.proDetalle}" class="w-100" />    
                        </div>
                        <!-- Imagen -->
                    </div>

                    <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                        <!-- Data -->
                        <p><strong>${item.producto.proNombre}</strong></p>   
                        <p><strong>Precio Unitario: ${formatoNumeroConDolar(item.producto.precio)}</strong></p>             
                        <button type="button" class="btn btn-danger btn-sm me-1 mb-2" onclick="quitarProducto(${item.idCompraItem}) title="Quitar item"> Quitar
                            <i class="fas fa-trash"></i>
                        </button>

                        <!-- Data -->
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                        <!-- Quantity -->

                        <div class="d-flex mb-4" style="max-width: 300px">
                            <button class="btn btn-outline-light px-3 me-2" onclick="restarUno(${item.idCompraItem},${item.producto.idProducto})">
                                <i class="fas fa-minus"></i>
                            </button>

                            <div class="form-outline">
                                <input id="cantidad_item_${item.idCompraItem}" disabled min="0" name="quantity" value="${item.ciCantidad}"  type="number" class="form-control" />
                            </div>

                            <button class="btn btn-outline-light px-3 ms-2" onclick="sumarUno(${item.idCompraItem},${item.producto.idProducto})">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <!-- Quantity -->

                        <!-- Price -->
                        <p class="pt-4" style="font-size:1.2em">
                            Subtotal :
                            
                            <strong>${formatoNumeroConDolar(item.producto.precio * item.ciCantidad)}</strong>
                        </p>
                        <!-- Price -->
                    </div>
                </div>
                <!-- Single item -->

               ${(carrito.items[index + 1] ? `<hr class="mb-4" />` : ``)}
                `;

                total += item.producto.precio * item.ciCantidad;
            });

            $('#subtotal').html(formatoNumeroConDolar(total));
            $('#total').html(formatoNumeroConDolar(total));

            contenedor.html(cardproducto);

        }



    }


    const refrescarCarrito = async () => {
        obtenerCarrito().then(carrito => {
            renderizarCarrito(carrito);
        });

    }

    refrescarCarrito();











const sumarUno = (idcompraitem,idproducto) => {

    const item = document.getElementById(`cantidad_item_${idcompraitem}`);
    const cantidad = Number.parseInt(item.value)+1;
    Swal.fire({
        title: "Actualizando estado...",
        timer: 300,
        didOpen: async() => {
            Swal.showLoading();
            const resp = await cambiarCantidad(idproducto,cantidad)
            if(resp.status == 200){
                item.stepUp()
                refrescarCarrito();
                Swal.close();
            }
        }
    }).then((result) => {
        /* Read more about handling dismissals below */

    });


}

const restarUno = (idcompraitem,idproducto) => {
    const item = document.getElementById(`cantidad_item_${idcompraitem}`); 
    const cantidad = Number.parseInt(item.value)-1;
    Swal.fire({
        title: "Actualizando estado...",
        timer: 300,
        didOpen: async () => {
            Swal.showLoading();
             cambiarCantidad(idproducto,cantidad)
            .then(resp=>{
                if(resp.status == 200){
                    item.stepDown();
                    refrescarCarrito();
                    Swal.close();
                }

            })
            .catch(err => console.log(err));
          
            
            
            
        }
    }).then((result) => {
        /* Read more about handling dismissals below */

    });
    
}

const cambiarCantidad = async (idproducto,cantidad) => {

    const obj = {
        idProducto: idproducto,
        cantidad: cantidad
    }

    const url = './accion/carrito/modificar.php';

    let salida;
    try{
        const resp = await fetch(url, {
            method: 'POST',
            body: JSON.stringify(obj),
            headers: {
                'Content-Type': 'application/json'
            }
        })

        
        salida = await resp.json();
        if(salida.status != 200){
            Swal.fire({
                title: salida.message,
                icon: "error",
                timer: 2000,
                timerProgressBar: true,
            })
        }
        return salida;
    }catch(err){
        console.log(err);

    }
    
}


const vaciarCarrito = async () => {
    const url = './accion/carrito/vaciarCarrito.php';
    const resp = await fetch(url,{
        method:'POST'
    });
    const salida = await resp.json();

    if(salida.status == 200){
        Swal.fire({
            title: salida.message,
            icon: "success",
            timer: 2000,
            timerProgressBar: true,
        })
        refrescarCarrito();
    }
    //return salida;
}


const enviarCompra = async () => {
    const url = './accion/carrito/iniciarCompra.php';
    const resp = await fetch(url,{
        method:'POST'
    });
    const salida = await resp.json();

    if(salida.status == 200){
        Swal.fire({
            title: salida.message,
            text:"Tu compra paso al área de deposito, podes encontrarla en el menu usuario->mis compras",
            icon: "success"
        })
        refrescarCarrito();
    }
    //return salida;

}

function formatoNumeroConDolar(numero) {
    // Verificar si el número es válido
    if (isNaN(numero)) {
        return 'Número inválido';
    }

    // Redondear el número a dos decimales y convertirlo a cadena
    const numeroFormateado = parseFloat(numero).toFixed(2).toString();

    // Dividir el número en partes antes y después del punto decimal
    const partes = numeroFormateado.split('.');

    // Agregar comas como separadores de miles a la parte antes del punto decimal
    const parteEnteraFormateada = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    // Componer el resultado final con el símbolo de dólar
    const resultado = `$${parteEnteraFormateada}.${partes[1]}`;

    return resultado;
}