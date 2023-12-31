

$(document).ready(function () {

    $("#status").hide();

    











    obtenerMenus().then(menus => {
        renderizarMenus(menus);
    });






});

const renderizarMenus = (menus) => {

    const divMenu = $("#gestionmenu");

    let tabla = `<table class="table table-dark">
<thhead>
<tr>
<th>ID Menu</th>
<th>Nombre</th>
<th>Descripcion</th>
<th>Padre</th>
<th>Link</th>
<th>Estado</th>
<th>Roles Autorizados a visualizar</th>
<th>Acciones</th>
<th></th>

</tr>
</thhead>
`




    menus.forEach(menu => {

        if (menu.padre == null) {
            menu.padre = "Sin padre"
        } else {
            menu.padre = `${menu.padre.idMenu} - ${menu.padre.meNombre}`
        }

        if (menu.meDeshabilitado == null) {
            menu.meDeshabilitado = "Habilitado"
        }

        const colorRoles = {
            1: "text-bg-success",
            2: "text-bg-primary",
            3: "text-bg-info",
            4: "text-bg-light",
            5: "text-bg-info",
        }

        let roles = ""
        if (menu.roles.length == 0) {
            roles = `
        <span class="badge rounded-pill text-bg-danger">
        <i class='fa-solid fa-user-lock'></i> Sin roles asignados
        </span>
        `
        } else {
            roles = menu.roles.map(rol => {
                return `
        <span class="badge rounded-pill ${colorRoles[rol.idRol]}">
        <i class='fa-solid fa-user-lock'></i> ${rol.roDescripcion}
        </span>
        `
            }).join(" ");
        }


        tabla += `<tr>
    <td>${menu.idMenu}</td>
    <td>${menu.meNombre}</td>
    <td>${menu.meDescripcion}</td>
    <td>${menu.padre}</td>
    <td>${menu.link}</td>
    <td>${menu.meDeshabilitado}</td>
    <td>${roles}</td>
    <td><button class="btn btn-light" onclick="modificarMenu(${menu.idMenu})">Modificar</button></td>
    <td><button class="btn btn-danger" onclick="eliminarMenu(${menu.idMenu})">Eliminar</button></td>
    </tr>`
    })



    tabla += `</table>`

    divMenu.html(tabla);
}







 








const obtenerMenus = async () => {
    const response = await fetch('http://localhost/pwd/pwd-tpfinal/vista/accion/menu/listar.php');
    const menus = await response.json();
    return menus;
}

const obtenerMenuPorId = async (idMenu) => {
    const response = await fetch(`http://localhost/pwd/pwd-tpfinal/vista/accion/menu/listar.php?idMenu=${idMenu}`);
    const menu = await response.json();
    return menu;
}

async function modificarMenu(idMenu) {
    const menu = await obtenerMenuPorId(idMenu);
    const menus = await obtenerMenus();

    $("#titulo_modal").html("Modificar menú");
    $("#accion").val("modificar");
    $("#idMenu").val(menu.idMenu);
    $("#meNombre").val(menu.meNombre);
    $("#meDescripcion").val(menu.meDescripcion);
    // Limpiar y generar dinámicamente las opciones del menú padre
    const selectPadre = $("#padre");
    selectPadre.empty(); // Limpiar opciones anteriores

    // Agregar la opción vacía al principio
    selectPadre.append('<option value="-1"></option>');

    // Generar opciones de menú dinámicamente
    // Puedes obtener la lista de menús disponibles y agregar opciones aquí
    // Por ejemplo, asumiendo que tienes una lista de menús en la variable 'menus'
    menus.forEach((menu) => {
        selectPadre.append(`<option value="${menu.idMenu}">${menu.meNombre}</option>`);
    });

    // Seleccionar el menú padre correspondiente
    if (menu.padre != null) {
        selectPadre.val(menu.padre.idMenu)
    };


    $("#link").val(menu.link);
    $("#meDeshabilitado").val(menu.meDeshabilitado);

    $("#modal").modal("show");
}

async function guardarCambios() {

    const accion = $("#accion").val();
    const idMenu = $("#idMenu").val();
    const meNombre = $("#meNombre").val();
    const meDescripcion = $("#meDescripcion").val();
    const padre = $("#padre").val();
    const link = $("#link").val();
    const meDeshabilitado = $("#meDeshabilitado").is(":checked");

    

    const span = $("#status").fadeIn(500);
    

    $.ajax({
        type: "POST",
        url: "accion/menu/modificacion.php",
        data: {
            idMenu: idMenu,
            accion: accion,
            meNombre: meNombre,
            meDescripcion: meDescripcion,
            padre: padre,
            link: link,
            meDeshabilitado: meDeshabilitado
        },
        success: function (response) {
            // Manejar la respuesta del servidor, si es necesario
            console.log(response);
            // Actualizar la tabla después del éxito
            actualizarTabla();
            // O cerrar el modal u realizar otras acciones si es necesario
            $("#modal").modal("hide");
        },
        error: function (error) {
            console.error("Error al guardar los datos:", error);
        }
    });

}

async function actualizarTabla() {
    const menus = await obtenerMenus();
    renderizarMenus(menus);
}

obtenerMenus().then(menus => {
    renderizarMenus(menus);
});
