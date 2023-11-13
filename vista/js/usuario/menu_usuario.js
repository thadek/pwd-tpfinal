const cambiarCorreo = () => {
    Swal.fire({
        title: 'Ingrese su nuevo correo',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Cambiar',
        showLoaderOnConfirm: true,
        preConfirm: (correo) => {
            return fetch(`../../controlador/usuario/cambiar_correo.php?correo=${correo}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Error: ${error}`
                    )
                })
        },
    })
};
