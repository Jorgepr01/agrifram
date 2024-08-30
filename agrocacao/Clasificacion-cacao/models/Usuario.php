<?php
date_default_timezone_set('America/Guayaquil');
include_once 'Conexion.php';

class usuario
{
  var $objetos;
  private $acceso;
  public function __construct()
  {
    $db = new conexion();
    $this->acceso = $db->pdo;
  }

  // TODO: inicio de session
  function loguearse($email, $pass)
  {
    try {
      $sql = "SELECT * FROM usuario
          INNER JOIN tipo_usuario on usuario.tipo_us_id = tipo_usuario.id_tipo_us
          INNER JOIN estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
          WHERE email_us =:email";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':email' => $email));
      $usuario = $query->fetch(); // Establecer FETCH_ASSOC para obtener un array asociativo

      // Verificar si se encontró un usuario con el correo electrónico dado
      if ($usuario) {
        // Verificar si la contraseña proporcionada coincide con la contraseña almacenada
        if (password_verify($pass, $usuario->contrasena_us)) {
          // Si la contraseña coincide, devolver el objeto de usuario
          return $usuario;
        } else {
          // Si la contraseña no coincide, devolver false indicando una contraseña incorrecta
          return null;
        }
      } else {
        // Si no se encontró ningún usuario con el correo electrónico dado, devolver false
        return null;
      }
    } catch (PDOException $e) {
      // Manejar cualquier excepción de PDO (por ejemplo, errores de consulta)
      // Puedes registrar el error o devolver un mensaje de error genérico
      error_log("Error al intentar iniciar sesión: " . $e->getMessage());
      return null;
    }
  }

  // TODO: CAMBIAR CONTRASEÑA
  function cambiar_contra($oldpass, $newpass, $id_usuario)
  {
    $sql = "SELECT * FROM usuario where id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id_usuario));
    $this->objetos = $query->fetch();
    // verifico que la contraseña actual sea igual tabla
    if (!empty($this->objetos) && password_verify($oldpass, $this->objetos->contrasena_us)) {
      // verifico que la contraseña nueva no sea igual la ingresada
      if (password_verify($newpass, $this->objetos->contrasena_us)) {
        echo "repetida";
      }else{
        $contraseña_segura = password_hash($newpass, PASSWORD_BCRYPT, ['cost' => 4]);
        $sql = "UPDATE usuario SET contrasena_us=:newpass where id_us=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id_usuario, ':newpass' => $contraseña_segura));
        echo 'update';
      }
      
    } else {
      echo 'noupdate';
    }
  }



  //TODO: tipos de usuario
  function tipo_usuario()
  {
    $sql = "SELECT * FROM tipo_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute();
    $this->objetos = $query->fetchall();
    return $this->objetos;
  }

