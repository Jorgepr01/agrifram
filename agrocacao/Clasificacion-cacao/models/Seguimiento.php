<?php
date_default_timezone_set('America/Guayaquil');
include_once 'Conexion.php';

class usuario {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new conexion();
        $this->acceso = $db->pdo;
    }
	
    //admin
    function seguimiento_admin() {
        // Consulta SQL
        $sql = "SELECT es_cacao.id_escaneo, 
       es_cacao.escaneo, 
       es_cacao.estado_cacao_id AS estado_cacao_escaneo, 
       est_cacao.nombre AS nombre_estado_cacao_escaneo,
       es_cacao.porcentaje_escaneo,
       es_cacao.fecha_escaneo,
       es_cacao.imgen_escaneo,
       es_cacao.lote_id,
       lo.nombre AS nombre_lote,
       es_cacao.us_id, 
       trata.*   
    FROM escaneo_cacao AS es_cacao 
           LEFT JOIN (
    SELECT t1.id_trazabilidad, 
	   t1.escaneo_id, 
	   t1.trazabilidad, 
	   t1.estado_cacao_id AS estado_cacao_trazabilidad,
	   t1.porcentaje_trazabilidad,
	   t1.fecha_trazabilidad,
	   t1.imagen_trazabilidad,
	   t1.observacion,
	   est_cacao_actual.nombre AS nombre_estado_cacao_trazabilidad
    FROM trazabilidad t1
    INNER JOIN (
        SELECT escaneo_id, MAX(fecha_trazabilidad) AS ultima_fecha_trasa
        FROM trazabilidad
        GROUP BY escaneo_id
    ) t2
    ON t1.escaneo_id = t2.escaneo_id AND t1.fecha_trazabilidad = t2.ultima_fecha_trasa
    LEFT JOIN estado_cacao AS est_cacao_actual
    ON t1.estado_cacao_id = est_cacao_actual.id_estado_cacao
) AS trata
ON es_cacao.id_escaneo = trata.escaneo_id
INNER JOIN lote AS lo ON lo.id_lote = es_cacao.lote_id 
INNER JOIN estado_cacao AS est_cacao ON est_cacao.id_estado_cacao = es_cacao.estado_cacao_id  
WHERE es_cacao.estado_cacao_id != 4
ORDER BY es_cacao.id_escaneo DESC;";
        $query = $this->acceso->prepare($sql);
        
        if ($query->execute()) {
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        } else {
            return null; // o alguna otra forma de manejar el error
        }
    }
        
    //agricultor
    function seguimiento($id_usuario) {
        // Consulta SQL
        $sql = "SELECT es_cacao.id_escaneo, 
       es_cacao.escaneo, 
       es_cacao.estado_cacao_id AS estado_cacao_escaneo, 
       est_cacao.nombre AS nombre_estado_cacao_escaneo,
       es_cacao.porcentaje_escaneo,
       es_cacao.fecha_escaneo,
       es_cacao.imgen_escaneo,
       es_cacao.lote_id,
       lo.nombre AS nombre_lote,
       es_cacao.us_id, 
       trata.*   
    FROM escaneo_cacao AS es_cacao 
           LEFT JOIN (
    SELECT t1.id_trazabilidad, 
	   t1.escaneo_id, 
	   t1.trazabilidad, 
	   t1.estado_cacao_id AS estado_cacao_trazabilidad,
	   t1.porcentaje_trazabilidad,
	   t1.fecha_trazabilidad,
	   t1.imagen_trazabilidad,
	   t1.observacion,
	   est_cacao_actual.nombre AS nombre_estado_cacao_trazabilidad
    FROM trazabilidad t1
    INNER JOIN (
        SELECT escaneo_id, MAX(fecha_trazabilidad) AS ultima_fecha_trasa
        FROM trazabilidad
        GROUP BY escaneo_id
    ) t2
    ON t1.escaneo_id = t2.escaneo_id AND t1.fecha_trazabilidad = t2.ultima_fecha_trasa
    LEFT JOIN estado_cacao AS est_cacao_actual
    ON t1.estado_cacao_id = est_cacao_actual.id_estado_cacao
) AS trata
ON es_cacao.id_escaneo = trata.escaneo_id
INNER JOIN lote AS lo ON lo.id_lote = es_cacao.lote_id 
INNER JOIN estado_cacao AS est_cacao ON est_cacao.id_estado_cacao = es_cacao.estado_cacao_id 
            WHERE es_cacao.us_id = :id AND es_cacao.estado_cacao_id != 4
            ORDER BY es_cacao.id_escaneo DESC;";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id_usuario));
        
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }
     function seguimiento_tras_movil($id_usuario) {
        // Consulta SQL
        $sql = "SELECT es_cacao.*, trata.* 
            FROM escaneo_cacao AS es_cacao 
            LEFT JOIN (
                SELECT id_escaneo AS id_escaneo_trazabilidad, 
                       MAX(fecha_trazabilidad) AS ultima_fecha_trasa, 
                       trazabilidad, 
                       estado_escaneo_id AS trasa_estado_escaneo_id, 
                       porcentaje_trazabilidad, 
                       fecha_trazabilidad, 
                       imagen_trazabilidad, 
                       observacion 
                FROM trazabilidad 
                GROUP BY id_escaneo 
            ) AS trata 
            ON es_cacao.id_escaneo = trata.id_escaneo_trazabilidad
            WHERE es_cacao.us_id = :id AND es_cacao.estado_escaneo_id != 4 AND es_cacao.estado_escaneo_id != 3
            ORDER BY es_cacao.id_escaneo DESC;";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id_usuario));
        
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }
}
?>
