<?php
include_once '../../models/Usuario.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
        
        $usuario = new Usuario();
        $usuario = $usuario->loguearse($email, $password);
        if ($usuario){
            echo json_encode(["message" => "Login successful", "user" => $usuario]);
        }else{
            echo json_encode(["message" => "Invalid login"]);
        }
}