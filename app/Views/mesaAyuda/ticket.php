<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<link href="<?= base_url("assets/plugins/fileinput/css/fileinput.css") ?>" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.css") ?>" media="all" rel="stylesheet" type="text/css" />
<script src="<?= base_url("assets/plugins/fileinput/js/fileinput.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/js/locales/es.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/fas/theme.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.js") ?>" type="text/javascript"></script>



<div class="row mb-2">
    <div class="col-lg-12">
        <div class="card-box ">
            <div class="row" id="resEncuesta">
                <div class="col-md-12 text-right">
                    <a href="#" class="btn btn-purple waves-light btn-sm waves-effect btnEncuesta" data-id="<?= encryptDecrypt('encrypt', $ticket['tic_TicketID']) ?>">Resultados encuesta</a>
                </div>
            </div>
            <div class="media mt-0  mb-1">
                <img class="d-flex mr-3 rounded-circle" alt="moneda" src="<?= base_url("assets/images/monedaAlianza.png") ?>" style="width: 56px; height: 56px;">
                <div class="media-body">
                    <h4 class="media-heading mb-1 "><span class="badge badge-info"># <?= $ticket['tic_TicketID'] ?></span> <?= strtoupper($ticket['tic_Titulo']) ?></h4>
                    <p><?= strtoupper(eliminar_acentos($ticket['are_Nombre'])) ?> - <?= strtoupper(eliminar_acentos($ticket['ser_Servicio'])) ?></p>
                    <?php switch ($ticket['tic_Estatus']) {
                        case 'ABIERTO':
                            $color = 'badge-info';
                            $titulo = 'ABIERTO';
                            break;
                        case 'ESPERA_SOLICITANTE':
                            $color = 'badge-warning';
                            $titulo = 'SE REQUIERE INFORMACIÓN';
                            break;
                        case 'ESPERA_PROVEEDOR':
                            $color = 'badge-warning';
                            $titulo = 'EN ESPERA DEL PROVEEDOR';
                            break;
                        case 'RESUELTO':
                            $color = 'badge-success';
                            $titulo = 'RESUELTO';
                            break;
                        case 'CERRADO':
                            $color = 'badge-danger';
                            $titulo = 'CERRADO';
                            break;
                    } ?>
                    <span class="badge <?= $color ?>"><?= $titulo ?></span>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-6">
                    <label class="font-16">Agente </label>
                    <p> <?php $agente = 'Sin agente asignado';
                        if ($ticket['tic_AgenteResponsableID']) {
                            $empleadoID = mesa()->query("SELECT age_EmpleadoID FROM agente WHERE age_AgenteID=?", array($ticket['tic_AgenteResponsableID']))->getRowArray()['age_EmpleadoID'];
                            $agente = federacion()->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID=?", array($empleadoID))->getRowArray()['emp_Nombre'];
                        }
                        echo $agente; ?></p>
                </div>
                <div class="col-lg-6">
                    <label class="font-16">Solicitante </label>
                    <p> <?= $ticket['usu_Nombre'] ?></p>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-4">
                    <label class="font-16">Fecha de registro </label>
                    <p><span class="badge badge-dark p-1"><?= strtoupper(longDateTime($ticket['tic_FechaHoraRegistro'], ' de ')) ?></span></p>
                </div>
                <div class="col-lg-4">
                    <label class="font-16">Fecha de entrega propuesta </label>
                    <p><span class="badge badge-dark p-1"><?= ($ticket['tic_FechaTerminoPropuesta'] !== null) ? strtoupper(longDateTime($ticket['tic_FechaTerminoPropuesta'], ' de ')) : 'PENDIENTE DE ASIGNAR'; ?></span></p>
                </div>
                <div class="col-lg-4">
                    <?= ($ticket['tic_FechaHoraTermino'] !== null) ? '<label class="font-16">Fecha de entrega real</label><p><span class="badge badge-dark p-1">' . strtoupper(longDateTime($ticket['tic_FechaHoraTermino'], ' de ')) . '</span></p>' : ''; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <label class="font-16">Descripción </label>
                </div>
                <div class="col-md-12"><?= $ticket['tic_Descripcion'] ?></div>
            </div>
            <?php
            if ($ticket['tic_File']) {
                $files = filesTicket(encryptDecrypt('encrypt',$ticket['tic_TicketID']));
                if($files){
                    $archivos = '<div class="col-lg-12"><label style="font-size:13px !important ;">Archivos adjuntos</label><div class="files-list">';
                    foreach ($files as $file) {
                        $icon = iconExtension($file['extension']);
                        $archivos .= '<div class="file-box">
                                        <a href="' . $file['url'] . '" target="_blank" ><img src="' . $icon . '" class="img-responsive img-thumbnail" alt="attached-img" ></a>
                                        <p class="font-13 mb-1 text-muted"><small>' . substr($file['nombre'], 0, 10) . '</small></p>
                                    </div>';
                    }
                    $archivos .= '</div></div>';
                    echo $archivos;
                }
            }
            ?>
        </div>
        <div class="" id="divComentarios">

        </div>
        <div class="card-box">
            <h4 class="header-title " id="totalComentarios"></h4>
            <div>
                <div class="media">
                    <?php if ($ticket['tic_Estatus'] !== 'CERRADO' && $ticket['tic_Estatus'] !== 'RESUELTO') { ?>
                        <div class="d-flex mr-3">
                            <a> <img class="media-object rounded-circle avatar-sm" alt="64x64" src="<?= fotoPerfil(encryptDecrypt('encrypt',session('id')))?>"> </a>
                        </div>
                    <?php } ?>
                    <div class="media-body">
                        <form id="formCometario" method="post" autocomplete="off" enctype="multipart/form-data">
                            <input id="comt_TicketID" name="comt_TicketID" hidden value="<?= encryptDecrypt('encrypt', $ticket['tic_TicketID']) ?>">
                            <?php if ($ticket['tic_Estatus'] !== 'CERRADO' && $ticket['tic_Estatus'] !== 'RESUELTO' && $ticket['tic_UsuarioID']==usuarioID()) { ?>
                                <div class="row">
                                    <div class=" col-md-12">
                                        <label for="comentarioTicket"><?=  session('nombre') ?></label>
                                        <textarea class="form-control" id="comentarioTicket" name="comentarioTicket" value=''></textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class=" col-md-12">
                                        <label for="archivosTicket" class="col-form-label"> Adjuntar archivo</label>
                                        <input id="archivosTicket" name="archivosTicket[]" type="file" class="file" multiple>
                                        <input id="nombreArchivo" name="nombreArchivo" hidden >
                                        <br>
                                        <label class="col-form-label text-danger ">Si adjuntas archivos recuerda dar click en "Subir archivo" antes de "Responder"</label>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="button" id="saveComentario" class="btn  btn-success waves-effect waves-light">Responder</button>
                                    <div class="offset-11 col-md-1" id="spiner" >
                                        <p>Enviando respuesta</p>
                                        <div class="sk-three-bounce">
                                            <div class="sk-child sk-bounce1"></div>
                                            <div class="sk-child sk-bounce2"></div>
                                            <div class="sk-child sk-bounce3"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else {
                                $mensaje='El ticket se ha <b>'.$ticket['tic_Estatus'].'</b> por lo que no se puede comentar.';
                                if($ticket['tic_UsuarioID']!=usuarioID()){$mensaje = 'No se puede comentar este ticket';}
                                ?>
                                <div class="row">
                                    <div class="form-group col-md-12 text-center">
                                        <div class="alert alert-info" style="font-size: 15px;"><?=$mensaje?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end col -->


<script>
    $('#archivosTicket').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '<?=base_url('MesaAyuda/subirArchivo/'.encryptDecrypt('encrypt', $ticket['tic_TicketID']))?>',
        allowedFileExtensions: ['zip','rar','doc','docx','xls','xlsx','ppt','pptx','pdf','png','jpg','jpeg','gif','msg'],
        maxFileSize:0,
        dropZoneEnabled: false,
        showUpload: true,
        uploadAsync: true,
        overwriteInitial: true
    }).on('fileuploaded', function(event, data, previewId, index) {
        var jsonResponse = data.response;
        var nombreArchivo = $('#nombreArchivo').val();
        if (nombreArchivo == '') {
            $('#nombreArchivo').val(jsonResponse.nombre);
        } else {
            $('#nombreArchivo').val(nombreArchivo + ',' + jsonResponse.nombre);
        }
    });
</script>


