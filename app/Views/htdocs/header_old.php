<?php defined('FCPATH') OR exit('No direct script access allowed');
$db = \Config\Database::connect();
if (!isset($title)) $title = 'Inicio';
//Get session data
$name = output(session('name'));
$photo = fotoPerfil(encryptDecrypt('encrypt',session("id")));
$puesto = session('puesto');
$nombrePuesto = session('nombrePuesto');

// Notificaciones
$notificaciones = APPPATH.'Views/htdocs/notif.php';
// Mensajes
$mensajes = APPPATH.'views/htdocs/mensajes.php';
//Reporte Incicencias
$perfil = "#";
$disUsuario = session("disponibilidad");
$disponibilidadUsuario = disponibilidadUsuario($disUsuario);
$permisos = session('permisos');

if (session('type') === 'usuario'){ // Usuario
    $perfil = base_url("Usuario/miPerfil");
	$navigation = APPPATH."Views/usuario/navigation.php";
}else{
    $navigation = APPPATH."Views/usuario/navigation.php";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Thigo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<!-- App favicon -->
	<link rel="shortcut icon" href="<?=base_url("assets/images/thigo/1.ico")?>"/>

	<!-- GC CSS FILES -->
	<?php
	if(isset($css_files)){
		foreach($css_files as $file): ?>
			<link type="text/css" rel="stylesheet" href="<?= $file; ?>" />
		<?php endforeach; }?>

    <!-- CUSTOM STYLES -->
    <?php
    if (isset($styles)) {
        foreach ($styles as $style) {
            echo '<link href="'.$style.'" rel="stylesheet" type="text/css" />';
        }//foreach
    }//if scripts
    ?>


	<!-- App css -->
	<link href="<?=base_url("assets/css/bootstrap.css")?>"  rel="stylesheet" type="text/css"/>
	<link href="<?=base_url("assets/css/icons.min.css")?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url("assets/libs/jquery-toast/jquery.toast.min.css")?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url("assets/css/app.css")?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=base_url("assets/css/custom.css")?>" type="text/css" />
    <link rel="stylesheet" href="<?=base_url("assets/css/disponibilidad.css")?>" type="text/css" />

    <!-- LOAD JQUERY FIRST -->
	<script src="<?=base_url("assets/js/jquery-3.3.1.min.js")?>"></script>
</head>

<body>

<script>const BASE_URL = '<?=base_url().'/'?>'; </script>
<script type="text/javascript">
    var PERMISOS = '<?=$permisos?>';
    if(PERMISOS){
        PERMISOS = JSON.parse(PERMISOS);
    }
</script>
<!-- Begin page -->
<div id="wrapper">
		<?php if(date('m-d')>='12-23' && date('m-d')<='12-31'){ ?>
		<div class="snowflakes" aria-hidden="true">
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
			<div class="snowflake">
				<div class="inner">❅</div>
			</div>
		</div>
		<?php } ?>

	<!-- ========== Left Sidebar Start ========== -->
	<div class="left-side-menu">

		<div class="slimscroll-menu">

			<!-- LOGO -->
			<div class="logo-box">
				<a href="#" class="logo">
					<span class="logo-lg">
						<img src="<?=base_url("assets/images/thigo/RECURSOS HUMANOS - ORIGINAL.png")?>" alt="" height="68">
					</span>
					<span class="logo-sm">
						<img src="<?= base_url("assets/images/thigo/1.png") ?>" alt="" height="30">
					</span>
				</a>
			</div>

			<!-- User box -->
			<div class="user-box">
                <img src="<?=$photo?>" alt="user-img" title="Mat Helme" class="rounded-circle" height="48" width="48">
                <div class="dropdown">
					<a href="<?=$perfil?>" class="text-dark h5 mt-2 mb-1 d-block" ><h6><?= $name ?></h6></a>
				</div>
				<p class="text-muted"><?= $nombrePuesto ?></p>
			</div>

			<!-- SIDEBAR MENÚ -->
			<?php require($navigation); ?>

			<div class="clearfix"></div>

		</div>
		<!-- Sidebar -left -->

	</div>
	<!-- Left Sidebar End -->

	<!-- ============================================================== -->
	<!-- Start Page Content here -->
	<!-- ============================================================== -->

	<div class="content-page">

		<!-- Topbar Start -->
		<div class="navbar-custom">

			<ul class="list-unstyled topnav-menu float-right mb-0">
                <!--<li class="dropdown notification-list">
                    <div class="nav-link btn-group-vertical">
                        <button type="button" class="btn btn btn-outline-info btn-rounded waves-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">
                            <i class=" icon-screen-desktop pr-1"></i>Home office
                            <i class="mdi mdi-chevron-down"></i></span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                            <a class="dropdown-item btnAsistenciaHomeOffice" data-tipo="Entrada" style="line-height: normal !important;" href="#">
                                <i class="icon-login pr-2" style="color: #00e800;"></i>Entrada
                            </a>
                            <a class="dropdown-item btnAsistenciaHomeOffice" data-tipo="Salida" style="line-height: normal !important;" href="#">
                                <i class="icon-logout pr-2" style="color: red;"></i>Salida
                            </a>
                        </div>
                    </div>
                </li>-->

                <!------------ Notifications ----------->

				<?php
                //if(file_exists($notificaciones)) require($notificaciones);
                ?>

                <!--------------- User  ----------->
				<li class="dropdown notification-list">
					<a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="<?=$photo?>" alt="user-image" class="rounded-circle">
						<span class="pro-user-name ml-1">
								<i class="<?=$disponibilidadUsuario?>"></i><?= $name ?><i class="mdi mdi-chevron-down"></i>
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
						<!-- item-->
						<div class="dropdown-item noti-title">
                            <h6 class="text-overflow m-0">Bienvenido!</h6>
						</div>

						<!-- item-->
						<a href="<?=$perfil?>" class="dropdown-item notify-item">
							<i class="fe-user"></i><span>Mi Cuenta</span>
						</a>
                        <!--<a id="btnDisponibilidadUser" class="dropdown-item notify-item" href="#">
                            <i class="fe-edit"></i><span>Estado</span>
                        </a>-->

                        <!-- item-->
						<a href="<?= base_url("Access/logOut") ?>" class="dropdown-item notify-item">
							<i class="fe-log-out"></i><span>Cerrar Sesión</span>
						</a>

					</div>
				</li>

                <!------------ Mensajes ----------->
                <?php

/*                    if (file_exists($mensajes)) require($mensajes); */?>



			</ul>


			<ul class="list-unstyled topnav-menu topnav-menu-left m-0">
				<li>
					<button class="button-menu-mobile disable-btn" style="display: block;">
						<i class="fe-menu"></i>
					</button>
				</li>
				<li>
					<h4 class="page-title-main"><?php if(isset($title)) echo $title ?></h4>
					<ol class="breadcrumb ">
						<?php if(isset($breadcrumb))
							foreach ($breadcrumb as $item){ ?>
						<li class="breadcrumb-item"><a href="<?=$item['link']?>"><?=$item['titulo']?></a></li>
						<?php } ?>
					</ol>
				</li>

			</ul>
			<br>

		</div>


        <div class="modal fade in" id="modalDisponibilidadUsuario" style="background-color:rgba(10, 10, 10, 0.5);">
            <div class="modal-dialog modal-ls">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><b class="iconsminds-pen-2"></b><strong>Estado</strong></h4>
                        <button class="close" type="button" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <select id="selectDisUser" class="form-control select2" data-placeholder="Seleccionar estado" style="width: 100%!important;">
                                    <option value=""></option>
                                    <option value="En línea"><i class="dot dot-linea"></i>En línea</option>
                                    <option value="Ausente">Ausente</option>
                                    <option value="Home office">Home office</option>
                                    <option value="En reunión">En reunión</option>
                                    <option value="De vacaciones">De vacaciones</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <button id="btnSaveDisUser" type="button" class="btn btn-success"><i class=" fas fa-save"></i>&nbsp;Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main -->
		<div class="content">


			<!-- Start Content-->
			<div class="container-fluid">









