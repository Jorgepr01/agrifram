<?php
session_name("agrocacao");
//inciar sesiones 
session_start();
//para destruir session
session_destroy();
header("location: ../index.php");

?>