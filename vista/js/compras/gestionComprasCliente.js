const obtenerIdClienteDesdeSesion = async () => {
    try {
        const response = await fetch('http://localhost:8080/pwd/pwd-tpfinal/vista/accion/compra/idcliente.php');
        const data = await response.json();

        if (data.error) {
            // Manejar el error, por ejemplo, redirigir al usuario o mostrar un mensaje de error
            console.error('Error en la llamada AJAX:', data.error);
            return null;
        }

        return data.idusuario;
    } catch (error) {
        console.error('Error en la llamada AJAX:', error);
        return null;
    }
}

$(document).ready(async function () {
    // Llamar a la función para obtener la ID del cliente
    const idUsuario = await obtenerIdClienteDesdeSesion();
    console.log('ID del Usuario:', idUsuario);
    if (!idUsuario) {
        // Manejar la falta de ID del cliente, por ejemplo, redirigir a la página de inicio
        window.location.href = "http://localhost/pwd/pwd-tpfinal/vista/";
        return;
    }

    await generarTablaMisCompras();
});

const ultimoEstadoCompra = (compra) => {
    let salida = "";
    const estado = compra.estados.filter(estado => estado.ceFechaFin === null);
    if (estado.length > 0) {
        salida = estado[0].compraEstadoTipo;
    }
    return salida;
}

const renderizarEstado = ({ idCompraEstadoTipo: id, cetDescripcion: descripcion }) => {
    let salida = "";
    switch (id) {
        case 1:
            salida = `<span data-bs-theme="dark" class=" px-2 py-1 fw-semibold text-info-emphasis bg-info-subtle border border-info-subtle rounded-1">${descripcion}</span>`;
            break;
        case 2:
            salida = `<span data-bs-theme="dark" class=" px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-1">${descripcion}</span>`;
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

const obtenerMisCompras = async () => {
    // Obtener el ID del cliente desde la sesión
    const idUsuario = await obtenerIdClienteDesdeSesion();

    if (!idUsuario) {
        // Manejar la falta de ID del cliente, por ejemplo, redirigir a la página de inicio
        window.location.href = "http://localhost:8080/pwd/pwd-tpfinal/vista/";
        return;
    }

    // Agregar el ID del cliente a la URL de la solicitud
    const response = await fetch(`http://localhost:8080/pwd/pwd-tpfinal/vista/accion/compra/listarClientes.php?idusuario=${idUsuario}`);
    const misCompras = await response.json();
    return misCompras;
}

const generarTablaMisCompras = async () => {
    const misCompras = await obtenerMisCompras();
    renderizarTablaMisCompras(misCompras);
}

const renderizarTablaMisCompras = (compras) => {
    const tabHtml = $('#misCompras');
    if (!Array.isArray(compras) || compras.length === 0) {
        tabHtml.html(`<h2 class="text-center justify-content-center mt-4">No tienes compras registradas</h2>`);
        return;
    }

    let tabla = `<table class="table table-dark container-fluid roboto">
        <tbody>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>`;

    compras.forEach(compra => {
        const estadoCompra = ultimoEstadoCompra(compra);
        tabla += `<tr>
            <td>${compra.idcompra}</td>
            <td>${compra.cofecha}</td>
            <td>${renderizarEstado(estadoCompra)}</td>
            <td>${renderizarBotonesCliente(compra.idcompra, estadoCompra)}</td>
        </tr>`;
    });

    tabla += '</tbody></table>';
    tabHtml.html(tabla);
}

const renderizarBotonesCliente = (idcompra, estado) => {
    let botones = `<button class="btn btn-outline-light m-2" onclick="detallesCompra(${idcompra})"><i class="fa-solid fa-magnifying-glass"></i> Detalles</button>`;

    if (estado.idCompraEstadoTipo === 1) {
        botones += `<button class="btn btn-outline-danger m-2" onclick="cancelarCompra(${idcompra})"><i class="fa-solid fa-xmark"></i> Cancelar Compra</button>`;
    }

    return botones;
};

const detallesCompra = (id) => {
    window.location.href = `../../detalleCompraCliente.php?id=${id}`;
}