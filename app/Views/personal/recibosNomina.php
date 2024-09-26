<link href="<?= base_url("assets/plugins/fileinput/css/fileinput.css") ?>" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.css") ?>" media="all" rel="stylesheet" type="text/css" />
<script src="<?= base_url("assets/plugins/fileinput/js/fileinput.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/js/locales/es.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/fas/theme.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.js") ?>" type="text/javascript"></script>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Importar recibos de nómina</h4>
                <form id="formRecibos" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-md-6" style="padding-bottom: 1%">
                            <label>
                                * Año:
                            </label>
                            <input name="year" id="year" class="form-control datepicker" placeholder="Seleccione ">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="quincena">* Quincena </label>
                            <input type="text" class="form-control numeric" name="quincena" id="quincena" placeholder="Número de la quincena " required>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="file-loading">
                            <input id="fileZip" name="fileZip[]" type="file" class="file" multiple>
                        </div>
                    </div>
                </form>
                <div class="text-right col-md-12">
                    <a href="#" id="btnSubirRecibos" class="btn btn-success btn-round">Guardar</a>
                </div>
            </div> <!-- end card-box -->
        </div>
    </div> <!-- end col-->
</div>

<!--Ver agregados-->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-box">
                <h4 class="header-title">Quincenas importadas</h4>
                <div id="checklistEgreso"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#fileZip').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['zip'],
        dropZoneEnabled: false,
        showUpload: false,
    });
</script>