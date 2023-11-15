$(document).ready(function(){

    const obtenerUsuarios = async () => {
        //const url ='../vista/verUsuario.php';
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
            const $usuario = $(`
            <tr>
                        <td>${usuario.idUsuario}</td>
                        <td>${usuario.usNombre}</td>
                        <td>${usuario.usMail}</td>
                        <td>${usuario.usRol}</td>
                        <td>${usuario.usDeshabilitado}</td>
                        <td>
                            <a class="btn btn-outline-info m-2" role="button" href="modificar.php?accion=editar&idusuario=${usuario.idusuario}">Editar</a>
                            <a class="btn btn-outline-danger m-2" role="button" href="modificar.php?accion=borrar&idusuario=${usuario.idusuario}">Borrar</a>
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