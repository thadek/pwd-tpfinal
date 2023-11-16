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
            return fetch(`../accion`)
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