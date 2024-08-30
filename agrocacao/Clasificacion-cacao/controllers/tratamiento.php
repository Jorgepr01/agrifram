<?php
include_once '../models/Tratamiento.php';
session_name("agrocacao");
session_start();
$id_usuario = $_SESSION["usuario"];
$tratamiento = new tratamiento();

if ($_POST['funcion'] == 'dato_estado_cacao') {
    $json = array();
    $tratamiento->estado_cacao($id_usuario);
    //$tratamiento->estado_cacao();
    foreach ($tratamiento->objetos as $objeto) {
        $json[] = array(
            'id_estado_cacao' => $objeto->id_estado_cacao,
            'nombre' => $objeto->nombre,
            'aplicar' => $objeto->aplicar,
            'dosis' => $objeto->dosis,
            'tiempo' => $objeto->tiempo,
            'aplicacion' => $objeto->aplicacion,
            'medida_manejo' => $objeto->medida_manejo,
        );
    }

    // Añade el encabezado para asegurar que la respuesta sea JSON
    header('Content-Type: application/json');
    echo json_encode(['data' => $json]);
}

if ($_POST['funcion'] == 'un_estado_cacao') {
   	$estado=$_POST['estado_id'];
    $json = array();
    $tratamiento->estado_cacao_id($estado);
    foreach ($tratamiento->objetos as $objeto) {
        $json[] = array(
            'id_estado_cacao' => $objeto->id_estado_cacao,
            'nombre' => $objeto->nombre,
            'aplicar' => $objeto->aplicar,
            'dosis' => $objeto->dosis,
            'tiempo' => $objeto->tiempo,
            'aplicacion' => $objeto->aplicacion,
            'medida_manejo' => $objeto->medida_manejo,
        );
    }

    // Añade el encabezado para asegurar que la respuesta sea JSON
    header('Content-Type: application/json');
    echo json_encode(['data' => $json]);
}

//TODO: cambiar avatar
if($_POST['funcion'] == 'tratamiento_id'){
   $id_estado_cacao = $_POST['id_estado_cacao'];
   $resultado = $tratamiento->estado_cacao_id($id_estado_cacao);
   
   if ($resultado) {
      echo json_encode($resultado);
   } else {
      echo json_encode(['error' => 'No se encontraron datos']);
   }
}


if ($_POST['funcion'] == 'editar') {
    // Recibir datos del formulario
    $id = $_POST['id']; // Asegúrate de que el nombre del campo coincida con el que estás enviando desde el formulario
    $nombre = $_POST['nombre'];
    $aplicar = $_POST['aplicar'];
    $dosis = $_POST['dosis'];
    $tiempo = $_POST['tiempo'];
    $aplicacion = $_POST['aplicacion'];
    $med_mane = $_POST['med_mane'];
    
    // Ejecutar el método editar del modelo $tratamiento
    $resultado = $tratamiento->editar($id, $nombre, $aplicar, $dosis, $tiempo, $aplicacion, $med_mane);
    
    // Devolver el resultado de la operación
    echo $resultado;
}