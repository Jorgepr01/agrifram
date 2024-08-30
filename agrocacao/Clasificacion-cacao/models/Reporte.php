<?php
include_once 'Conexion.php';

class reporte
{
    var $objetos;
    private $acceso;
    
    public function __construct()
    {
        $db = new conexion();
        $this->acceso = $db->pdo;
    }
    
    public function obtenerDatosPorLote($lote_id)
	{
    try {
        $sql = "SELECT * FROM escaneo_cacao WHERE lote_id = :lote_id;";
        $stmt = $this->acceso->prepare($sql);
        $stmt->bindParam(':lote_id', $lote_id);
        $stmt->execute();
        $resultados = $stmt->fetchAll(); // Asegúrate de usar el fetch correcto
        return $resultados;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return null;
    }
	}
        
  function datosLote() {
        // Consulta SQL
        $sql = "SELECT * FROM lote";
        $query = $this->acceso->prepare($sql);
        
        if ($query->execute()) {
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        } else {
            return null; 
        }
    }
        
  public function cargarTabla($lote_id, $escaneo_id)
	{
    try {
        // Consulta SQL base
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
WHERE es_cacao.estado_cacao_id != 4";
        
        // Agregar condiciones opcionales
        if (!empty($lote_id)) {
            $sql .= " AND es_cacao.lote_id = :lote_id";
        }
        
        if (!empty($escaneo_id)) {
            $sql .= " AND es_cacao.id_escaneo = :escaneo_id";
        }
        
        $sql .= " ORDER BY es_cacao.id_escaneo DESC;";

        // Preparar la declaración
        $stmt = $this->acceso->prepare($sql);

        // Enlazar parámetros si son proporcionados
        if (!empty($lote_id)) {
            $stmt->bindParam(':lote_id', $lote_id);
        }
        if (!empty($escaneo_id)) {
            $stmt->bindParam(':escaneo_id', $escaneo_id);
        }

        // Ejecutar la declaración
        $stmt->execute();

        // Obtener los resultados
        $resultados = $stmt->fetchAll();

        return $resultados;
    } catch (PDOException $e) {
        // Registrar el error
        error_log($e->getMessage());
        return null;
    }
	}

        
        
  function loteEstados($lote_id = null) {
    // Consulta SQL con o sin filtro por lote_id
    $sql = "SELECT lo.nombre, lote_id, COUNT(*) AS cantidad
			FROM escaneo_cacao AS es_cacao
			INNER JOIN lote AS lo ON lo.id_lote = es_cacao.lote_id 
			GROUP BY lote_id;";
	
          
    $query = $this->acceso->prepare($sql);

    // Si se pasa un lote_id, se binda como parámetro
    //if ($lote_id) {
        //$query->bindParam(':lote_id', $lote_id, PDO::PARAM_INT);
    //}

    // Ejecutar la consulta y devolver los resultados
    if ($query->execute()) {
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    } else {
        return null; 
    }
	}

	function avanceEnfermedad($selectedEscaneoId) {
    try {
        // Verifica si se ha proporcionado un id_escaneo
        if (empty($selectedEscaneoId)) {
            $sql = "SELECT 
    e.id_escaneo,
    e.escaneo,
    e.fecha_escaneo AS fecha, 
    e.porcentaje_escaneo AS porcentaje, 
    e.estado_cacao_id AS estado_id, 
    es_inicial.nombre AS nombre_estado,
    'Escaneo Inicial' AS tipo_evento
FROM 
    escaneo_cacao e
JOIN 
    estado_cacao es_inicial ON e.estado_cacao_id = es_inicial.id_estado_cacao
WHERE 
    e.estado_cacao_id != 4

UNION ALL

SELECT 
    t.escaneo_id AS id_escaneo, 
    NULL AS escaneo,
    t.fecha_trazabilidad AS fecha, 
    t.porcentaje_trazabilidad AS porcentaje, 
    t.estado_cacao_id AS estado_id, 
    es_seguimiento.nombre AS nombre_estado,
    'Trazabilidad' AS tipo_evento
FROM 
    trazabilidad t
JOIN 
    estado_cacao es_seguimiento ON t.estado_cacao_id = es_seguimiento.id_estado_cacao
WHERE 
    t.estado_cacao_id != 4

ORDER BY 
    id_escaneo, fecha;
";
        } else {
            $sql = "SELECT 
                        e.id_escaneo, 
                        e.fecha_escaneo AS fecha, 
                        e.porcentaje_escaneo AS porcentaje, 
                        e.estado_cacao_id AS estado_id, 
                        es_inicial.nombre AS nombre_estado,
                        'Escaneo Inicial' AS tipo_evento
                    FROM 
                        escaneo_cacao e
                    JOIN 
                        estado_cacao es_inicial ON e.estado_cacao_id = es_inicial.id_estado_cacao
                    WHERE 
                        e.id_escaneo = :selectedEscaneoId AND e.estado_cacao_id != 4

                    UNION ALL

                    SELECT 
                        t.escaneo_id AS id_escaneo, 
                        t.fecha_trazabilidad AS fecha, 
                        t.porcentaje_trazabilidad AS porcentaje, 
                        t.estado_cacao_id AS estado_id, 
                        es_seguimiento.nombre AS nombre_estado,
                        'Trazabilidad' AS tipo_evento
                    FROM 
                        trazabilidad t
                    JOIN 
                        estado_cacao es_seguimiento ON t.estado_cacao_id = es_seguimiento.id_estado_cacao
                    WHERE 
                        t.escaneo_id = :selectedEscaneoId AND t.estado_cacao_id != 4

                    ORDER BY 
                        id_escaneo, fecha;";
        }

        // Preparar la declaración
        $stmt = $this->acceso->prepare($sql);

        // Si hay un id_escaneo, enlazar el parámetro
        if (!empty($selectedEscaneoId)) {
            $stmt->bindParam(':selectedEscaneoId', $selectedEscaneoId, PDO::PARAM_INT);
        }

        // Ejecutar la declaración
        $stmt->execute();

        // Obtener los resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    } catch (PDOException $e) {
        // Registrar el error
        error_log($e->getMessage());
        return null;
    }
}


            


}
?>
