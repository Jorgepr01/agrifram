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

    <title>Inicio | Reporte</title>
    <?php include_once("../Layouts/Head.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

        
  
        
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
                <li class="breadcrumb-item"><a href="./index.php">Reporte</a></li>
            </ol>
            <!-- end breadcrumb -->


            <!-- begin page-header -->
            <h1 class="page-header">Reporte</h1>
            <!-- end page-header -->


            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Reporte</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
                    </div>
                </div>  
                <div class="panel-body">
                             <h4 style='text-align: center;'>Filtro De Búsqueda </h4>
                        
                  	<div class="form-group row m-b-15">
        				<label class="col-form-label col-md-3">Seleccione Lote</label>
        				<div class="col-md-9">
            				<select id="loteSelect" class="form-control">
                				<option value="">Seleccione Lote</option>
            				</select>
        				</div>
    				</div>
    				<div class="form-group row m-b-15">
        				<label class="col-form-label col-md-3">Seleccione Nombre</label>
        				<div class="col-md-9">
            				<select id="escaneoSelect" class="form-control">
                				<option value="">Seleccione Nombre</option>
            				</select>
        				</div>
    				</div>
                     <h4 style='text-align: center;'>Cuadro De Desglose</h4>
                        
                    <div class="datatable">
                            
    					<table id="tabladata" class="table">
                                
        				<!-- Contenido de la tabla -->
    					</table>
                           
					</div>
                        
             
                    <h4>Seguimiento de la Enfermedad</h4>
                    <canvas id="myChartAvanceEnfermedad" width="400" height="200"></canvas>
                        
                    <h4>Cantidad de Mazorcas Detectadas por Lotes </h4>
					<canvas id="myChart" width="400" height="200"></canvas>
    				
                    
                </div>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end #content -->



    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
    
    <!-- end page container -->


    <?php include_once("../Layouts/modal.php"); ?>
    
    <?php include_once("../Layouts/Js.php"); ?>
    <script type="text/javascript" src="../admin_usuario/admin_usuario.js"></script>
    <script src='reporte.js'></script>
        
    
</body>

</html>

<?php
} else {
    header('Location: ../../index.php');
}
?>