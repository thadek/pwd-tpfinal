$(document).ready(async function () {

    obtenerDetalleCompraDep().then((response) => {
        renderizarDetalle(response);
    }).catch((error) => {
        $("#detallecompra").addClass("cont");
        Swal.fire({
            title: 'Error',
            text: "Id de compra no encontrado",
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
            
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "http://localhost/pwd/pwd-tpfinal/vista/"
            }
        })
    });

});




const obtenerDetalleCompraDep = async () => {

    const valores = window.location.search;
    const urlParams = new URLSearchParams(valores);
    if (!urlParams.has('id')) {
        //window.location.href = "http://localhost/pwd/pwd-tpfinal/vista/"
        return;
    }
    const url = `http://localhost/pwd/pwd-tpfinal/vista/accion/compra/listar.php?id=${urlParams.get('id')}`;
    const resp = await fetch(url);
    const response = await resp.json();
    return response;
}

const ultimoEstadoCompra = (compra) => {
    let salida = "";
    const estado = compra.estados.filter(estado => estado.ceFechaFin === null);
    if (estado.length > 0) {
        salida = estado[0].compraEstadoTipo;
    }
    return salida;
}


const renderizarEstado = ({idCompraEstadoTipo:id,cetDescripcion:descripcion}) =>{

    let salida = "";
    switch (id) {
        case 1:
            salida = `<span data-bs-theme="dark" class=" px-2 py-1 fw-semibold text-light-emphasis bg-light-subtle border border-light-subtle rounded-1">${descripcion}</span>`;
            break;
        case 2:
            salida = `<span data-bs-theme="dark" class=" px-2 py-1 fw-semibold text-info-emphasis bg-info-subtle border border-info-subtle rounded-1">${descripcion}</span>`;
            break;
        case 3:
            salida = `<span data-bs-theme="dark" class=" px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-1">${descripcion}</span>`;
            break;
        case 4:
            salida = `<span data-bs-theme="dark" class=" px-2 py-1 fw-semibold text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-1">${descripcion}</span>`;
            break;
        default:
            break;
    }

    return salida;

}



const renderizarEstadosDeCompra = (estados) => {
    let salida = "";
    estados.forEach(estado => {

        const fechaFin = estado.ceFechaFin ? estado.ceFechaFin : "Estado actual";

        salida += `
        <tr>
            <td>${estado.ceFechaIni}</td>
            <td>${fechaFin}</td>
            <td>${estado.compraEstadoTipo.cetDescripcion}</td>
        </tr>
        `
    });
    return salida;
}


const renderizarProductosDeCompra = (items) => {
    let salida = "";
    items.forEach(item => {
        salida += `
        <tr>
            <td>${item.idCompraItem}</td>
            <td>${item.producto.proNombre}</td>
            <td>${item.ciCantidad}</td>
            <td>${item.producto.precio}</td>
        </tr>
        `
    });
    return salida;
}

const renderizarUltimoEstado = (estado) => {
    return `<p><strong>Estado:</strong> ${renderizarEstado(estado)}</p>`
}



const renderizarDetalle = (compra) => {
    const html = `
    <div data-bs-theme="dark" class="container mt-5">
            <h1>Detalle de Compra</h1>

            <div class="card mt-4">
                <div class="card-header">
                    <h2>Compra #${compra.idcompra}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            ${renderizarUltimoEstado(ultimoEstadoCompra(compra))}
                            <p><strong>Fecha:</strong> ${compra.cofecha}</p>
                            
                        </div>
                        <div class="col-md-6">
                            <p><strong>Usuario:</strong> ${compra.usuario.usNombre}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h2>Estados de la Compra</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha Inicio </th>
                                <th>Fecha Fin </th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                           ${renderizarEstadosDeCompra(compra.estados)}
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h2>Items de la Compra</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${renderizarProductosDeCompra(compra.items)}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>`

    $("#detallecompra").html(html);

}