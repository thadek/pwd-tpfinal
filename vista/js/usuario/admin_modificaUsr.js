function modificarUser(idusuario, usnombre, usmail, usrol, usdeshabilitado) {
    var datos = {
        idusuario: idusuario,
        usnombre: usnombre,
        usmail: usmail,
        usrol: usrol,
        usdeshabilitado: usdeshabilitado
    }
    
    $.ajax({
        type: 'POST',
        url: './accion/usuario/accionModificar.php',
        data: JSON.stringify(datos),
        contentType: 'application/json',
        success: function(respuesta){
            Swal.fire({
                title: "Usuario modificado con éxito",
                icon: "success",
                text: "En breve serás redirigido al la lista de usuarios",
                timer: 2000,
                timerProgressBar: true,
                willClose: () => {
                  window.location.href = "./menuUsuarios.php";
                }
            }) }
        }).fail(
            function(jqXHR, textStatus, errorThrown){
              
                Swal.fire({
                    title: jqXHR.responseJSON.mensaje,
                    icon: "error",
    
                });
            }
        );   
}