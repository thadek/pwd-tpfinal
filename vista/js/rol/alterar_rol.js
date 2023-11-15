$(document).ready(function () {
    // Evento para el botón "Nuevo"
    $("#btn-nuevo").click(function () {
        $(this).hide();
        $("#nuevo-rol-container").show();
    });

    $("#btn-aplicar-nuevo").click(function () {
        var nuevoRol = $("#input-nuevo-rol").val();

        // Realizar la solicitud Ajax para agregar el nuevo rol
        $.ajax({
            type: "POST",
            url: "editarRol.php", // Ajusta la URL según tu estructura de archivos
            data: { accion: "nuevo", nuevo_nombre: nuevoRol },
            dataType: "json",
            success: function (response) {
                // Manejar la respuesta del servidor
                if (response.success) {
                    // Agregar visualmente el nuevo rol a la lista
                    var newRow = $("<tr>");
                    newRow.append("<td>" + response.idRol + "</td>");
                    newRow.append("<td><span class='nombre-rol'>" + nuevoRol + "</span><input type='text' class='form-control input-nombre-rol' style='display: none;'></td>");
                    newRow.append("<td><button class='btn btn-info btn-editar' data-id='" + response.idRol + "'>Editar</button><button class='btn btn-danger btn-borrar' data-id='" + response.idRol + "'>Borrar</button><button class='btn btn-success btn-aplicar' data-id='" + response.idRol + "' style='display: none;'>Aplicar</button></td>");

                    $("#tabla-roles tbody").append(newRow);
                    alert("Rol agregado con éxito a la lista y la base de datos");
                } else {
                    alert("Error al agregar el nuevo rol");
                }
            },
            error: function () {
                alert("Error de conexión al servidor.");
            },
        });

        // Mostrar nuevamente el botón "Nuevo"
        $("#btn-nuevo").show();
        // Ocultar el área del nuevo rol después de aplicar
        $("#nuevo-rol-container").hide();
        // Limpiar el valor del input del nuevo rol
        $("#input-nuevo-rol").val("");
    });

    // Evento para los botones "Editar"
    $(".btn-editar").click(function () {
        var nombreRolElement = $(this).closest("tr").find(".nombre-rol");
        var inputNombreRolElement = $(this).closest("tr").find(".input-nombre-rol");
        var btnEditarElement = $(this);
        var btnAplicarElement = $(this).closest("tr").find(".btn-aplicar");

        // Mostrar el campo de entrada y ocultar el nombre
        nombreRolElement.hide();
        inputNombreRolElement.show();

        // Cambiar texto del botón y mostrar el botón "Aplicar"
        btnEditarElement.hide();
        btnAplicarElement.show();
    });

    // Evento para el botón "Aplicar"
    $(".btn-aplicar").click(function () {
        var idRol = $(this).data("id");
        var nuevoNombre = $(this).closest("tr").find(".input-nombre-rol").val();
        var nombreRolElement = $(this).closest("tr").find(".nombre-rol");
        var inputNombreRolElement = $(this).closest("tr").find(".input-nombre-rol");
        var btnEditarElement = $(this).closest("tr").find(".btn-editar");
        var btnAplicarElement = $(this);

        // Enviar datos al servidor para la actualización con AJAX
        $.ajax({
            type: "POST",
            url: "editarRol.php", // Ajusta la URL según tu estructura de archivos
            data: { accion: "editar", idrol: idRol, nuevo_nombre: nuevoNombre },
            dataType: "json",
            success: function (response) {
                // Manejar la respuesta del servidor (puede mostrar un mensaje, etc.)
                if (response.success) {
                    alert("Cambio realizado con éxito");

                    // Ocultar el campo de entrada y mostrar el nombre
                    nombreRolElement.text(nuevoNombre);
                    nombreRolElement.show();
                    inputNombreRolElement.hide();

                    // Cambiar texto del botón y ocultar el botón "Aplicar"
                    btnEditarElement.show();
                    btnAplicarElement.hide();

                } else {
                    alert("Error al cambiar el rol");

                    nombreRolElement.show();
                    inputNombreRolElement.hide();

                    btnEditarElement.show();
                    btnAplicarElement.hide();

                }
            },
            error: function (xhr, status, error) {
                console.log("XHR:", xhr);
                console.log("Status:", status);
                console.log("Error:", error);
        
                // Muestra un mensaje de alerta genérico
                alert("Error de conexión al servidor.");
        
                // Intenta parsear la respuesta como JSON e imprímela en la consola
                try {
                    var jsonResponse = JSON.parse(xhr.responseText);
                    console.log("JSON Response:", jsonResponse);
                } catch (e) {
                    console.log("No se pudo analizar la respuesta como JSON.");
                }
            },
        });
    });

    $(".btn-borrar").click(function () {
        var idRol = $(this).data("id");
    
        // Confirmar si realmente quieres borrar el rol
        var confirmacion = confirm("¿Estás seguro de que deseas borrar este rol?");
    
        if (confirmacion) {
            // Almacenar el contexto actual
            var self = this;
    
            // Realizar la solicitud Ajax para borrar el rol
            $.ajax({
                type: "POST",
                url: "editarRol.php",
                data: { accion: "borrar", idrol: idRol },
                dataType: "json",
                success: function (response) {
                    // Manejar la respuesta del servidor
                    if (response.success) {
                        // Borrar visualmente el rol de la lista
                        $(self).closest("tr").remove();
                        alert("Rol borrado con éxito de la lista y la base de datos");
                    } else {
                        alert("Error al borrar el rol");
                    }
                },
                error: function () {
                    alert("Error de conexión al servidor.");
                },
            });
        }
    });
    
});