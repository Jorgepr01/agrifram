<?php
include_once '../../models/seguimiento.php';
// if ($_POST["funcion"] == "seguimiento") {
$id_usuario=$_POST['user_id'];
$usuario = new usuario();
$json = array();
$usuario->seguimiento_tras_movil($id_usuario);

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
echo json_encode($json);

?>



