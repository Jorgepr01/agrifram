<?php
include_once '../models/Seguimiento.php';
session_name("agrocacao");
session_start();
$id_usuario = $_SESSION["usuario"];
$usuario = new usuario();

$na = $_SESSION;
$tipo = $_SESSION["us_tipo"];



if($tipo==1){
$usuario->seguimiento_admin();
}else{
$usuario->seguimiento($id_usuario);
}

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