  // TODO: Crear usuario
  function crear($nombre, $apellido, $fechaNacimiento, $ci, $telefono, $correo, $contrasena, $tipo, $habilitado, $avatar_defecto)
  {
    $sql = "SELECT * FROM usuario WHERE email_us = :email";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':email' => $correo));
    $this->objetos = $query->fetchAll();

    if (!empty($this->objetos)) {
      return 'noadd';
    } else {
      // Cifrar la contraseña
      $contrasena_segura = password_hash($contrasena, PASSWORD_BCRYPT, ['cost' => 4]);
      $sql = "INSERT INTO usuario(nombre_us, apellido_us, edad_us, ci_us, telefono, email_us, contrasena_us, tipo_us_id, estado_us_id, avatar, creado_en) 
            VALUES(:nombre, :apellido, :fechaNacimiento, :ci_us, :telefono, :correo, :contrasena, :tipo, :estado_usuario, :avatar, now())";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':fechaNacimiento' => $fechaNacimiento,
        ':ci_us' => $ci,
        ':telefono' => $telefono,
        ':correo' => $correo,
        ':contrasena' => $contrasena_segura,
        ':tipo' => $tipo,
        ':estado_usuario' => $habilitado,
        ':avatar' => $avatar_defecto
      ));

      return 'add';
    }
  }

  // TODO: Buscar Usuario
  function buscar()
  {
    // si teclea  que se muestre el usuario buscar
    if (!empty($_POST['consulta'])) {
      $consulta = $_POST['consulta'];
      $sql = "SELECT * FROM usuario 
       join tipo_usuario on tipo_usuario.id_tipo_us =  usuario.tipo_us_id
       join estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
       WHERE (nombre_us LIKE :consulta OR apellido_us LIKE :consulta) 
       AND usuario.estado_us_id != 3";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':consulta' => "%$consulta%"));
      $this->objetos = $query->fetchall();
      return $this->objetos;
    } else {
      $sql = "SELECT * FROM usuario 
        join tipo_usuario on tipo_usuario.id_tipo_us =  usuario.tipo_us_id
        join estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
        where nombre_us NOT LIKE '' AND usuario.estado_us_id != 3 ORDER BY id_us LIMIT 25";
      $query = $this->acceso->prepare($sql);
      $query->execute();
      $this->objetos = $query->fetchall();
      return $this->objetos;
    }
  }

  //TODO: datos personales
  function dato_usuario($id)
  {
    $sql = "SELECT * FROM usuario
        INNER JOIN tipo_usuario on usuario.tipo_us_id = tipo_usuario.id_tipo_us
        INNER JOIN estado_usuario on usuario.estado_us_id = estado_usuario.id_estado_us
        and id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id));
    $this->objetos = $query->fetchAll();
    return $this->objetos;
  }

  //TODO: buscar avatar del usuario 
  function buscar_avatar_usuario($id_usuario)
  {
    try {
      $sql = "SELECT avatar FROM usuario WHERE id_us = :id_us";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id_us' => $id_usuario));
      $resultado = $query->fetchColumn();
      if ($resultado !== false) {
        return $resultado;
      } else {
        return "imgavatar.png";
      }
    } catch (PDOException $e) {
      // En lugar de imprimir un mensaje de error, podrías manejarlo de alguna otra manera (log, notificación, etc.)
      return "Error en la consulta: " . $e->getMessage();
    }
  }

  function cambiar_avatar($id_usuario, $nombre)
  {
    $sql = "SELECT avatar FROM usuario where id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id_usuario));
    $this->objetos = $query->fetchall();

    $sql = "UPDATE usuario SET avatar=:nombre where id_us=:id";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id' => $id_usuario, ':nombre' => $nombre));
    return $this->objetos;
  }

        
// TODO: subir imagen procesada
function imagen_analisis_seguimiento($seguiminiento,$estado, $porcentaje, $fecha_escaneo,$nombre, $observacion){
  $sql = "INSERT INTO trazabilidad (`escaneo_id`, `estado_cacao_id`, `porcentaje_trazabilidad`, `fecha_trazabilidad`, `imagen_trazabilidad`, `observacion`) 
            VALUES (:id_escaneo, :estado_escaneo_id, :porcentaje_trazabilidad, :fecha_trazabilidad, :imgen_trazabilidad, :observacion)";
    $query = $this->acceso->prepare($sql);
    $query->bindParam(':id_escaneo', $seguiminiento);
    $query->bindParam(':estado_escaneo_id', $estado);
    $query->bindParam(':porcentaje_trazabilidad', $porcentaje);
    $query->bindParam(':fecha_trazabilidad', $fecha_escaneo);
    $query->bindParam(':imgen_trazabilidad', $nombre);
    $query->bindParam(':observacion', $observacion);
    $query->execute();
    return "imagen subida correctamente";
}

