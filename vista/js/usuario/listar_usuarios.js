$(document).ready(function(){

    const obtenerUsuarios = async () => {
        const url = './accion/usuario/accionListarUsuarios.php';
        const respuesta = await fetch(url);
        const usuarios = await respuesta.json();
        return usuarios;
    }

    const renderizarUsuarios = (usuarios) =>{
        const contenedor = $('#tabla');
        usuarios.forEach(usuario =>{
            
            if(usuario.usDeshabilitado == null){
                usuario.usDeshabilitado = 'Activo';
            }


            const colorRoles = {
                1: "text-bg-success",
                2: "text-bg-primary",
                3: "text-bg-info",
                4: "text-bg-light",
                5: "text-bg-info",
            }

            let roles = ""
            if (usuario.roles.length == 0) {
                roles = `
            <span class="badge rounded-pill text-bg-danger">
            <i class='fa-solid fa-user-lock'></i> Sin roles asignados
            </span>
            `
            } else {
                roles = usuario.roles.map(rol => {
                    return `
            <span class="badge rounded-pill ${colorRoles[rol.rol.idRol]}">
            <i class='fa-solid fa-user-lock'></i> ${rol.rol.roDescripcion}
            </span>
            `
                }).join(" ");
            }





            const $usuario = $(`
            <tr>
                        <td>${usuario.idUsuario}</td>
                        <td>${usuario.usNombre}</td>
                        <td>${usuario.usMail}</td>
                        <td>${roles}</td>
                        <td>${usuario.usDeshabilitado}</td>
                        <td>
                            <a class="btn btn-outline-info m-2" role="button" href="modificar.php?accion=editar&idusuario=${usuario.idusuario}">editar</a>
                            <a class="btn btn-outline-danger m-2" role="button" href="modificar.php?accion=borrar&idusuario=${usuario.idusuario}">borrar</a>
                        </td>
                    </tr>
            `);
            contenedor.append($usuario);

        });

    }

    obtenerUsuarios().then(usuarios =>{
        console.log(usuarios);
        renderizarUsuarios(usuarios);
    })


})