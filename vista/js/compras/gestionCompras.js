$(document).ready(async function () {


    await generarTablas();

    

});


const obtenerCompras = async () => {
    const response = await fetch(`./accion/compra/listar.php`);
    const compras = await response.json();
    return compras;
}

const obtenerTodosLosTiposDeCompra = async () => {
    const todaslascompras = await obtenerCompras();
    const porconfirmar = todaslascompras.porconfirmar;
    const aceptadas = todaslascompras.confirmadas;
    const enviadas = todaslascompras.enviadas;
    const canceladas = todaslascompras.canceladas;

    return { porconfirmar, aceptadas, enviadas, canceladas };
}

const generarTablas = async () => {
    $('#cargando').show(100).delay(500);
    $('#cargando').hide(100).delay(600);
    const { porconfirmar, aceptadas, enviadas, canceladas } = await obtenerTodosLosTiposDeCompra();
    renderizarTabla(porconfirmar, estados[1]);
    renderizarTabla(aceptadas, estados[2]);
    renderizarTabla(enviadas, estados[3]);
    renderizarTabla(canceladas, estados[4]);
}


const estados = {
    1: "#porconfirmar",
    2: "#aceptadas",
    3: "#enviadas",
    4: "#canceladas"
}


const ultimoEstadoCompra = (compra) => {
    let salida = "";
    salida = compra.estado
    return salida;
}

const renderizarTabla = (compras, estado) => {



    if(compras.length === 0){
        $(`${estado}`).html(`<h2 class="text-center justify-content-center mt-4">No hay compras en este estado</h2>`);
        return;
    }

    let tabla = `<table class="table table-dark container-fluid roboto">
    <tbody>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Items</th>
            <th>Estado</th>
            
            <th>Acciones</th>
            

        </tr>
    
 
`;

    const tabHTMLEstado = $(`${estado}`);

    


    compras.forEach(compra => {
        const estadoCompra = ultimoEstadoCompra(compra);
        tabla += `<tr>
        <td>${compra.idcompra}</td>
        <td>${compra.usuario}</td>
        <td>${compra.items}</td>
        <td>${renderizarEstado(estadoCompra)}</td>
        <td>${renderizarBotones(compra.idcompra,estado)}</td>
        </tr>`;
        
       
    });

    tabla += "</tbody></table>";

    tabHTMLEstado.html(tabla);



}


