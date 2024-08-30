<?php
include_once '../../models/Email.php';
$email = new email();

if($_POST['funcion']=='recuperar'){
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_SPECIAL_CHARS);
    $email->correo_recup($correo);
   
}


if ($_POST['funcion'] == 'recuperar_contra') {
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_SPECIAL_CHARS);
    $cod_recup = filter_input(INPUT_POST, 'cod_recup', FILTER_SANITIZE_SPECIAL_CHARS);
    $nuevo_pass = filter_input(INPUT_POST, 'nuevo_pass', FILTER_SANITIZE_SPECIAL_CHARS);

    // Array de errores
    $errores = array();
    // Validar los datos antes de guardarlos en la base de datos
    if (empty($cod_recup)) {
        $errores['cod_recup'] = "El código no es válido";
    } 
    
    if(empty($nuevo_pass)){
        $errores['nuevo_pass'] = "La contraseña no es válida";
    }

    // Validar apellidos
    if (count($errores) == 0) {
        // Llamar al método crear del objeto usuario
        $result = $email->recuperar_contra($correo, $cod_recup, $nuevo_pass);
        echo $result;
    } else {
        $jsonstring = json_encode($errores);
        echo $jsonstring;
    }
       
}
