$(document).ready(async function () {
    obtenerDetalleCompraCliente().then((response) => {
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

const obtenerDetalleCompraCliente = async () => {
    const valores = window.location.search;
    const urlParams = new URLSearchParams(valores);
    if (!urlParams.has('id')) {
        window.location.href = "http://localhost/pwd/pwd-tpfinal/vista/"
        return;
    }
    const url = `http://localhost/pwd/pwd-tpfinal/vista/accion/compra/listar.php?id=${urlParams.get('id')}`;
    const resp = await fetch(url);
    const response = await resp.json();
    return response;
}