const renderizarEstado = ({id,descripcion}) =>{

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



const renderizarBotones = (idcompra,estadohtml) => {

    let botones = "";
    switch (estadohtml) {
        case "#porconfirmar":
            botones = `<button class="btn btn-outline-light m-2 " onclick="detallesCompra(${idcompra})" ><i class="fa-solid fa-magnifying-glass"></i> Ver detalles de la compra</button>
            <button class="btn btn-outline-success m-2 "onclick="confirmarCompra(${idcompra})"> <i class="fa-solid fa-check"></i> Confirmar Compra</button>
            <button class="btn btn-outline-danger m-2 " onclick="cancelarCompra(${idcompra})"><i class="fa-solid fa-xmark"></i> Cancelar Compra</button>`;
            break;
        case "#aceptadas":
            botones = `<button class="btn btn-outline-light m-2 " onclick="detallesCompra(${idcompra})"><i class="fa-solid fa-magnifying-glass"></i> Ver detalles de la compra</button>
            <button class="btn btn-outline-success m-2" onclick="enviarCompra(${idcompra})"> <i class="fa-solid fa-check"></i> Marcar como enviada</button>
            <button class="btn btn-outline-danger m-2" onclick="cancelarCompra(${idcompra})"><i class="fa-solid fa-xmark"></i> Cancelar Compra</button>`;
            break;
        case "#enviadas":
            botones = `<button class="btn btn-outline-light m-2 " onclick="detallesCompra(${idcompra})"><i class="fa-solid fa-magnifying-glass"></i> Ver detalles de la compra</button>`;
            break;
        case "#canceladas":
            botones = `<button class="btn btn-outline-light m-2 " onclick="detallesCompra(${idcompra})"><i class="fa-solid fa-magnifying-glass"></i> Ver detalles de la compra</button>`;
            break;
        default:
            break;
    }

    return botones;

}


const confirmarCompra = async (idcompra) => {

  Swal.fire({ 
    title: '¿Estás seguro?',
    text: "La compra con id: "+idcompra+" será confirmada",
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText:"Cancelar",
    confirmButtonText: 'Confirmar'
    }).then(async (result) => {
    if (result.isConfirmed) {


        try{

            let datosForm = new URLSearchParams();
            datosForm.append("accion","confirmarCompra");
            datosForm.append("idcompra",idcompra);


            const response = await fetch(`./accion/compra/modificar.php`,{

                method:"POST",
                headers:{
                    "Content-Type":"application/x-www-form-urlencoded"
                },
                body:datosForm.toString()
            });
            const resp = await response.json();
            if(resp.status === 200){
                Swal.fire(
                    'Confirmada!',
                    `${resp.message}`,
                    'success'
                  )
                  generarTablas();
            }else{
                Swal.fire(
                    'Ocurrió un error.',
                    `${resp.message}`,
                    'error'
                  )
            }


        }catch(err){
            Swal.fire(
                'Ocurrió un error.',
                `Algo salio mal al confirmar la compra ${idcompra}. ${err}`,
                'error'
              )
        }

       
    }
    });
}

const enviarCompra = async (idcompra) => {
    
        Swal.fire({ 
            title: '¿Estás seguro?',
            text: "La compra con id: "+idcompra+" será marcada como enviada",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText:"Cancelar",
            confirmButtonText: 'Confirmar'
            }).then(async (result) => {
            if (result.isConfirmed) {
        
        
                try{
        
                    let datosForm = new URLSearchParams();
                    datosForm.append("accion","modificarEstado");
                    datosForm.append("idcompra",idcompra);
                    datosForm.append("idcompraestadotipo",3);
        
        
                    const response = await fetch(`./accion/compra/modificar.php`,{
        
                        method:"POST",
                        headers:{
                            "Content-Type":"application/x-www-form-urlencoded"
                        },
                        body:datosForm.toString()
                    });
                    const resp = await response.json();
                    if(resp.status === 200){
                        Swal.fire(
                            'Enviada!',
                            `${resp.message}`,
                            'success'
                        )
                        generarTablas();
                    }else{
                        Swal.fire(
                            'Ocurrió un error.',
                            `${resp.message}`,
                            'error'
                        )
                    }
        
        
                }catch(err){
                    Swal.fire(
                        'Ocurrió un error.',
                        `Algo salio mal marcar como enviada la compra con ID: ${idcompra}. ${err}`,
                        'error'
                    )
                }
        
            
            }
            });
}


const cancelarCompra = async (idcompra) => {

    Swal.fire({ 
        title: '¿Estás seguro?',
        text: "La compra con id: "+idcompra+" será cancelada y no es posible volver atrás una vez realizada esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText:"Cancelar",
        confirmButtonText: 'Confirmar'
        }).then(async (result) => {
        if (result.isConfirmed) {
    
    
            try{
    
                let datosForm = new URLSearchParams();
                datosForm.append("accion","modificarEstado");
                datosForm.append("idcompra",idcompra);
                datosForm.append("idcompraestadotipo",4);
    
    
                const response = await fetch(`./accion/compra/modificar.php`,{
    
                    method:"POST",
                    headers:{
                        "Content-Type":"application/x-www-form-urlencoded"
                    },
                    body:datosForm.toString()
                });
                const resp = await response.json();
                if(resp.status === 200){
                    Swal.fire(
                        'Compra cancelada.',
                        `${resp.message}`,
                        'success'
                    )
                    generarTablas();
                }else{
                    Swal.fire(
                        'Ocurrió un error.',
                        `${resp.message}`,
                        'error'
                    )
                }
    
    
            }catch(err){
                Swal.fire(
                    'Ocurrió un error.',
                    `Algo salio mal al cancelar la compra ${idcompra}. ${err}`,
                    'error'
                )
            }
    
        
        }
        });

}


const detallesCompra = (id) => {
    window.location.href = `./detalleCompraDep.php?id=${id}`;
}