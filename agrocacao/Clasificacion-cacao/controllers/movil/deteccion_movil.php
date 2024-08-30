<?php
include_once '../../models/Usuario.php';
$usuario = new usuario();

//subir imagen
    $escaneo=$_POST['estado']; // nombre del escaneo sano-fito1-fito2
    $escaneo_nombre=$_POST['escaneo'];//escaneo -- nombre
    $porcentaje=$_POST['porcentaje'];//porcentaje_escaneo
    $fecha_escaneo = date('Y-m-d H:i:s');
    $lote_id=$_POST['lote_id'];//lote
	$id_usuario=$_POST['user_id'];//id_usuario
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
            $nombre = $escaneo_nombre ."-". uniqid() . '-' . $_FILES['fileToUpload']['name'];

            // ruta donde se va guardar los archivo
            $ruta='../../uploads/cacao/'.$nombre;
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
