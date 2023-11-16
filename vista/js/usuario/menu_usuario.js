const cambiarCorreo = async () => {
    Swal.fire({
        title: 'Ingrese su nuevo correo electrónico',
        input: 'text',
        icon: 'info',
        customClass: {
            validationMessage: 'my-validation-message'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "Cancelar",
        confirmButtonText: 'Confirmar',
        preConfirm: async (email) => {
            if (!validator.isEmail(email)) {
                Swal.showValidationMessage(' El correo electrónico ingresado no es válido')
            } else {
                try {

                    let datosForm = new URLSearchParams();
                    datosForm.append("accion", "modificar_email");
                    datosForm.append("email", email);

                    const response = await fetch(`./accion/me/modificar.php`, {

                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: datosForm.toString()
                    });
                    return response.json();


                } catch (err) {
                    Swal.fire(
                        'Ocurrió un error.',
                        `Algo salio mal al modificar contraseña: ${err}`,
                        'error'
                    )
                }

            }

        }
    }).then(async (result) => {



        if (result.value.status === 200) {


            Swal.fire({
                title: "Email modificado con éxito",
                icon: "success",
                timer: 1000,
                timerProgressBar: true,
                willClose: () => {
                    window.location.href = "./usuario.php";
                }
            })


        } else {
            Swal.fire(
                'Ocurrió un error.',
                `${result.value.message}`,
                'error'
            )
        }

    });
};

const cambiarPassword = async () => {

    Swal.fire({
        title: 'Ingrese su nueva contraseña',
        html: `<input type="password" id="password_change" class="swal2-input">`,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "Cancelar",
        confirmButtonText: 'Confirmar'
    }).then(async (result) => {
        if (result.isConfirmed) {

            try {
                const password = $("#password_change").val();



                let datosForm = new URLSearchParams();
                datosForm.append("accion", "modificar_password");
                datosForm.append("password", password);

                const response = await fetch(`./accion/me/modificar.php`, {

                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: datosForm.toString()
                });
                const resp = await response.json();
                if (resp.status === 200) {


                    Swal.fire({
                        title: "Contraseña modificada con éxito",
                        icon: "success",
                        text: "En breve serás redirigido al login para que inicies sesión con tu nueva contraseña",
                        timer: 1200,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = "./logout.php";
                        }
                    })


                } else {
                    Swal.fire(
                        'Ocurrió un error.',
                        `${resp.message}`,
                        'error'
                    )
                }


            } catch (err) {
                Swal.fire(
                    'Ocurrió un error.',
                    `Algo salio mal al modificar contraseña: ${err}`,
                    'error'
                )
            }
        }
    });




}

const cambiarRolVisualizacion = async () => {

    const roles = await obtenerRoles();

    const options = {};
    $.map(roles,
            function(rol) {
                options[rol.idRol] = rol.roDescripcion;
            });



    Swal.fire({
        title: 'Seleccione un rol',
        input: 'select',
        inputOptions: options,
        inputPlaceholder: 'Seleccione un rol',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => {
            return new Promise((resolve) => {
                if (value !== '') {
                    resolve()
                } else {
                    resolve('Debe seleccionar un rol')
                }
            })
        }
    }).then(async (result) => {
        if (result.isConfirmed) {

            try {
                const idRol = result.value;

                let datosForm = new URLSearchParams();
                datosForm.append("accion", "cambiar_rol_visualizar");
                datosForm.append("idrol", idRol);

                const response = await fetch(`./accion/me/modificar.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: datosForm.toString()
                });
                const resp = await response.json();
                if (resp.status === 200) {
                    Swal.fire({
                        title: "Rol cambiado con éxito",
                        icon: "success",
                        timer: 1000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = "./usuario.php";
                        }
                    })

                }
            } catch (err) {
                Swal.fire(
                    'Ocurrió un error.',
                    `Algo salio mal al modificar rol: ${err}`,
                    'error'
                )
            }

        }
    });
}

const obtenerRoles = async () => {
    const url = `./accion/me/obtenerRoles.php`;
    const resp = await fetch(url);
    const response = await resp.json();
    return response;
}