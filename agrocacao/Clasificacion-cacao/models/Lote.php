<?php
include_once 'Conexion.php';

class lote {
    var $objetos;
    private $acceso;

    public function __construct() {
        $db = new conexion();
        $this->acceso = $db->pdo;
    }
	
    //admin
    function dato_lote() {
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
   	
    function datos_lote_select() {
        // Consulta SQL
        $sql = "SELECT * FROM lote WHERE estado_lote_id = 1";
        $query = $this->acceso->prepare($sql);
        
        if ($query->execute()) {
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        } else {
            return null; 
        }
    }

        function un_lote($id_lote) {
                // Consulta SQL
                $sql = "SELECT * FROM lote id_estado_cacao = :id_lote";
                $query = $this->acceso->prepare($sql);
                $stmt->bindParam(':id_lote', $id_lote);

                if ($query->execute()) {
                        $this->objetos = $query->fetchAll();
                        return $this->objetos;
                } else {
                        return null; 
                }
        }
        
	function habilitar($id_lote, $habilitar) {
        try {
            $sql = 'UPDATE lote SET estado_lote_id = :habilitar WHERE id_lote = :id_lote';
            $stmt = $this->acceso->prepare($sql);
            // Bind parameters
            $stmt->bindParam(':id_lote', $id_lote);
            $stmt->bindParam(':habilitar', $habilitar);
            // Ejecutar consulta
            $stmt->execute();
            return "habilitado";
        } catch (PDOException $e) {
            error_log('Error: ' . $e->getMessage());
            return null; // Devuelve null en caso de error
        }
    }
        
        
   	function deshabilitar($id_lote, $habilitar) {
        try {
            $sql = 'UPDATE lote SET estado_lote_id = :habilitar WHERE id_lote = :id_lote';
            $stmt = $this->acceso->prepare($sql);
            // Bind parameters
            $stmt->bindParam(':id_lote', $id_lote);
            $stmt->bindParam(':habilitar', $habilitar);
            // Ejecutar consulta
            $stmt->execute();
            return "deshabilitado";
        } catch (PDOException $e) {
            error_log('Error: ' . $e->getMessage());
            return null; // Devuelve null en caso de error
        }
    }
        
        
   function crear_lote($nombre, $descripcion, $latitud, $longitud) {
    try {
        // Preparar la consulta SQL
        $sql = 'INSERT INTO lote (nombre, descripcion, latitud, longitud, estado_lote_id) 
                VALUES (:nombre, :descripcion, :latitud, :longitud, 1)';
        $stmt = $this->acceso->prepare($sql);

        // Enlazar parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':latitud', $latitud);
        $stmt->bindParam(':longitud', $longitud);

        // Ejecutar consulta
        $stmt->execute();

        // Devolver éxito
        return "add";

    } catch (PDOException $e) {
        // Registrar el error
        error_log('Error: ' . $e->getMessage());

        // Devolver null en caso de error
        return null;
    }
  }
        
        
  function datos_lote_id($id_lote) {
        try {
            // Consulta SQL filtrada por ID
            $sql = "SELECT * FROM lote WHERE id_lote = :id";
            $query = $this->acceso->prepare($sql);
            $query->bindParam(':id', $id_lote);

            if ($query->execute()) {
                $this->objetos = $query->fetch();
                return $this->objetos;
            } else {
                return null;
            }
        } catch (Exception $e) {
            // En caso de error, retornar un mensaje JSON con el error
            return array('error' => $e->getMessage());
        }
    }
        
        
   function editar_lote($id_lote, $nombre, $descripcion, $latitud, $longitud) {
        try {
            // Preparar la consulta SQL para actualizar
            $sql = 'UPDATE lote 
                    SET nombre = :nombre, descripcion = :descripcion, latitud = :latitud, longitud = :longitud 
                    WHERE id_lote = :id';
            $stmt = $this->acceso->prepare($sql);

            // Enlazar parámetros
            $stmt->bindParam(':id', $id_lote, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':latitud', $latitud);
            $stmt->bindParam(':longitud', $longitud);

            // Ejecutar consulta
            $stmt->execute();

            // Devolver éxito
            echo "edit";

        } catch (PDOException $e) {
            // Registrar el error
            error_log('Error: ' . $e->getMessage());
            return null;
        }
    }
        
    
}