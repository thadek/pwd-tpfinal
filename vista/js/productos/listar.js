$(document).ready(function () {

    const obtenerProductos = async () => {
        const url = './accion/productos/listar.php';
        const respuesta = await fetch(url);
        const productos = await respuesta.json();
        return productos;
    }

    const renderizarProductos = (productos) => {
        const contenedor = $('#products');
        productos.forEach(producto => {

            const cantstock = (producto.proCantStock>0) ? `<span class="badge text-bg-success sinborde">En stock</span>`: `<span class="badge text-bg-danger sinborde">Sin stock</span>`;

            const btnAgregar = (producto.proCantStock>0) ? `<button class="btn btn-dark" data-id="${producto.idProducto}">Agregar al carrito</button>`: `<button class="btn btn-dark" disabled >Sin stock</button>`;

            const $producto = $(`

            <div class="col-md-4 mb-3">
                <div class="card " data-bs-theme="dark">
                
                    <img src="${producto.proDetalle}" class="card-img-top" alt="${producto.proNombre}"  style="width: 100%;">
                    ${cantstock}
                    <div class="card-body bg-navbar">
                   <h2 class="card-title">  ${formatoNumeroConDolar(producto.precio)}
                   </h2> 
                    
                    ${producto.proNombre}
                  
                   
                  
                   </div>
                   ${btnAgregar}
                   </div>
                    
                </div>
            </div>
            `);
            contenedor.append($producto);
        });
    }



    obtenerProductos().then(productos => {
        //console.log(productos);
        renderizarProductos(productos);
    
    });



    





});


    

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