<?php
include_once '../models/Reporte.php';
session_name("agrocacao");
session_start();
$id_usuario = $_SESSION["usuario"];
$tipo = $_SESSION["us_tipo"];
$reporte = new reporte();

if ($_POST['funcion'] == 'dt_escaneo_lote') {
    $lote_id = $_POST['lote_id'];

    // Lógica para manejar el ID del lote y devolver los escaneos
    $escaneos = $reporte->obtenerDatosPorLote($lote_id);

    if ($escaneos) {
    	echo json_encode($escaneos);
	} else {
    	echo json_encode([]);
	}
}

if ($_POST['funcion'] == 'cargar_tabla') {
    
	$lote_id = isset($_POST['lote_id']) ? $_POST['lote_id'] : '';
    $escaneo_id = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    // Lógica para manejar el ID del lote y devolver los escaneos
    $escaneos = $reporte->cargarTabla($lote_id, $escaneo_id);

    
   	echo json_encode($escaneos);
	
}

if ($_POST['funcion'] == 'loteEstados') {
    // Obtener el ID del lote, si está presente, de lo contrario, asignar null
    $lote_id = isset($_POST['lote_id']) ? $_POST['lote_id'] : null;

    // Llamar a la función del modelo con el lote_id
    $escaneos = $reporte->loteEstados($lote_id);

    // Devolver los datos en formato JSON
    echo json_encode($escaneos);
}


if ($_POST['funcion'] == 'datos_lote') {
    $lote = $reporte->datosLote();

    if ($lote) {
        echo json_encode(['data' => $lote]); // Envolver en 'data'
    } else {
        echo json_encode(['data' => []]); // Envolver en 'data'
    }
}

if($_POST['funcion'] == "avanceEnfermedad"){
        
    $selectedEscaneoId = isset($_POST['selectedEscaneo']) ? $_POST['selectedEscaneo'] : null;
        
	$respuesta = $reporte->avanceEnfermedad($selectedEscaneoId);
	
            
   echo json_encode($respuesta); // Envolver en 'data'
    
}

?>
