<?php
include_once '../models/Lote.php';
session_name("agrocacao");
session_start();
$id_usuario = $_SESSION["usuario"];
$lote = new lote();


if ($_POST['funcion'] == 'datos_lote') {
    $json = array();
    $lote->dato_lote();
    foreach($lote->objetos as $objeto){
    	$json[] = array(
          'id_lote' => $objeto->id_lote,
          'nombre' => $objeto->nombre,
          'descripcion' => $objeto->descripcion,
          'latitud' => $objeto->latitud,
          'longitud' => $objeto->longitud,
          'estado_lote_id' => $objeto->estado_lote_id
        );
    }
    // Añade el encabezado para asegurar que la respuesta sea JSON
    header('Content-Type: application/json');
    echo json_encode(['data' => $json]);
    
}


if ($_POST['funcion'] == 'datos_lote_select') {
    $json = array();
    $lote->datos_lote_select();
    foreach($lote->objetos as $objeto){
    	$json[] = array(
          'id_lote' => $objeto->id_lote,
          'nombre' => $objeto->nombre,
          'descripcion' => $objeto->descripcion,
          'latitud' => $objeto->latitud,
          'longitud' => $objeto->longitud,
          'estado_lote_id' => $objeto->estado_lote_id
        );
    }
    // Añade el encabezado para asegurar que la respuesta sea JSON
    header('Content-Type: application/json');
    echo json_encode(['data' => $json]);
    
}


if ($_POST['funcion'] == 'un_lote') {
    $lote_id=$_POST['id_lote'];
    $json = array();
    $lote->un_lote($lote_id);
    foreach($lote->objetos as $objeto){
    	$json[] = array(
          'id_lote' => $objeto->id_lote,
          'nombre' => $objeto->nombre,
          'descripcion' => $objeto->descripcion,
          'latitud' => $objeto->latitud,
          'longitud' => $objeto->longitud,
          'estado_lote_id' => $objeto->estado_lote_id
        );
    }
    // Añade el encabezado para asegurar que la respuesta sea JSON
    header('Content-Type: application/json');
    echo json_encode(['data' => $json]);
    
}

if($_POST['funcion'] == 'habilitar'){
    $id_lote = $_POST['idLote'];
    $habilitar = 1;
	$resultado = $lote->habilitar($id_lote, $habilitar);
	echo $resultado;


}



if($_POST['funcion'] == 'deshabilitar'){
    $id_lote = $_POST['idLote'];
    $habilitar = 2;
	$resultado = $lote->deshabilitar($id_lote, $habilitar);
	echo $resultado;


}


if ($_POST['funcion'] == 'crear_lote') {
    
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    
    // Array de errores
    $errores = array();    
    
    // Validar el nombre
    if (empty($nombre)) {
        $errores['nombre-error'] = "El nombre no es válido"; 
    }
         
        
    // Si no hay errores, intentar crear el lote
    if (count($errores) == 0) {  
        $resultado = $lote->crear_lote($nombre, $descripcion, $latitud, $longitud);
        echo $resultado;
    } else {
        echo json_encode($errores);
    }


}


if ($_POST['funcion'] == 'datos_lote_id') {
        $id_lote = $_POST['id_lote'];
        $data = $lote->datos_lote_id($id_lote);
        // Enviar la respuesta como JSON
        echo json_encode($data);
    
}



if ($_POST['funcion'] == 'editar_lote') {
    $id_lote = $_POST['id_lote'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    
    // Array de errores
    $errores = array();    
    
    // Validar el nombre
    if (empty($nombre)) {
        $errores['nombre-error'] = "El nombre no es válido"; 
    }
         
        
    // Si no hay errores, intentar crear el lote
    if (count($errores) == 0) {  
        $resultado = $lote->editar_lote($id_lote, $nombre, $descripcion, $latitud, $longitud);
        echo $resultado;
    } else {
        echo json_encode($errores);
    }


}



