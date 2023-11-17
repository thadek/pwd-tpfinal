$(document).ready(function(){

    obtenerUsuarios().then(usuarios =>{
        renderizarUsuarios(usuarios);
    });

});
    const renderizarUsuarios = (usuarios) =>{

        const contenedor = $('#tabla');

        let tabla = `<table class="table table-dark">
        <thhead>
        <tr>
        <th>ID Usuario</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Roles</th>
        <th>Estado</th>
        <th>Acciones</th>
        <th></th>
        </tr>
        </thhead>
        `





        usuarios.forEach(usuario =>{
            
            if(usuario.usDeshabilitado == null){
                usuario.usDeshabilitado = 'Habilitado';
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





            tabla+=`
            <tr>
            <td>${usuario.idUsuario}</td>
            <td>${usuario.usNombre}</td>
            <td>${usuario.usMail}</td>
            <td>${roles}</td>
            <td>${usuario.usDeshabilitado}</td>
            <td><button class="btn btn-outline-info m-2" onclick="modificarUsuario(${usuario.idUsuario})">Editar</button></td>
        </tr>
        `});

        tabla += `</table>`

        contenedor.html(tabla);


    }

    /*obtenerUsuarios().then(usuarios =>{
        renderizarUsuarios(usuarios);
    });*/


    

//});

const obtenerUsuarios = async () => {
    const respuesta = await fetch('http://localhost/pwd/pwd-tpfinal/vista/accion/usuario/accionListarUsuarios.php');
    const usuarios = await respuesta.json();
    return usuarios;
}


const obtenerUsuarioPorId = async (idUsuario) => {
    const response = await fetch(`http://localhost/pwd/pwd-tpfinal/vista/accion/usuario/accionListarUsuarios.php?idUsuario=${idUsuario}`);
    const usuario = await response.json();
    return usuario;

}



const modificarUsuario = async(idUsuario) => {
    const usuario =  obtenerUsuarioPorId(idUsuario);
    //const roles = usuario.roles.map((rol) => rol.roles.idRol);

    Swal.fire({
        title: 'Editar usuario',
        html:
          `<input id="usNombre" class="swal2-input" placeholder="Nombre" value="${usuario.usNombre || ''}">` +
          `<input id="usMail" class="swal2-input" placeholder="Email" value="${usuario.usMail || ''}">` +
          `<select id="roles" class="swal2-select" multiple>
                <option value="1" ${roles.includes(1) ? 'selected' : ''}>Admin</option>
                <option value="2" ${roles.includes(2) ? 'selected' : ''}>Cliente</option>
                <option value="3" ${roles.includes(3) ? 'selected' : ''}>Depósito</option>
                <!-- Agrega las opciones de roles restantes aquí -->
            </select>`+ 
          `<input id="usPass" type="password" class="swal2-input" placeholder="Contraseña" value="${usuario.usPass || ''}">` +
          `<select id="usDeshabilitado" class="swal2-select" placeholder="Deshabilitado">` +
          `<option value="true" ${usuario.usDeshabilitado ? 'selected' : ''}>Sí</option>` +
          `<option value="false" ${usuario.usDeshabilitado ? '' : 'selected'}>No</option>` +
          `</select>`,
        focusConfirm: false,
        preConfirm: () => {
          return {
            usNombre: document.getElementById('usNombre').value,
            usMail: document.getElementById('usMail').value,
            roles: document.getElementById('roles').value,
            usPass: document.getElementById('usPass').value,
            usDeshabilitado: document.getElementById('usDeshabilitado').value === 'true'
          };
        }
      });


  
      
}