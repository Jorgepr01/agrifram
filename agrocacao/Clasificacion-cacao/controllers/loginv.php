<?php
include_once '../models/Usuario.php';
session_name("agrocacao");
session_start();

// Obtener las credenciales del usuario del formulario POST
$email = $_POST['usuario'];
$pass = $_POST['password'];

// Crear una instancia de la clase Usuario
$usuario = new Usuario();

// Llamar a la función de loguearse
$usuario = $usuario->loguearse($email, $pass);




// Verificar si se obtuvo un usuario válido
if (!empty($usuario)) {
    // Obtiene el estado del usuario desde la base de datos
    $estado_usuario = $usuario->estado_us_id;
    $tipo_us_id =  $usuario->tipo_us_id;

    // Verificar si el usuario está Habilitado
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
                redirect('admin_catalogo.php');
                break;
            case 2:
                redirect('agricultor_catalogo.php');
            break;
        }
    } else {
        // Usuario no está habilitado (inactivo)
        redirectindex('index.php');
    }
} else {
    // No se encontró un usuario válido en la base de datos
    redirectindex('index.php');
}




// Función de redirección
function redirect($location)
{
    header("Location: ../views/Home/$location");
    exit();
}

function redirectindex($location)
{
    header("Location: ../$location");
    exit();
}
