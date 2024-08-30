<?php
session_name("agrocacao");
session_start();
if (isset($_SESSION["us_tipo"])) {
    switch ($_SESSION["us_tipo"]) {
        case 1:
            redirect('admin_catalogo.php');
            break;
        case 2:
            redirect('agricultor_catalogo.php');
            break;
    }
}
// Función de redirección
function redirect($location)
{
    header("Location: views/Home/$location");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/9cce3d02ed.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="icon" type="image/x-icon" href="assets/img/logo-header.png">
    <link href=".\assets\css\modal.css" rel="stylesheet">
    <link href=".\assets\css\alert.css" rel="stylesheet">
    <!-- ================== Select2 ================== -->
	<link href=".\assets\plugins\select2\dist\css\select2.min.css" rel="stylesheet">
	<!-- ================== FIN Select2 ================== -->
    <title>Agrocacao</title>
</head>

<body>
    <div class="logo">
        <h1>Acceder a tu cuenta</h1>
        <!-- include  cuantas veces seas -->
        <form id="login">
            <!-- user name -->
            <label for="username"><i class="fa-solid fa-user"></i> Usuario</label>
            <input type="text" placeholder="Ingresar Usuario" name="usuario" id="usuario">
            <!-- pasword -->
            <label for="pasword"><i class="fa-solid fa-key"></i> Contraseña</label>
            <input type="password" placeholder="Ingresar Contraseña" name="password" id = "password">

            <!-- boton -->
            <input type="submit" value="Inicio" name="btningresar">

            <a class="recu-contra">¿Olvídaste tu contraseña?</a>

        </form>

    </div>
    <?php include_once("./modal.php"); ?>
    <script src=".\assets\js\app.min.js"></script>
    <script src=".\assets\js\theme\default.min.js"></script>
    <!-- ================== Sweetalert ================== -->
	<script src=".\assets\plugins\sweetalert\dist\sweetalert.min.js"></script>
	<!-- ================== FIN Sweetalert ================== -->
    <script src=".\index.js"></script>
    <script type="text/javascript" src="./assets/js/contenido.js"></script>
</body>

</html>