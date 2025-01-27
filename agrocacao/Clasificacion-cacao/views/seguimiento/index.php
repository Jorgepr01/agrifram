<?php
session_name("agrocacao");
//inciar sesiones 
session_start();
//para destruir session
if (isset($_SESSION['us_tipo']) && $_SESSION['us_tipo'] == 1 || $_SESSION['us_tipo'] == 2) {
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <title>Inicio | Seguimiento</title>
    <?php include_once("../Layouts/Head.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="../../assets/css/deteccion.css">
        
  
        
</head>

<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">

        <?php include_once("../Layouts/Header.php"); ?>


        <?php include_once("../Layouts/Nav.php"); ?>

        <!-- begin #content -->
        <div id="content" class="content">

            <!-- begin breadcrumb -->
            <ol class="breadcrumb float-xl-right">
                <li class="breadcrumb-item"><a href="../../controllers/login.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="./index.php">Seguimiento del cacao</a></li>
            </ol>
            <!-- end breadcrumb -->


            <!-- begin page-header -->
            <h1 class="page-header">Seguimiento del cacao</h1>
            <!-- end page-header -->


            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Seguimiento del cacao</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
                    </div>
                </div>  
                <div class="panel-body">
                    <!--aqui va el contenido de la pagina-->
                        
                    
    					<div class="table-responsive">
        				<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Id</th>
					<th>Fase Inicial</th>
					<th>Lote</th>
					<th>Nombre</th>
					<th>Estado Inicial</th>
					<th>Fecha Inicial</th>
					<th>Porcentaje Inicial %</th>
					<th>Imagen</th>
					<th>Fase Actual</th>
					<th>Estado Actual</th>
					<th>Fecha Actual</th>
					<th>Porcentaje Actual %</th>
					<th>Imagen</th>
					<th>Observación</th>
					<th>Detectar Seguimiento</th>

                </tr>
            </thead>
        </table>
    </div>
                    
                </div>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end #content -->



    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->


    <?php include_once("../Layouts/modal.php"); ?>
    <?php include_once("./mdl.php");?>
    <?php include_once("../Layouts/Js.php"); ?>
    <script type="text/javascript" src="../admin_usuario/admin_usuario.js"></script>
        <script src="./descrition.js"></script>

    <script src='seguimiento.js'></script>
        
    
</body>

</html>

<?php
} else {
    header('Location: ../../index.php');
}
?>