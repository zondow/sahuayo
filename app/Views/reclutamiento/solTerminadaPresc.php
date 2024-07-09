<!-- ======== HEDER ========= -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Thigo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?=base_url("assets/images/thigo/1.ico")?>"/>

    <!-- App css -->
    <link href="<?=base_url("assets/css/bootstrap.css")?>"  rel="stylesheet" type="text/css"/>
    <link href="<?=base_url("assets/css/icons.min.css")?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url("assets/libs/jquery-toast/jquery.toast.min.css")?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url("assets/css/app.css")?>" rel="stylesheet" type="text/css" />

    <!-- LOAD JQUERY FIRST -->
    <script src="<?=base_url("assets/js/jquery-3.3.1.min.js")?>"></script>
</head>

<body>
<!-- Begin page -->
<div id="wrapper">

    <!-- Main -->
    <div class="content">

        <div class="container-fluid" >
            <div class="row">
                <div class="col-12 survey-app p-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-dark rounded" role="alert">
                                <br>
                                <p class="lead" style="text-align: center;vertical-align: center;padding-bottom: 4px">¡Gracias por su interes!<br>La requisición de personal ya está finalizada. No se pueden realizar más registros de candidatos.</p>
                            </div>
                        </div>
                        <div class="card-body" style="text-align: right">
                            <hr>
                            <b>Por favor cierre esta pestaña.</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======== FOOTER ========= -->
    </div> <!-- end container-fluid -->

</div> <!-- end wrapper -->


<!-- Vendor js -->
<script src="<?=base_url("assets/js/vendor.min.js")?>"></script>

<?php
//GROCERY CRUD JS
if(isset($js_files)){
    foreach($js_files as $file): ?>

        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; }?>
<!-- App js -->
<script src="<?=base_url("assets/libs/jquery-toast/jquery.toast.min.js")?>"></script>
<script src="<?=base_url("assets/js/app.min.js")?>"></script>
</body>
</html>
