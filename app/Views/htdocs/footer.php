</div>
</section>
<!-- Jquery Core Js -->
<script src="<?= base_url("assets/bundles/libscripts.bundle.js") ?>"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
<script src="<?= base_url("assets/bundles/vendorscripts.bundle.js") ?>"></script> <!-- slimscroll, waves Scripts Plugin Js -->
<script src="<?= base_url("assets/bundles/mainscripts.bundle.js") ?>"></script>

<?php
//GROCERY CRUD JS
if (isset($js_files)) {
    foreach ($js_files as $file) : ?>

        <script src="<?php echo $file; ?>"></script>
<?php endforeach;
} ?>
<?php

//CUSTOM SCRIPTS
if (isset($scripts)) {
    foreach ($scripts as $script) {
        echo '<script src="' . $script . '" type="text/javascript"></script>';
    } //foreach
} //if scripts
?>

<!-- App js -->
<script src="<?= base_url("assets/libs/jquery-toast/jquery.toast.min.js") ?>"></script>
<script src="<?= base_url('assets/plugins/push/serviceWorker.min.js') ?>"></script>
<script src="<?= base_url("assets/plugins/bootstrap-notify/bootstrap-notify.js")?>"></script> <!-- Bootstrap Notify Plugin Js -->
<!--Sonido notificacion-->
<!--<script src='https://code.jquery.com/jquery-2.2.0.min.js'></script>
<script src='https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js'></script>-->
<script src="<?= base_url('assets/js/notificaciones.js') ?>"></script>

<script type="text/javascript">
    <?php if (isset($_SESSION['response'])) { ?>
        $.toast({
            text: "<?= $_SESSION['txttoastr'] ?>",
            icon: "<?= $_SESSION['response'] ?>",
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose: true,
        });
    <?php } //if 
    ?>

    function revisarPermisos(accion, funcion) {
        return (jQuery.inArray(accion, PERMISOS[funcion]) >= 0) ? true : false;
    }
</script>
</body>

</html>