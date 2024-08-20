<?php defined('FCPATH') or exit('No direct script access allowed');
$db = \Config\Database::connect();
if (!isset($title)) $title = 'Inicio';
// Notificaciones
$notificaciones = APPPATH . 'Views/htdocs/notificaciones.php';
$mensajes = APPPATH . 'views/htdocs/mensajes.php';
$permisos = session('permisos');
$navigation = APPPATH . "Views/usuario/navigation.php";
?>
<!doctype html>
<html class="no-js " lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
	<title>PEOPLE<?php if ($title) echo " - $title" ?></title>
	<link rel="icon" href="<?= base_url("favicon.ico") ?>" type="image/x-icon">
	<!-- GC CSS FILES -->
	<?php
	if (isset($css_files)) {
		foreach ($css_files as $file) : ?>
			<link type="text/css" rel="stylesheet" href="<?= $file; ?>" />
	<?php endforeach;
	} ?>


	<link rel="stylesheet" href="<?= base_url("assets/plugins/bootstrap/css/bootstrap.min.css") ?>">
	<link rel="stylesheet" href="<?= base_url("assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css") ?>" />
	<link rel="stylesheet" href="<?= base_url("assets/plugins/morrisjs/morris.min.css") ?>" />
	<!-- Custom Css -->
	<link href="<?= base_url("assets/libs/jquery-toast/jquery.toast.min.css") ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?= base_url("assets/css/custom.css") ?>" type="text/css" />
	<link rel="stylesheet" href="<?= base_url("assets/css/main.css") ?>">
	<link rel="stylesheet" href="<?= base_url("assets/css/color_skins.css") ?>">

	<!-- LOAD JQUERY FIRST 
	<script src="<?=base_url("assets/js/jquery-3.3.1.min.js")?>"></script>-->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>	
	<!-- CUSTOM STYLES -->
	<?php
	if (isset($styles)) {
		foreach ($styles as $style) {
			echo '<link href="' . $style . '" rel="stylesheet" type="text/css" />';
		} //foreach
	} //if scripts
	?>
</head>

<body class="theme-cyan">
	<script>
		const BASE_URL = '<?= base_url() . '/' ?>';
	</script>
	<script type="text/javascript">
		var PERMISOS = '<?= $permisos ?>';
		if (PERMISOS) {
			PERMISOS = JSON.parse(PERMISOS);
		}
	</script>
	<!-- Page Loader -->
	<?php if (ENVIRONMENT == 'production') { ?>
		<div class="page-loader-wrapper">
			<div class="loader">
				<div class="m-t-30"><img class="zmdi-hc-spin" src="<?= base_url("assets/images/monedaAlianza.svg") ?>" width="48" height="48" alt="Compass"></div>
				<p>Cargando...</p>
			</div>
		</div>
	<?php } ?>
	<!-- Overlay For Sidebars -->
	<div class="overlay"></div>

	<!-- Top Bar -->
	<nav class="navbar">
		<div class="col-12">
			<div class="navbar-header">
				<a href="javascript:void(0);" class="bars"></a>
				<a class="navbar-brand" href="<?= base_url('Usuario/index') ?>"><img src="<?= base_url('assets/images/logo_horizontal.png') ?>" width="140"></a>
			</div>
			<ul class="nav navbar-nav navbar-left">
				<li><a href="javascript:void(0);" class="ls-toggle-btn" data-close="true"><i class="zmdi zmdi-swap"></i></a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<!------------ Notifications ----------->
				<?php if (file_exists($notificaciones)) require($notificaciones); ?>
				<!--<li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-flag"></i>
						<div class="notify"><span class="heartbit"></span><span class="point"></span></div>
					</a>
					<ul class="dropdown-menu dropdown-menu-right slideDown">
						<li class="header">TASKS</li>
						<li class="body">
							<ul class="menu tasks list-unstyled">
								<li> <a href="javascript:void(0);">
										<div class="progress-container progress-primary">
											<span class="progress-badge">Footer display issue</span>
											<div class="progress">
												<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100" style="width: 86%;">
													<span class="progress-value">86%</span>
												</div>
											</div>
										</div>
									</a>
								</li>
								<li> <a href="javascript:void(0);">
										<div class="progress-container progress-info">
											<span class="progress-badge">Answer GitHub questions</span>
											<div class="progress">
												<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
													<span class="progress-value">35%</span>
												</div>
											</div>
										</div>
									</a>
								</li>
								<li> <a href="javascript:void(0);">
										<div class="progress-container progress-success">
											<span class="progress-badge">Solve transition issue</span>
											<div class="progress">
												<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100" style="width: 72%;">
													<span class="progress-value">72%</span>
												</div>
											</div>
										</div>
									</a>
								</li>
								<li><a href="javascript:void(0);">
										<div class="progress-container">
											<span class="progress-badge"> Create new dashboard</span>
											<div class="progress">
												<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
													<span class="progress-value">45%</span>
												</div>
											</div>
										</div>
									</a>
								</li>
								<li> <a href="javascript:void(0);">
										<div class="progress-container progress-warning">
											<span class="progress-badge">Panding Project</span>
											<div class="progress">
												<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="29" aria-valuemin="0" aria-valuemax="100" style="width: 29%;">
													<span class="progress-value">29%</span>
												</div>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</li>
						<li class="footer"><a href="javascript:void(0);">View All</a></li>
					</ul>
				</li>-->
				<li><a href="<?= base_url('Access/logOut') ?>" class="mega-menu" data-close="true"><i class="zmdi zmdi-power"></i></a></li>
			</ul>
		</div>
	</nav>

	<!-- Left Sidebar -->
	<aside id="leftsidebar" class="sidebar">
		<div class="menu">
			<ul class="list">
				<li>
					<div class="user-info">
						<div class="image"><a href="#"><img src="<?= fotoPerfil(encryptDecrypt('encrypt', session("id"))); ?>" alt="Usuario"></a></div>
						<div class="detail">
							<h6><?= output(session('name')); ?></h6>
							<small><?= session('nombrePuesto'); ?></small>
						</div>
						<!--<a href="events.html" title="Events"><i class="zmdi zmdi-calendar"></i></a>
						<a href="contact.html" title="Contact List"><i class="zmdi zmdi-account-box-phone"></i></a>
						<a href="chat.html" title="Chat App"><i class="zmdi zmdi-comments"></i></a>-->
						<a href="<?= base_url('Usuario/miPerfil'); ?>" title="Mi Perfil"><i class="zmdi zmdi-account"></i></a>
						<a href="<?= base_url('Access/logOut') ?>" title="Cerrar Sesión"><i class="zmdi zmdi-power"></i></a>
					</div>
				</li>
				<!-- Navigation -->
				<?php require($navigation); ?>
			</ul>
		</div>
	</aside>

	<!-- Main Content -->
	<section class="content">
		<div class="block-header">
			<div class="row">
				<div class="col-lg-7 col-md-6 col-sm-12">
					<h2><?php if (isset($title)) echo $title ?></h2>
				</div>
				<div class="col-lg-5 col-md-6 col-sm-12">
					<ul class="breadcrumb float-md-right">
						<?php if (isset($breadcrumb))
							foreach ($breadcrumb as $item) { ?>
							<li class="breadcrumb-item <?= $item['class'] ?>"><a href="<?= $item['link'] ?>"><?= $item['titulo'] ?></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="container-fluid">