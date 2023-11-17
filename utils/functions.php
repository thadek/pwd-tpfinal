<?php


function darDatosSubmitted(){
    $datos = [];
    //piso el array de datos con los datos que vienen por POST para darles prioridad
    foreach($_GET as $key => $value){
        $datos[$key] = $value;
    }
    foreach($_POST as $key => $value){
        $datos[$key] = $value;
    }
    

    return $datos;
}

 

spl_autoload_register(function ($class_name) {

    //echo "class ".$class_name ;
    $directorys = array(
        $_SERVER['ROOT'].'/modelo/',
        $_SERVER['ROOT'].'/modelo/conector/',
        $_SERVER['ROOT'].'/control/',
        
      //  $GLOBALS['ROOT'].'util/class/',
    );

    //print_object($directorys) ;
 
    foreach($directorys as $directory){
        if(file_exists($directory.$class_name . '.php')){
            // echo "se incluyo".$directory.$class_name . '.php';
            require_once($directory.$class_name . '.php');
            return;
        }
    }

    
});


function renderBotonesAcciones($id){
    $html = '
    <div class="btn btn-outline-info m-2" onclick="editarProducto('.$id.')"> Modificar</div>
    <div class="btn btn-outline-danger m-2" onclick="borrarProducto('.$id.')"> Borrar </div>
    ';
    return $html;
}


function renderBotonesAccionesCompra($id){
    $html = '
    <a class="btn btn-outline-info m-2" href="./detalleCompra.php?id='.$id.'"> Ver detalle compra</a>
    ';
    return $html;
}