<?php
session_name("agrocacao");
//inciar sesiones 
session_start();
//para destruir session
if (isset($_SESSION['us_tipo']) && $_SESSION['us_tipo'] == 1) {
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <title>Inicio | Dashboard</title>
    <?php include_once("../Layouts/Head.php"); ?>

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
                <li class="breadcrumb-item"><a href="./admin_catalogo.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="./admin_catalogo.php">Inicio</a></li>
            </ol>
            <!-- end breadcrumb -->


            <!-- begin page-header -->
            <h1 class="page-header">Inicio <small>Inicio</small></h1>
            <!-- end page-header -->

            <!-- begin row -->
            <div class="row">
				<!-- begin col-3 -->
				<div class="col-xl-3 col-md-6">
					<div class="widget widget-stats bg-blue">
						<div class="stats-icon"><i class="fas fa-camera-retro fa-sm"></i></div>
						<div class="stats-info">
							<h4>TOTAL IMGÁGENES PROCESADAS</h4>
							<p id="total-img"></p>	
						</div>
						<!-- <div class="stats-link">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
						</div> -->
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-xl-3 col-md-6">
					<div class="widget widget-stats bg-info">
						<div class="stats-icon"><i class="fas fa-camera-retro fa-sm"></i></div>
						<div class="stats-info">
							<h4>CACAO SANO</h4>
							<p id="cacao-sano-val"></p>	
						</div>
						<!-- <div class="stats-link">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
						</div> -->
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-xl-3 col-md-6">
					<div class="widget widget-stats bg-red">
						<div class="stats-icon"><i class="fas fa-camera-retro fa-sm"></i></div>
						<div class="stats-info">
							<h4>DETECCIÓN FITÓFTORA</h4>
							<p id="cacao-fito-val"></p>	
						</div>
						<!-- <div class="stats-link">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
						</div> -->
					</div>
				</div>
				<!-- end col-3 -->
				
			</div>
            <!-- end begin row -->

            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Inicio</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a> -->
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
                    </div>
                </div>
                <div class="panel-body">
                    <h1>ADMINISTRADOR</h1>
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
    <?php include_once("../Layouts/Js.php"); ?>
    <script type="text/javascript" src="./catalogo.js"></script>
</body>

</html>
<?php
} else {
    header('Location: ../../index.php');
}
?>

