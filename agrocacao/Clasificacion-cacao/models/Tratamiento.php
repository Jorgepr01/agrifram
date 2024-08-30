<?php
include_once 'Conexion.php';

class tratamiento
{
  var $objetos;
  private $acceso;
  
  public function __construct()
  {
    $db = new conexion();
    $this->acceso = $db->pdo;
  }
        
  function estado_cacao()
  {
    try {
      $sql = "SELECT * FROM estado_cacao WHERE id_estado_cacao != 4";
      $query = $this->acceso->prepare($sql);
      $query->execute();
      $this->objetos = $query->fetchAll();
      return $this->objetos;
    } catch (PDOException $e) {
      // Manejar cualquier excepción de PDO (por ejemplo, errores de consulta)
      error_log($e->getMessage());
      return null;
    }
  }
        
	public function estado_cacao_id($id) {
    	try {
        	$sql = "SELECT * FROM estado_cacao WHERE id_estado_cacao = :id";
        	$query = $this->acceso->prepare($sql);
        	$query->execute([':id' => $id]);
        	$this->objetos = $query->fetchAll(); 
        	return $this->objetos;
    	} catch (PDOException $e) {
        	error_log($e->getMessage());
        	return null;
    	}
	}
        
        
   function editar($id, $nombre, $aplicar, $dosis, $tiempo, $aplicacion, $med_mane) {
    // Preparar la consulta SQL para actualizar el tratamiento
    $sql = "UPDATE estado_cacao SET 
                nombre = :nombre,  
                aplicar = :aplicar, 
                dosis = :dosis, 
                tiempo = :tiempo, 
                aplicacion = :aplicacion,
                medida_manejo = :med_name
            WHERE id_estado_cacao = :id";
    
    // Ejecutar la consulta con los parámetros recibidos
    $stmt = $this->acceso->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':aplicar', $aplicar);
    $stmt->bindParam(':dosis', $dosis);
    $stmt->bindParam(':tiempo', $tiempo);
    $stmt->bindParam(':aplicacion', $aplicacion);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':med_name', $med_mane);
    
    // Execute the statement
    if ($stmt->execute()) {
        return "update";
    } else {
        return "error: " . $stmt->errorInfo()[2];
    }
	}



}
