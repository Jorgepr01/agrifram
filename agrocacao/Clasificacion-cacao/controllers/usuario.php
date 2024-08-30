<?php
include_once '../models/Usuario.php';
session_name("agrocacao");
session_start();
$id_usuario = $_SESSION["usuario"];
$usuario = new usuario();


//TODO: buscar usuario actual
if ($_POST['funcion'] == 'dato_usuario') {
    $json = array();
    $fecha_actual = new DateTime();
    $usuario->dato_usuario($id_usuario);
    foreach ($usuario->objetos as $objeto) {
        // sacar la edad usuario
        $nacimiento = new DateTime($objeto->edad_us);
        $edad = $nacimiento->diff($fecha_actual);
        $edad_years = $edad->y;
        // formatear fecha
        $fecha_formateada = $nacimiento->format('Y-m-d');
        $json[] = array(
            'id_us' => $objeto->id_us,
            'nombres' => $objeto->nombre_us,
            'apellidos' => $objeto->apellido_us,
            'edad' => $edad_years,
            'fecha_nacimiento' => $fecha_formateada,
            'ci' => $objeto->ci_us,
            'telefono' => $objeto->telefono,
            'correo' => $objeto->email_us,
            'nombre_tipo' => $objeto->nombre_tipo_us,
            'tipo_us_id' => $objeto->tipo_us_id,
            'nombre_estado_usuario' => $objeto->nombre_estado_us,
            'avatar' => $objeto->avatar
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}



//TODO: cambiar avatar
if($_POST['funcion'] == 'cambiar_avatar'){
    if(($_FILES['avatar']['type'] == 'image/jpeg') || $_FILES['avatar']['type'] == "image/jpg" || ($_FILES['avatar']['type'] == 'image/png') || ($_FILES['avatar']['type'] == 'image/gif')) {
        // generar un nombre de archivo único 
        $nombre = uniqid() . '-' . $_FILES['avatar']['name'];

       // ruta donde se va guardar los archivo
       $ruta='../uploads/avatar/'.$nombre;
        
       // utiliza para mover un archivo cargado (subido) desde una ubicación temporal a una ubicación permanente en el servidor
       move_uploaded_file($_FILES['avatar']['tmp_name'], $ruta);
       $usuario->cambiar_avatar($id_usuario, $nombre);
       
        foreach ($usuario->objetos as $objeto) {
            if($objeto->avatar != "imgavatar.png"){
                if(file_exists('../uploads/avatar/'.$objeto->avatar)){
                // se utiliza para eliminar un archivo del sistema de archivos del servido
                unlink('../uploads/avatar/'.$objeto->avatar);
                }
            }
        }
       
      $json= array();
      $json[]=array(
      'ruta'=>$ruta,
      'alert'=>'edit'
      );
      $jsonstring = json_encode($json[0]);
      echo $jsonstring;
    
    }else{
        $json= array();
        $json[]=array(
        'alert'=>'noedit'
        );
         $jsonstring = json_encode($json[0]);
        echo $jsonstring;
     }
}

//TODO: tipos de usuario
if ($_POST["funcion"] == "tipos_usuario") {
    $json = array();
    $usuario->tipo_usuario();
    foreach ($usuario->objetos as $objeto) {
        $json[] = array(
            'id_tipo_us' => $objeto->id_tipo_us,
            'nombre_tipo_us' => $objeto->nombre_tipo_us
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//TODO: tipos de usuario
if ($_POST["funcion"] == "act_perfil") {
    $nombre = $_POST["nombres"];
    $apellido = $_POST["apellidos"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $cedula = $_POST["cedula"];
    $celular = $_POST["telefono"];


    // Array de errores
    $errores = array();
    // Validar los datos antes de guardarlos en la base de datos
    // Validar campo nombre
    if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
        $nombre_validado = true;
    } else {
        $nombre_validado = false;
        $errores['nombre-error'] = "El nombre no es válido";
    }


    if (!empty($apellido) && !is_numeric($apellido) && !preg_match("/[0-9]/", $apellido)) {
        $apellido_validado = true;
    } else {
        $apellido_validado = false;
        $errores['apellido-arror'] = "El apellido no es válido";
    }

    // validar fecha 
    // fecha actual
    $fecha_actual = new DateTime();
    // fecha de nacimiento
    $nacimiento = new DateTime($fecha_nacimiento);
    // Calcular la diferencia entre la fecha de nacimiento y la fecha actual
    $edad = $nacimiento->diff($fecha_actual);
    // Extraer los años de la diferencia calculada
    $edad_years = $edad->y;


    if ($edad_years >= 18 && $edad_years <= 110) {
        $fecha_nacimiento_validado = true;
    } else {
        $fecha_nacimiento_validado = false;
        $errores['fecha-naci'] = "La fecha no es válido debe ser mayor 18 y menor 110";
    }


    // Validar cedula
    if (validarCedulaEcuatoriana($cedula)) {
        $cedula_validado = true;
    } else {
        $cedula_validado = false;
        $errores['cedu'] = "La cedula no es valida";
    }



    if (count($errores) == 0) {
        // Llamar al método crear del objeto usuario
        $json = array();
        $nuevosDatos = array(
            'nombres' => $_POST["nombres"],
            'apellidos' => $_POST["apellidos"],
            'fecha_nacimiento' => $_POST["fecha_nacimiento"],
            'cedula' => $_POST["cedula"],
            'telefono' => $_POST["telefono"]
        );

        $resultado = $usuario->actualizarDatosUser($id_usuario, $nuevosDatos);
        echo $resultado;
    } else {
        $jsonstring = json_encode($errores);
        echo $jsonstring;
    }  

}


//TODO: cambiar contraseña
if ($_POST['funcion'] == 'cambiar_contra') {
    $oldpass = filter_input(INPUT_POST, 'oldpass', FILTER_SANITIZE_SPECIAL_CHARS);
    $newpass = filter_input(INPUT_POST, 'newpass', FILTER_SANITIZE_SPECIAL_CHARS);
     if(!empty($newpass)){
        $usuario->cambiar_contra($oldpass, $newpass, $id_usuario);
    }else{
        echo "vaciopass";
    }
}




//TODO: buscar usuarios
if ($_POST['funcion'] == 'buscar_usuarios') {
    $json = array();
    $usuario->buscar();
    foreach ($usuario->objetos as $objeto) {
        $json[] = array(
            'id_us' => $objeto->id_us,
            'nombres' => $objeto->nombre_us,
            'apellidos' => $objeto->apellido_us,
            'ci' => $objeto->ci_us,
            'correo' => $objeto->email_us,
            'telefono' => $objeto->telefono,
            'nombre_tipo' => $objeto->nombre_tipo_us,
            'tipo_us_id' => $objeto->tipo_us_id,
            'nombre_estado_us' => $objeto->nombre_estado_us,
            'avatar' => $objeto->avatar
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

//TODO: buscar avatar del usuario
if($_POST['funcion'] == 'buscar_avatar_usuario'){
    // $json = array();
    $avatar = $usuario->buscar_avatar_usuario($id_usuario);
    echo $avatar;
}



//TODO: insertar usuario
if ($_POST['funcion'] == 'crear_usuario') {
    // Creo la carpeta si no existe
    if (!is_dir('../uploads/avatar')) {
        mkdir('../uploads/avatar', 0777, true);
        // Ruta de la carpeta de origen
        $rutaOrigen = '../assets/img/';
        // Ruta de la carpeta de destino
        $rutaDestino = '../uploads/avatar/';

        // Nombre del archivo a copiar
        $nombreArchivo = 'imgavatar.png';

        // Construir rutas completas
        $rutaArchivoOrigen = $rutaOrigen . $nombreArchivo;
        $rutaArchivoDestino = $rutaDestino . $nombreArchivo;

        // Intentar copiar el archivo
        copy($rutaArchivoOrigen, $rutaArchivoDestino);
    }

    $avatar_defecto = "imgavatar.png";
    $habilitado = 1;

    // Obtener los datos enviados por POST
    $nombre = filter_input(INPUT_POST, 'nombre_usuario', FILTER_SANITIZE_SPECIAL_CHARS);
    $apellido = filter_input(INPUT_POST, 'apellido_usuario', FILTER_SANITIZE_SPECIAL_CHARS);
    $fechaNacimiento = filter_input(INPUT_POST, 'fecha_nacimiento', FILTER_SANITIZE_SPECIAL_CHARS);
    $ci = filter_input(INPUT_POST, 'ci', FILTER_SANITIZE_NUMBER_INT);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_SPECIAL_CHARS);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $contrasena = filter_input(INPUT_POST, 'contrasena', FILTER_SANITIZE_SPECIAL_CHARS);
    $tipo = filter_input(INPUT_POST, 'select_tipo', FILTER_VALIDATE_INT);

   // Array de errores
    $errores = array();
    // Validar los datos antes de guardarlos en la base de datos
    // Validar campo nombre
    if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
        $nombre_validado = true;
    } else {
        $nombre_validado = false;
        $errores['nombre'] = "El nombre no es válido";
    }


    if (!empty($apellido) && !is_numeric($apellido) && !preg_match("/[0-9]/", $apellido)) {
        $apellido_validado = true;
    } else {
        $apellido_validado = false;
        $errores['apellido'] = "El apellido no es válido";
    }

     
    // validar fecha 
    // fecha actual
    $fecha_actual = new DateTime();
    // fecha de nacimiento
    $nacimiento = new DateTime($fechaNacimiento);
    // Calcular la diferencia entre la fecha de nacimiento y la fecha actual
    $edad = $nacimiento->diff($fecha_actual);
    // Extraer los años de la diferencia calculada
    $edad_years = $edad->y;


    if ($edad_years >= 18 && $edad_years <= 110) {
        $fecha_nacimiento_validado = true;
    } else {
        $fecha_nacimiento_validado = false;
        $errores['fecha-naci'] = "La fecha no es válida debe ser mayor 18 y menor 110";
    }


    // Validar cedula
    if (validarCedulaEcuatoriana($ci)) {
        $cedula_validado = true;
    } else {
        $cedula_validado = false;
        $errores['cedu'] = "La cedula no es válida";
    }

    // Validar la contraseña
    if (!empty($contrasena)) {
        $password_validado = true;
    } else {
        $password_validado = false;
        $errores['password'] = "La contraseña está vacía";
    }


    // validar tipo_usuario
    if (!empty($tipo)) {
        $tipo_validado = true;
    } else {
        $tipo_validado = false;
        $errores['tipo-usuario'] = "Selecionar Tipo de Usuario";
    }


    if (count($errores) == 0) {
        // Llamar al método crear del objeto usuario
        $resultado = $usuario->crear($nombre, $apellido, $fechaNacimiento, $ci, $telefono, $correo, $contrasena, $tipo, $habilitado, $avatar_defecto);
        echo $resultado;
    } else {
        $jsonstring = json_encode($errores);
        echo $jsonstring;
    }
}







//TODO: borrar usuario
if ($_POST['funcion'] == 'borrar-usuario') {
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
    $id_borrado = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
    $usuario->borrar($pass, $id_borrado, $id_usuario);
}



//TODO: deshabilitar usuario
if ($_POST['funcion'] == 'deshabilitar-usu') {
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
    $id_deshabilitar = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
    $usuario->deshabilitar_usuario($pass, $id_deshabilitar, $id_usuario);
}


//TODO: habilitar usuario
if ($_POST['funcion'] == 'habilitar-usu') {
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
    $id_habilitar = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
    $usuario->habilitar_usuario($pass, $id_habilitar, $id_usuario);
}

// TODO: validacion de cedula
function validarCedulaEcuatoriana($cedula)
{
    // Verificar que la cédula tenga 10 dígitos
    // Se utiliza la función strlen para verificar la longitud de la cadena cedula.
    if (strlen($cedula) != 10) {
        // Si la longitud no es 10, la función retorna false.
        return false;
    }

    // Verificar que los dos primeros dígitos correspondan a una provincia válida
    // Se usa substr($cedula, 0, 2) para obtener los dos primeros dígitos de la cédula.
    // Se convierte esta subcadena en un entero usando (int).
    // Se verifica que este entero esté entre 1 y 24, que son los códigos válidos de provincia en Ecuador.
    $provincia = (int)substr($cedula, 0, 2);
    if ($provincia < 1 || $provincia > 24) {
        // Si el código de provincia no está en el rango permitido, la función retorna false.
        return false;
    }

    // str_split($cedula) convierte la cédula en un array de caracteres (dígitos).
    $digitos = str_split($cedula);
    // Se inicializa una variable $suma en 0.
    $suma = 0;

    // Aplicar el algoritmo de verificación
    // Se itera a través de los primeros 9 dígitos de la cédula (índices de 0 a 8).
    for ($i = 0; $i < 9; $i++) {
        $digito = (int)$digitos[$i];
        // El condicional if ($i % 2 == 0) dentro del código verifica si la posición del dígito actual es par 
        // (considerando que la indexación empieza desde 0).
        if ($i % 2 == 0) {
            // posiciones pares (0-indexadas) multiplicar por 2 y restar 9 si es >= 10
            $digito *= 2;
            // Si el resultado de la multiplicación es mayor o igual a 10, se resta 9 del resultado.
            if ($digito >= 10) {
                $digito -= 9;
            }
        }
        // Se suma el resultado (modificado si es necesario) a $suma.
        $suma += $digito;
    }

    // Obtener el dígito verificador
    // Se obtiene el décimo dígito de la cédula y se convierte en un entero.
    $verificador = (int)$digitos[9];

    // Calcular el valor que debería tener el dígito verificador
    // Se calcula el residuo de la suma ($suma % 10).
    $residuo = $suma % 10;
    // Si el residuo es 0, el dígito verificador calculado es 0.
    // Si el residuo no es 0, el dígito verificador calculado es 10 - $residuo.
    $digitoVerificadorCalculado = $residuo == 0 ? 0 : 10 - $residuo;

    // Comparar con el dígito verificador proporcionado
    // Objetivo: Comparar el dígito verificador calculado con el dígito verificador proporcionado en la cédula.
    // Proceso: Se utiliza una comparación simple.
    // Resultado: Retorna true si los dígitos coinciden, de lo contrario, retorna false.
    return $digitoVerificadorCalculado == $verificador;
}


//subir imagen
if ($_POST["funcion"] == "subir_imagen_analisis") {
    $escaneo=$_POST['estado'];//escaneo -- nombre
    $escaneo_nombre=$_POST['escaneo'];//escaneo -- nombre
    $porcentaje=$_POST['porcentaje'];//porcentaje_escaneo
    $fecha_escaneo = date('Y-m-d H:i:s');//fecha_escaneo
    $lote_id=$_POST['lote_id'];//lote
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Comprobar si el archivo es una imagen real o una imagen falsa
    // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    // if($check !== false) {
    //     $uploadOk = 1;
    // } else {
    //     echo "El archivo no es una imagen.";
    //     $uploadOk = 0;
    // }
            // Comprobar si el archivo ya existe
            if (file_exists($target_file)) {
                echo "Lo siento, el archivo ya existe.";
                $uploadOk = 0;
            }
            
        // Comprobar el tamaño del archivo
        // if ($_FILES["fileToUpload"]["size"] > 500000) {
        //     echo "Lo siento, tu archivo es demasiado grande.";
        //     $uploadOk = 0;
        // }
                // Permitir ciertos formatos de archivo
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
            $uploadOk = 0;
        }
        else{
            $nombre = $escaneo_nombre ."-". uniqid() . '-' . $_FILES['fileToUpload']['name'];//imagen

            // ruta donde se va guardar los archivo
            $ruta='../uploads/cacao/'.$nombre;
                echo $ruta;
             
            // utiliza para mover un archivo cargado (subido) desde una ubicación temporal a una ubicación permanente en el servidor
            echo "Imagen subida correctamente";
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $ruta);
            

					if ($escaneo == "Fitoftora_fase_1_Colonización") {
                    	$estado = 2;
                	} else if ($escaneo == "Fitoftora_fase_2_Reproducción") {
                    	$estado = 3;
                	}else if ($escaneo == "Sano") {
                    	$estado = 1;
                	} else {
                            echo "Clase no identificada";
                    	return;
                	}
             echo "Imagen subida correctamente";
            $usuario->imagen_analisis($escaneo_nombre,$estado, $porcentaje, $fecha_escaneo, $nombre, $lote_id, $id_usuario);
        }
}


if ($_POST["funcion"] == "subir_imagen_seguimiento") {
    $lote='seguimiento';
    $escaneo=$_POST['estado'];
    $porcentaje=$_POST['porcentaje'];
    $fecha_escaneo = date('Y-m-d H:i:s');
    $observacion=$_POST['observacion'];
    $seguiminiento=$_POST['seguiminiento'];
        
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Comprobar si el archivo es una imagen real o una imagen falsa
    // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    // if($check !== false) {
    //     $uploadOk = 1;
    // } else {
    //     echo "El archivo no es una imagen.";
    //     $uploadOk = 0;
    // }
            // Comprobar si el archivo ya existe
            if (file_exists($target_file)) {
                echo "Lo siento, el archivo ya existe.";
                $uploadOk = 0;
            }
            
        // Comprobar el tamaño del archivo
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Lo siento, tu archivo es demasiado grande.";
            $uploadOk = 0;
        }
                // Permitir ciertos formatos de archivo
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
            $uploadOk = 0;
        }
        else{
            $nombre = $lote ."-". uniqid() . '-' . $_FILES['fileToUpload']['name'];

            // ruta donde se va guardar los archivo
            $ruta='../uploads/cacao/'.$nombre;
                echo $ruta;
             
            // utiliza para mover un archivo cargado (subido) desde una ubicación temporal a una ubicación permanente en el servidor
            echo "Imagen subida correctamente";
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $ruta);
            
			$porcentaje = round($porcentaje, 2);

					if ($escaneo == "Fitoftora_fase_1_Colonización") {
                    	$estado = 2;
                	} else if ($escaneo == "Fitoftora_fase_2_Reproducción") {
                    	$estado = 3;
                	}else if ($escaneo == "Sano") {
                    	$estado = 1;
                	} else {
                            echo "Clase no identificada";
                    	return;
                	}
             echo "Imagen subida correctamenteee";
            $usuario->imagen_analisis_seguimiento($seguiminiento,$estado, $porcentaje, $fecha_escaneo,$nombre, $observacion);
        }
}


//TODO: Reporte Administrado
if ($_POST["funcion"] == "kpi") {

	$resultados = $usuario->kpi();
    $jsonstring = json_encode($resultados);
    echo $jsonstring;
}



//TODO: Reporte tecnico
if ($_POST["funcion"] == "kpi_agricu") {

	$resultados = $usuario->kpi_agricu($id_usuario);
    $jsonstring = json_encode($resultados);
    echo $jsonstring;
}



//segumiento


if ($_POST['funcion'] == 'delete') {
    
   $id_escaneo = $_POST['id_escaneo'];
   $resultados = $usuario->delete_seg($id_escaneo);
     
   echo $resultados;   
    
}






