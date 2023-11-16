

$(document).ready(function () {

    $("#status").hide();

    



    const renderizarMenus = (menus) => {

        const divMenu = $("#gestionmenu");

     

        let tabla = `<table class="table table-dark ">
    <thead>
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
    </thead>
    `
        menus.forEach(menu => {


            let botonBorrar = ``;
            
            
    

             
            if (menu.padre != null) {
               
                botonBorrar += `<button class="btn btn-danger" type="button" disabled> Tiene padre</button>`
                
                menu.padre = `${menu.padre.idMenu} - ${menu.padre.meNombre}`
            } else {
                botonBorrar = `<button class="btn btn-danger" onclick="eliminarMenu(${menu.idMenu})">Eliminar</button>`
                menu.padre = "Sin padre"
               
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
        <td>${botonBorrar}</td>
        
        </tr>`
        })

        tabla += `</table>`

        divMenu.html(tabla);
    }







    obtenerMenus().then(menus => {
        renderizarMenus(menus);
    }).catch(error=>{
        $("#gestionmenu").html("Error al cargar los menus");
    });






});




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
    selectPadre.append('<option value=""></option>');

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
    

    const menu = {
        idMenu,
        accion,
        meNombre,
        meDescripcion,
        padre,
        link,
        meDeshabilitado
    }





}