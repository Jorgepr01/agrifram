<?php
include_once '../models/Usuario.php';
session_name("agrocacao");
session_start();
// Tu código existente aquí...

if ($_POST['funcion'] == "login") {
    // Obtener las credenciales del usuario del formulario POST
    $email = trim($_POST['usu']);
    $pass = trim($_POST['contra']);

    // Validar entradas
    if (empty($email) || empty($pass)) {
        echo json_encode(array("error" => "Hay campos vacíos. Por favor, completa todos los campos requeridos para iniciar sesión"));
        exit();
    }

    // Crear una instancia de la clase Usuario
    $usuario = new Usuario();

    // Llamar a la función de loguearse
    $usuario = $usuario->loguearse($email, $pass);

    // Verificar si se obtuvo un usuario válido
    if (!empty($usuario)) {
        // Obtiene el estado del usuario desde la base de datos
        $estado_usuario = $usuario->estado_us_id;
        $tipo_us_id = $usuario->tipo_us_id;

        // Verificar si el usuario está habilitado
        if ($estado_usuario == 1) {
            // Establecer las variables de sesión
            $_SESSION["usuario"] = $usuario->id_us;
            $_SESSION["nombre"] = $usuario->nombre_us;
            $_SESSION["apellido"] = $usuario->apellido_us;
            $_SESSION["fechanacimiento"] = $usuario->edad_us;
            $_SESSION["ci"] = $usuario->ci_us;
            $_SESSION["email"] = $usuario->email_us;
            $_SESSION["us_tipo"] = $usuario->tipo_us_id;
            $_SESSION["rol"] = $usuario->nombre_tipo_us;
            $_SESSION['nombre_tipo_us'] = $usuario->nombre_tipo_us;
            $_SESSION['avatar'] = $usuario->avatar;

            // Obtener fecha actual
            $fechaActual = date('Y-m-d');
            // Calcular diferencia entre fechas
            $diff = date_diff(date_create($usuario->edad_us), date_create($fechaActual));
            // Obtener la edad
            $edad = $diff->format('%y');
            // Edad actual
            $_SESSION["edad"] = $edad;
            $_SESSION["id_estado_usuario"] = $usuario->id_estado_us;
            $_SESSION["nombre_estado_usuario"] = $usuario->nombre_estado_us;
            $_SESSION["avatar"] = $usuario->avatar;

            // Redirigir según el tipo de usuario
            switch ($tipo_us_id) {
                case 1:
                    echo json_encode(array("redirect" => "./views/Home/admin_catalogo.php"));
                    break;
                case 2:
                    echo json_encode(array("redirect" => "./views/Home/agricultor_catalogo.php"));
                    break;
                default:
                    echo json_encode(array("error" => "No se encontró un tipo de usuario válido"));
                    break;
            }
        } else {
            // Usuario no está habilitado (inactivo)
            echo json_encode(array("error" => "Tu cuenta está inactiva. Por favor, contacta al soporte para más información"));
        }
    } else {
        // No se encontró un usuario válido en la base de datos
        echo json_encode(array("error" => "Las credenciales proporcionadas son inválidas. Por favor, verifica tu nombre de usuario y contraseña e inténtalo de nuevo"));
    }
}


?>
