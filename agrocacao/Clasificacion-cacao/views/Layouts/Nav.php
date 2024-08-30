<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%" style="background-color: #57160ef0; ">
		<!-- begin sidebar user -->
		<ul class="nav" id="nav-perfil">

		</ul>
		<!-- end sidebar user -->


		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="nav-header">Menú</li>
			<!-- ADMINISTRADOR Y ROOT -->
			<?php
			if ($_SESSION['us_tipo'] == 1) {
			?>
				<li class="has-sub">
					<a href="../Home/admin_catalogo.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-home fa-fw"></i>
						<span>Inicio</span>
					</a>
				</li>

				<li class="has-sub">
					<a href="../Admin_usuario/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-users"></i>
						<span>Administración de Usuario</span>
					</a>

				</li>
                <li class="has-sub">
					<a href="../deteccion/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-lg fa-fw m-r-10 fa-bullseye"></i>
						<span>Procesamiento de Imágenes</span>
					</a>

				</li>
                
                <li class="has-sub">
					<a href="../lote/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-lg fa-fw m-r-10 fa-leaf"></i>
						<span>Lote</span>
					</a>
				</li>
                
                <li class="has-sub">
					<a href="../tratamiento/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-lg fa-fw m-r-10 fa-syringe"></i>
						<span>Tratamiento</span>
					</a>
				</li>

				
				<li class="has-sub">
					<a href="../seguimiento/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-lg fa-fw m-r-10 fa-bullseye"></i>
						<span>Seguimiento del cacao</span>
					</a>
				</li>
                <li class="has-sub">
					<a href="../reporte/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-lg fa-fw m-r-10 fa-file-alt"></i>
						<span>Reporte</span>
					</a>
				</li>

			<?php
			} else if ($_SESSION['us_tipo'] == 2) {
			?>

				<li class="has-sub">
					<a href="../Home/agricultor_catalogo.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-home fa-fw"></i>
						<span>Inicio</span>
					</a>
				</li>

				<li class="has-sub">
					<a href="../deteccion/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-lg fa-fw m-r-10 fa-bullseye"></i>
						<span>Procesamiento de Imágenes</span>
					</a>
				</li>
                
                <li class="has-sub">
					<a href="../loteAgri/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-lg fa-fw m-r-10 fa-leaf"></i>
						<span>Lote</span>
					</a>
				</li>
                
                <li class="has-sub">
					<a href="../tratamientoAgri/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-lg fa-fw m-r-10 fa-syringe"></i>
						<span>Tratamiento</span>
					</a>
				</li>
                
                <li class="has-sub">
					<a href="../seguimiento/index.php">
						<!-- <b class="caret"></b> -->
						<i class="fas fa-lg fa-fw m-r-10 fa-bullseye"></i>
						<span>Seguimiento del cacao</span>
					</a>
				</li>
			<?php
			} else {
				header('Location: ../../controllers/login.php');
			}
			?>

			<!-- begin sidebar minify button -->
			<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			<!-- end sidebar minify button -->
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->