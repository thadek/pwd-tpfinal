<?php

include_once("../configuracion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $datos['accion'] = $_POST['accion'];

    if ($datos['accion'] === 'editar') {
        $datos['idrol'] = $_POST['idrol'];
        $datos['rodescripcion'] = $_POST['nuevo_nombre'];

        $abmRol = new ABMRol();
        $respuesta = $abmRol->abm($datos);

        if ($respuesta) {
            echo json_encode(['success' => true, 'msg' => 'Operación exitosa']);
            exit;
        } else {
            echo json_encode(['success' => false, 'msg' => 'Error al cambiar el rol']);
            exit;
        }
    }

    if ($datos['accion'] === 'borrar') {
        $datos['idrol'] = $_POST['idrol'];
        $abmRol = new ABMRol();
        $respuesta = $abmRol->baja($datos);

        if ($respuesta) {
            echo json_encode(['success' => true, 'msg' => 'Rol borrado con éxito']);
            exit;
        } else {
            echo json_encode(['success' => false, 'msg' => 'Error al borrar el rol']);
            exit;
        }
    }

    if ($datos['accion'] === 'nuevo') {
        $datos['rodescripcion'] = $_POST['nuevo_nombre'];
        $abmRol = new ABMRol();
        $respuesta = $abmRol->alta($datos);

        if ($respuesta) {
            echo json_encode(['success' => true, 'msg' => 'Rol agregado con éxito']);
            exit;
        } else {
            echo json_encode(['success' => false, 'msg' => 'Error al agregar el nuevo rol']);
            exit;
        }
    }
}

// Si la solicitud no es POST o no tiene la acción correcta, puedes devolver una respuesta de error
echo json_encode(['success' => false, 'msg' => 'Error en la solicitud']);
exit;

?>