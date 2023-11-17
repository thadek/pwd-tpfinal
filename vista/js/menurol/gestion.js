const tabla = $('#tablamenus').DataTable({
    paging: false,
    ajax: {
        url: "./accion/menurol/listar.php",
        dataSrc: ""
    },
    columns: [
        {data: "menu.idMenu"},
        {
            data: "menu.meNombre"
        },
        {
            data: "rol.roDescripcion"
        },
       
    ]
});