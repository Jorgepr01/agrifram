<?php
include_once '../../models/Tratamiento.php';
$tratamiento = new tratamiento();
    $json = array();
    $tratamiento->estado_cacao();
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