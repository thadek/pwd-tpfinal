const tabla = $('#tablaprod').DataTable({
    paging: false,
    ajax: {
        url: "./accion/productos/listar.php",
        dataSrc: ""
    },
    columns: [{
            data: "idProducto"
        },
        {
            data: "proNombre"
        },
        {
            data: "proDetalle"
        },
        {
            data: "precio"
        },
        {
            data: "proCantStock"
        },
        {
            data: "acciones"
        }
    ]
});

const peticionAltaProd = async (formValues) => {
    const [pronombre, prodetalle, precio, procantstock] = formValues;
    const response = await fetch('./accion/productos/alta.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            pronombre,
            prodetalle,
            precio,
            procantstock
        }),
    });

    const data = await response.json();
    if (data.status == 200) {
        Swal.fire({
            icon: 'success',
            title: data.message,
            showConfirmButton: false,
            timer: 1500,
        })

        tabla.ajax.reload();
    } else {
        Swal.fire({
            icon: 'error',
            title: data.message,
            showConfirmButton: false,
            timer: 1500
        })
    }
}


const obtenerProducto = async (id) => {
    const response = await fetch('./accion/productos/listar.php?id=' + id);
    const data = await response.json();
    return data;
}


const peticionModifProd = async (formValues) => {

    const [pronombre, prodetalle, precio, procantstock, idproducto] = formValues;
    const response = await fetch('./accion/productos/modificar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            pronombre,
            prodetalle,
            precio,
            procantstock,
            idproducto
        }),
    });

    const data = await response.json();
    if (data.status == 200) {
        Swal.fire({
            icon: 'success',
            title: data.message,
            showConfirmButton: false,
            timer: 400,
        })

        tabla.ajax.reload();
    } else {
        Swal.fire({
            icon: 'error',
            title: data.message,
            showConfirmButton: false,
            timer: 1500
        })
    }
}



const editarProducto = async (id) => {

    const producto = await obtenerProducto(id);


    const {
        value: formValues
    } = await Swal.fire({
        title: 'Editar Producto',
        html: `<input id="swal-input1" class="swal2-input" value=${producto.proNombre}>
        <input id="swal-input2" class="swal2-input"  value=${producto.proDetalle}>
        <input id="swal-input3" class="swal2-input"  value=${producto.precio}>
        <input id="swal-input4" class="swal2-input"  value=${producto.proCantStock}>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "Cancelar",
        confirmButtonText: 'Confirmar',
        preConfirm: async () => {

            const inputs = [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value,
                document.getElementById('swal-input3').value,
                document.getElementById('swal-input4').value,
                id
            ]

            inputs.forEach(input => {
                if (input === '') {
                    Swal.showValidationMessage(
                        `Faltan campos por completar`
                    )
                }
                if (input == inputs[2] && isNaN(input)) {
                    Swal.showValidationMessage(
                        `El precio debe ser un número`
                    )
                }
                if (input == inputs[3] && isNaN(input)) {
                    Swal.showValidationMessage(
                        `El stock debe ser un número`
                    )
                }
            });

            return inputs
        }
    }).then(async (result) => {
        if (result.isConfirmed) {
            await peticionModifProd(result.value);
        }
    })

}


const borrarProducto = async (id) =>{
Swal.fire({
    title: '¿Está seguro que desea eliminar el producto?',
    text: "Esta acción no se puede revertir",
    icon: 'warning',
    showCancelButton: true,
    cancelButtonText: "Cancelar",
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Confirmar'
}).then(async (result) => {
    if (result.isConfirmed) {
        await ejecutarBorrarProd(id);
    }
})    
}

const ejecutarBorrarProd = async (id) =>{
const response = await fetch('./accion/productos/baja.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            idproducto: id
        }),
    });

    const data = await response.json();
    if (data.status == 200) {
        Swal.fire({
            icon: 'success',
            title: data.message,
            showConfirmButton: false,
            timer: 400,
        })

        tabla.ajax.reload();
    } else {
        Swal.fire({
            icon: 'error',
            title: data.message,
            showConfirmButton: false,
            timer: 1500
        })
    }
}

async function nuevoProducto() {
    const {
        value: formValues
    } = await Swal.fire({
        title: 'Nuevo Producto',
        html: '<input id="swal-input1" class="swal2-input" placeholder="Nombre">' +
            '<input id="swal-input2" class="swal2-input" placeholder="Link imagen">' +
            '<input id="swal-input3" class="swal2-input" placeholder="Precio">' +
            '<input id="swal-input4" class="swal2-input" placeholder="Stock">',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "Cancelar",
        confirmButtonText: 'Confirmar',
        preConfirm: async () => {

            const inputs = [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value,
                document.getElementById('swal-input3').value,
                document.getElementById('swal-input4').value
            ]

            inputs.forEach(input => {
                if (input === '') {
                    Swal.showValidationMessage(
                        `Faltan campos por completar`
                    )
                }
                if (input == inputs[2] && isNaN(input)) {
                    Swal.showValidationMessage(
                        `El precio debe ser un número`
                    )
                }
                if (input == inputs[3] && isNaN(input)) {
                    Swal.showValidationMessage(
                        `El stock debe ser un número`
                    )
                }
            });

            return inputs
        }
    }).then(async (result) => {
        if (result.isConfirmed) {
            await peticionAltaProd(result.value);
        }
    })

}