const tabla = $('#tablamiscompras').DataTable({
    paging: false,
    language: {
        search: "Buscar en la tabla:",
        loadingRecords:"Cargando..."
    },
    ajax: {
        url: "./accion/me/misCompras.php",
        dataSrc: ""
    },
    columns: [{
            data: "idcompra"
        },
        {
            data: "cofecha"
        },
        {
            data: "cantitems"
        },
        {data: "estado"},
        {
            data: "total"
        },
        {
            data: "acciones"
        }
        
        
    ]
});


