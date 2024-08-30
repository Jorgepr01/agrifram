<?php
include_once '../../models/Seguimiento.php';
$usuario = new usuario();

$usuario->seguimiento_admin();

// Verificar si se obtuvieron datos
if ($usuario->objetos) {
    // Salida de cada fila de datos
    foreach($usuario->objetos as $row) {
        $json[] = $row;
    }
} else {
    $json = array("result" => "0 results");
}

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode(array("data" => $json));

?>