// TODO: subir imagen procesada
    function imagen_analisis($escaneo,$estado_id, $porcentaje, $fecha_escaneo, $filename, $lote_id, $id_usuario){
      $sql = "INSERT INTO escaneo_cacao (escaneo,estado_cacao_id, porcentaje_escaneo, fecha_escaneo, imgen_escaneo, lote_id, us_id) 
                VALUES (:escaneo,:estado, :porcentaje, :fecha_escaneo, :filename, :lote, :us_id)";
        $query = $this->acceso->prepare($sql);
        $query->bindParam(':escaneo', $escaneo);
        $query->bindParam(':estado', $estado_id);
        $query->bindParam(':porcentaje', $porcentaje);
        $query->bindParam(':fecha_escaneo', $fecha_escaneo);
        $query->bindParam(':filename', $filename);
        $query->bindParam(':lote', $lote_id);
        $query->bindParam(':us_id', $id_usuario);
        $query->execute();
        return "imagen subida correctamente";
    }
     
        
    function actualizar_estado_sano($trasabilidad,$escaneo,$estado,$porcentaje,$fecha,$imagen_es){
            
      $sql = "UPDATE `escaneo_cacao` SET `estado_escaneo_id` = :estado_escaneo, escaneo=:escaneo, porcentaje_escaneo=:porcentaje_escaneo,fecha_escaneo=:fecha_escaneo,imgen_escaneo=:imgen_escaneo WHERE `id_escaneo` = :id_escaneo;";
        
            $query = $this->acceso->prepare($sql);
        $query->bindParam(':estado_escaneo', $estado);
        $query->bindParam(':escaneo', $escaneo);
        $query->bindParam(':porcentaje_escaneo', $porcentaje);
        $query->bindParam(':fecha_escaneo', $fecha);
        $query->bindParam(':imgen_escaneo', $imagen_es);
        $query->bindParam(':id_escaneo', $trasabilidad);
        $query->execute();
        return "imagen subida correctamente";
    }   
 

  //TODO: datos personales
  function actualizarDatosUser($id, $nuevos_datos)
  {
    $sql = "UPDATE usuario 
            SET 
                nombre_us = :nombre, 
                apellido_us = :apellido, 
                edad_us = :fecha_nacimiento, 
                ci_us = :cedula, 
                telefono = :telefono, 
                actualizado_en = NOW()
            WHERE id_us = :id";

    $query = $this->acceso->prepare($sql);
    $query->execute(array(
        ':nombre' => $nuevos_datos['nombres'],
        ':apellido' => $nuevos_datos['apellidos'],
        ':fecha_nacimiento' => $nuevos_datos['fecha_nacimiento'],
        ':cedula' => $nuevos_datos['cedula'],
        ':telefono' => $nuevos_datos['telefono'],
        ':id' => $id
    ));
    
    return "edit";
  }




  //TODO: borrar usuario
  function borrar($pass, $id_borrado, $id_usuario)
  {
    $sql = "SELECT id_us, contrasena_us FROM usuario WHERE id_us = :id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id_usuario' => $id_usuario));
    $this->objetos = $query->fetch();
    if (!empty($this->objetos) && password_verify($pass, $this->objetos->contrasena_us)) {
      $sql = "UPDATE usuario SET estado_us_id = 3 WHERE id_us = :id_borrado";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id_borrado' => $id_borrado));

      echo 'borrado';
    } else {
      echo 'noborrado';
    }
  }

  //TODO: Deshabilitar Usuario
  function deshabilitar_usuario($pass, $id_deshabilitar, $id_usuario)
  {
    $sql = "SELECT id_us, contrasena_us FROM usuario where id_us=:id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id_usuario' => $id_usuario));
    $this->objetos = $query->fetch();

    if (!empty($this->objetos) && password_verify($pass, $this->objetos->contrasena_us)) {
      $habilitado = 2;
      $sql = "UPDATE usuario SET estado_us_id = :habilitado where id_us=:id";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id' => $id_deshabilitar, ':habilitado' => $habilitado));
      echo 'deshabilitado';
    } else {
      echo 'nodeshabiltado';
    }
  }

  //TODO: Habilitar usuario
  function habilitar_usuario($pass, $id_habilitar, $id_usuario)
  {
    $sql = "SELECT id_us, contrasena_us FROM usuario where id_us=:id_usuario";
    $query = $this->acceso->prepare($sql);
    $query->execute(array(':id_usuario' => $id_usuario));
    $this->objetos = $query->fetch();
    if (!empty($this->objetos) && password_verify($pass, $this->objetos->contrasena_us)) {
      $habilitado = 1;
      $sql = "UPDATE usuario SET estado_us_id =:habilitado where id_us=:id";
      $query = $this->acceso->prepare($sql);
      $query->execute(array(':id' => $id_habilitar, ':habilitado' => $habilitado));
      echo 'habilitado';
    } else {
      echo 'noexit';
    }
  }
        
        
  //TODO: Reporte Admin
  public function kpi()
    {
        try {
            $resultado = array();

            // Primera consulta
            $sql = "SELECT COUNT(id_escaneo) FROM escaneo_cacao WHERE estado_cacao_id != 4;";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $resultado['total_img'] = $query->fetchColumn();

            // Segunda consulta sano

            $sql = "SELECT COUNT(id_escaneo) FROM escaneo_cacao WHERE  estado_cacao_id = 1;";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $resultado['cacao_sano_val'] = $query->fetchColumn();

            // Tercera consulta fito
            
            $sql = "SELECT COUNT(id_escaneo) FROM escaneo_cacao WHERE estado_cacao_id != 1  AND  estado_cacao_id != 4;";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $resultado['cacao_fito_val'] = $query->fetchColumn();

            return $resultado;
        } catch (PDOException $e) {
            // Manejo de errores
            return "Error en la consulta: " . $e->getMessage();
        }
    }
        
   //TODO: Reporte AGRICULTOR
  public function kpi_agricu($id_usuario)
	{
    	try {
        $resultado = array();

        // Primera consulta
        $sql = "SELECT COUNT(id_escaneo) FROM escaneo_cacao WHERE us_id = :id_usuario AND estado_cacao_id != 4;";
        $query = $this->acceso->prepare($sql);
        $query->bindValue(':id_usuario', $id_usuario);
        $query->execute();
        $resultado['total_img'] = $query->fetchColumn();

        // Segunda consulta sano
        $sql = "SELECT COUNT(id_escaneo) FROM escaneo_cacao WHERE estado_cacao_id = 1 AND us_id = :id_usuario;";
        $query = $this->acceso->prepare($sql);
        $query->bindValue(':id_usuario', $id_usuario);
        $query->execute();
        $resultado['cacao_sano_val'] = $query->fetchColumn();

        // Tercera consulta fito
        $sql = "SELECT COUNT(id_escaneo) FROM escaneo_cacao WHERE estado_cacao_id != 1 AND us_id = :id_usuario AND estado_cacao_id != 4;";
        $query = $this->acceso->prepare($sql);
        $query->bindValue(':id_usuario', $id_usuario);
        $query->execute();
        $resultado['cacao_fito_val'] = $query->fetchColumn();

        return $resultado;
    	} catch (PDOException $e) {
        	// Manejo de errores
        	return "Error en la consulta: " . $e->getMessage();
    	}
}
 
   
    function delete_seg($id_escaneo) {
        $estado_delete = 4;
    	$sql = "UPDATE escaneo_cacao SET estado_cacao_id = :nuevo_valor WHERE id_escaneo = :id_escaneo";
    	$query = $this->acceso->prepare($sql);
    	$query->execute(array(':nuevo_valor' => $estado_delete, ':id_escaneo' => $id_escaneo));

    	if ($query->rowCount() > 0) {
        	return "delete";
    	} else {
        	return "nodelete";
    	}
	}
}
	