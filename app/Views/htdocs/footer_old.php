</div> <!-- end container-fluid -->

</div> <!-- end content -->

<!-- Right Sidebar -->
<!-- end Right Sidebar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Footer Start -->
<footer class="footer">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">

			</div>
		</div>
	</div>
</footer>
<!-- end Footer -->

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Vendor js -->
<script src="<?=base_url("assets/js/vendor.min.js")?>"></script>

<?php
//GROCERY CRUD JS
if(isset($js_files)){
	foreach($js_files as $file): ?>

		<script src="<?php echo $file; ?>"></script>
	<?php endforeach; }?>
<?php

//CUSTOM SCRIPTS
if (isset($scripts)) {
	foreach ($scripts as $script) {
		echo '<script src="'.$script.'" type="text/javascript"></script>';
	}//foreach
}//if scripts
?>

<!-- App js -->
<script src="<?=base_url("assets/libs/jquery-toast/jquery.toast.min.js")?>"></script>

<script src="<?=base_url('assets/plugins/push/push.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/push/serviceWorker.min.js')?>"></script>
<script src="<?=base_url("assets/js/app.min.js")?>"></script>

<!--Sonido notificacion-->
<!--<script src='https://code.jquery.com/jquery-2.2.0.min.js'></script>
<script src='https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js'></script>-->
<script src="<?=base_url('assets/js/notificaciones.js')?>"></script>
<?php /*if (isSolicitanteMesa()) {?>
<script src="<?=base_url('assets/js/mesadeayuda/notificaciones.js')?>"></script>
<?php } */?>



<script type="text/javascript">
    <?php if (isset($_SESSION['response'])){ ?>
    $.toast({
        text: "<?=  $_SESSION['txttoastr']?>",
        icon: "<?=  $_SESSION['response']?>",
        loader: true,
        loaderBg: '#c6c372',
        position : 'top-right',
        allowToastClose : true,
    });
    <?php }//if ?>

    if(window.location.pathname !== '/sahuayo/Usuario/index' && window.location.pathname !== '/Usuario/index'){
        this.$('body').toggleClass('enlarged');
    }

    function revisarPermisos(accion,funcion) {
        return (jQuery.inArray(accion, PERMISOS[funcion]) >= 0) ? true:false;
    }
</script>
</body>
</html>
