<?php
defined('FCPATH') or die("Acceso denegado.");
if (!isset($error)) $error = '';
if (!isset($username)) $username = '';
?>
<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>PEOPLE</title>
    <!-- Favicon-->
    <link rel="icon" href="<?= base_url("favicon.ico") ?>" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/bootstrap/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/main.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/authentication.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/color_skins.css") ?>">
</head>

<body class="theme-cyan authentication sidebar-collapse">
    <div class="page-header">
        <div class="page-header-image" style="background-image:url(<?= base_url("assets/images/login.jpg") ?>)"></div>
        <div class="container">
            <div class="col-md-12 content-center">
                <div class="card-plain">
                    <form action="<?= base_url("Access/logIn") ?>" class="form" role="form" method="post" autocomplete="off">
                        <div class="header">
                            <div class="logo-container">
                                <img src="<?= base_url("assets/images/logo_horizontal.png") ?>" alt="">
                            </div>
                        </div>
                        <?php if (isset($error) && !empty($error)) echo '<div class="error" style="margin-bottom:10px;">'.$error.'</div>'; ?>
                        <div class="content">
                            <div class="input-group input-lg">
                                <input type="text" name="username" id="username" class="form-control" style="height: auto;" placeholder="Usuario">
                                <span class="input-group-addon" style="border-bottom-left-radius: 0; border-top-left-radius: 0;">
                                    <i class="zmdi zmdi-account-circle"></i>
                                </span>
                            </div>
                            <div class="input-group input-lg">
                                <input type="password" name="password" id="password" placeholder="Contraseña" class="form-control" style="height: auto;" />
                                <span class="input-group-addon" style="border-bottom-left-radius: 0; border-top-left-radius: 0;">
                                    <i class="zmdi zmdi-lock"></i>
                                </span>
                            </div>
                        </div>
                        <div class="footer text-center">
                            <button type="submit" class="btn l-cyan btn-round btn-lg btn-block waves-effect waves-light">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <div class="copyright">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>,
                    <span><a href="#" style="color:yellow !important;">Caja Popular Sahuayo</a></span>
                </div>
            </div>
        </footer>
    </div>

    <!-- Jquery Core Js -->
    <script src="<?= base_url("assets/bundles/libscripts.bundle.js") ?>"></script>
    <script src="<?= base_url("assets/bundles/vendorscripts.bundle.js") ?>"></script> <!-- Lib Scripts Plugin Js -->

    <script>
        $(".navbar-toggler").on('click', function() {
            $("html").toggleClass("nav-open");
        });
        //=============================================================================
        $('.form-control').on("focus", function() {
            $(this).parent('.input-group').addClass("input-group-focus");
        }).on("blur", function() {
            $(this).parent(".input-group").removeClass("input-group-focus");
        });
    </script>
</body>

</html>