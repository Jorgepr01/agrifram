<?php
include_once '../../models/Lote.php';
$lote = new lote();


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
?>
