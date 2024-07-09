<?php
defined('FCPATH') or die("Acceso denegado.");
if (!isset($error)) $error = '';
if (!isset($username)) $username = '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!--Titulo -->
    <title>Thigo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url("assets/images/thigo/1.ico") ?>" />

    <!-- App css -->
    <link rel="stylesheet" href="<?= base_url("assets/css/bootstrap.css") ?>" type="text/css" />
    <link rel="stylesheet" href="<?= base_url("assets/css/icons.min.css") ?>" type="text/css" />
    <link rel="stylesheet" href="<?= base_url("assets/css/app.css") ?>" type="text/css" />
    <link rel="stylesheet" href="<?= base_url("assets/css/login.css") ?>" type="text/css" />
</head>

<body>
    <!-- Begin page -->
    <div class="accountbg" style="background: url(<?= base_url('assets/images/FONDOTHIGO.png') ?>) ;background-size: cover;  "></div>
    <div class="account-pages  mt-4 pt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card" style="border-color: #5a6770 !important;border-radius: 5%; border-width:2px">
                        <div class="card-body">
                            <div class="">
                                <h4 class="text-uppercase text-center ">
                                    <a href="#" class="text-success">
                                        <span><img src="<?= base_url('assets/images/thigo/RECURSOS HUMANOS - ORIGINAL.png') ?>" alt="" height="100"></span>
                                    </a>
                                </h4>
                                <form action="<?= base_url("Access/logIn") ?>" class="form" role="form" method="post" autocomplete="off">
                                    <?php if (isset($error) && !empty($error)) { ?>
                                        <div class="error"><?= $error ?></div>
                                    <?php } //if 
                                    ?>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="username">* Usuario</label>
                                            <input class="form-control" type="text" name="username" id="username" required="" placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <!--<a href="<?= base_url('Access/recuperar') ?>" class="text-muted float-right" style="color:#1d9add !important"><small>¿Olvidaste tu contraseña?</small></a>-->
                                            <label for="password">* Contraseña</label>
                                            <input class="form-control" name="password" type="password" required="" id="password" placeholder="">
                                        </div>
                                    </div>

                                    <br>
                                    <div class="form-group row text-center">
                                        <div class="col-12">
                                            <button class="btn btn-block btn-success waves-effect waves-light" style="background-color: #001689;border:#001689" type="submit">ENTRAR</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4 text-center">
                                <span><img src="<?= base_url('assets/images/monedaAlianza.png') ?>" alt="" height="50"></span>
                            </div>
                            <div class="col-4"></div>
                        </div>
                        </div>
                        
                        <div class=" text-center pt-3">
                            <p class="account-copyright"><?= date('Y') ?> © Alianza Cajas Populares. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="<?= base_url('assets/js/vendor.min.js') ?>"></script>

    <!-- App js -->
    <script src="<?= base_url('assets/js/app.min.js') ?>"></script>

</body>

</html>