<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>

    .dtp div.dtp-date, .dtp div.dtp-time{
        background-color: #001689 !important;
    }
    .dtp > .dtp-content > .dtp-date-view > header.dtp-header {
        background-color: #001689 !important;
    }

</style>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">

            <div class="row">
                <?php
                if(revisarPermisos('Agregar',$this)) {?>
                <div class="mb-2 col-md-2 text-left" >
                    <a href="#" class="btn btn-success waves-effect waves-light modalProveedores" ><i class="mdi mdi-plus"></i> Agregar </a>

                </div>
                <?php } ?>
            </div>
            <div class="table-responsive">
                <table id="datatableProveedores" class="table mt-4 table-hover m-0 table-centered tickets-list table-actions-bar ">
                    <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>Proveedor</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Institucion</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($proveedores as $proveedor){ ?>
                        <tr>
                            <td>
                            <?php
                            if(revisarPermisos('Editar',$this)) {
                                echo '<a type = "button" class="btn btn-info waves-effect waves-light editarProveedor" data-id = "'.$proveedor['pro_ProveedorID'].'" style = "color:#FFFFFF" ><i class="fa fa-edit" ></i > </a >';
                            }
                            ?>
                            </td>
                            <td><?=$proveedor['pro_Nombre']?></td>
                            <td><?=$proveedor['pro_Correo']?></td>
                            <td><?=$proveedor['pro_Telefono']?></td>
                            <td><?=$proveedor['pro_Institucion']?></td>
                            <?php
                            if(revisarPermisos('Baja',$this)) {
                                if ($proveedor['pro_Estatus'] == 1) {
                                    $estatus = '<a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" title="Click para cambiar estatus" href="' . base_url("Formacion/estatusProveedor/0/" . encryptDecrypt('encrypt',$proveedor['pro_ProveedorID'])) . '" >Activo</a>';
                                } else {
                                    $estatus = '<a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0"  title="Click para cambiar estatus" href="' . base_url("Formacion/estatusProveedor/1/" . encryptDecrypt('encrypt',$proveedor['pro_ProveedorID'])) . '" >Inactivo</a>';
                                }
                            }else{
                                if ($proveedor['pro_Estatus'] == 1) {
                                    $estatus = '<a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" href="#" style="color: #ffffff;padding: 3.5%;font-size: 10px">Activo</a>';
                                } else {
                                    $estatus = '<a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0"  href="#" >Inactivo</a>';
                                }
                            }
                            ?>
                            <td><?=$estatus?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>
<!--Modales-->
<div class="modal fade in" id="modalProv" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-next"></b> Proveedor</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?=base_url('Formacion/addProveedor')?>" id="formProveedores" name="formProveedores"  method="post" autocomplete="off">
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                * Nombre:
                            </label>
                            <input name="pro_Nombre" id="pro_Nombre" placeholder="Escriba el nombre" class="form-control" required>
                            <input name="pro_ProveedorID" id="pro_ProveedorID" hidden>
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                * Institución:
                            </label>
                            <input name="pro_Institucion" id="pro_Institucion" placeholder="Escriba la Institución"  class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                * Correo:
                            </label>
                            <input name="pro_Correo" id="pro_Correo" placeholder="Escriba el correo"  class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                * Teléfono:
                            </label>
                            <input name="pro_Telefono" id="pro_Telefono" placeholder="Escriba el teléfono" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="updatePT" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Modales-->

<script>
    $(document).ready(function(e) {
        $(".select2").select2();
        $("#datatableProveedores").DataTable({
            language:
                {
                    paginate: {
                        previous:"<i class='zmdi zmdi-caret-left'>",
                        next:"<i class='zmdi zmdi-caret-right'>"
                    },
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla.",
                    "sInfo":           "",
                    "sInfoEmpty":      "",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "<i class='zmdi zmdi-caret-right'>",
                        "sPrevious": "<i class='zmdi zmdi-caret-left'>"
                    },
                },
            dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Catalogo de proveedores',
                    text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                    titleAttr: "Exportar a excel",
                    className: "btn l-slategray",
                    autoFilter: true,
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Catalogo de proveedores',
                    text: '<i class="fa fa-file-pdf-o"></i>&nbsp;PDF',
                    titleAttr: "Exportar a PDF",
                    className: "btn l-slategray",
                    orientation: 'landscape',
                    pageSize: 'LETTER',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Columnas',
                    className: "btn btn-light",
                }
            ],
        });

        $("body").on("click", ".modalProveedores", function (evt) {
            evt.preventDefault();
            $("#formProveedores")[0].reset();
            $("#modalProv").modal("show");
        });

        $("body").on("click", ".editarProveedor", function (evt) {
            evt.preventDefault();
            $("#formProveedores")[0].reset();
            let proveedorID = $(this).data('id');
            $.ajax({
                url: BASE_URL + "Formacion/ajax_getInfoProveedor/"+proveedorID ,
                type: "POST",
                async:true,
                cache:false,
                dataType: "json"
            }).done(function (data){

                if(data.response === "success"){
                    $("#pro_ProveedorID").val(data.result.pro_ProveedorID);
                    $("#pro_Nombre").val(data.result.pro_Nombre);
                    $("#pro_Correo").val(data.result.pro_Correo);
                    $("#pro_Telefono").val(data.result.pro_Telefono);
                    $("#pro_Institucion").val(data.result.pro_Institucion);
                }
            }).fail(function () {
                $.toast({
                    text: "Ocurrido un error, por favor intente nuevamente.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            });
            $("#modalProv").modal("show");
        });

    });
</script>