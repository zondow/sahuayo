
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="row">
                        <div class="col-md-12  text-right">
                            <?php if(revisarPermisos('Exportar',$this)){ ?>
                            <a href="<?= base_url("Excel/generarExcelCompetencias") ?>" class="btn l-slategray "><i class="mdi mdi-cloud-download"></i> Exportar</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <?php if(revisarPermisos('Agregar',$this)){ ?>
                            <a href="#" class="btn btn-success waves-light waves-effect mt-2 mb-4 modal-competencias">
                                <i class="dripicons-plus" style="top: 2px !important; position: relative"></i>
                                Agregar
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive datatableComp" cellspacing="0" width="100%" id="tLocales">
                                <thead>
                                <tr>
                                    <th class="w-15"></th>
                                    <th class="w-15">Nombre</th>
                                    <th class="w-45">Descripción</th>
                                    <th class="w-15">Tipo</th>
                                    <th class="w-10">Estatus</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($competenciasLocales)){
                                    $count=0;
                                    foreach ($competenciasLocales as $cLocales){
                                        echo '<tr>';
                                        echo '<td class="text-center ">';
                                        if(revisarPermisos('Editar',$this)) {
                                            echo '<a href="#" class="btn btn-info modal-competencias" data-id="' . $cLocales['com_CompetenciaID'] . '"><i class="fa fa-edit "></i></a>';
                                        }
                                        if(revisarPermisos('Claves',$this)) {
                                            echo '<a href="#" class="btn btn-dark  veraclave" title="Acciones clave" data-id="' . $cLocales['com_CompetenciaID'] . '"><i class="far fa-check-square"></i></a>';
                                        }
                                        echo  '</td>';
                                        echo '<td class="w-15"><b>'.$cLocales['com_Nombre'].'</b></td>';
                                        echo '<td class="w-50"><div class="col-md-12"><p style="text-align: justify">'.$cLocales['com_Descripcion'].'</p></div></td>';
                                        if($cLocales['com_Tipo'] == 'Sociales y Actitudinales'){
                                            echo '<td class="w-15"><label class="badge badge-success">'.$cLocales['com_Tipo'].'</label></td>';
                                        }else {
                                            echo '<td class="w-15"><label class="badge badge-secondary">'.$cLocales['com_Tipo'].'</label></td>';
                                        }
                                        if(revisarPermisos('Baja',$this)) {
                                            switch ($cLocales['com_Estatus']) {
                                                case 0:
                                                    echo '<td class="text-center w-10"><a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0 "  href="' . base_url('Formacion/updateCompetenciaEstatus/' .encryptDecrypt('encrypt', $cLocales['com_CompetenciaID']) . '/'.encryptDecrypt('encrypt', 1)) . '">Inactivo</a></td>';
                                                    break;
                                                case 1:
                                                    echo '<td class="text-center w-10"><a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" href="' . base_url('Formacion/updateCompetenciaEstatus/' . encryptDecrypt('encrypt', $cLocales['com_CompetenciaID']) . '/'.encryptDecrypt('encrypt', 0)) . '">Activo</a></td>';
                                                    break;
                                                default:
                                            }
                                        }else{
                                            switch ($cLocales['com_Estatus']) {
                                                case 0:
                                                    echo '<td><a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0 " href="#">Inactivo</a></td>';
                                                    break;
                                                case 1:
                                                    echo '<td ><a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo"   href="#">Activo</a></td>';
                                                    break;
                                                default:
                                            }
                                        }
                                        echo '</tr>';
                                    }
                                }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(e) {

        $(".datatableComp").DataTable({
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
            /*drawCallback:function(){
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")},*/
            "order": [[ 1, "asc" ]],
            dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Catalogo de competencias',
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
                    title: 'Catalogo de competencias',
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
                    className: "btn l-slategray",
                }
            ],
        });



        /*ACCIONES CLAVE*/

        //Variables
        var $verclave= $('#modalClave');
        var $formCla=$('#formCla');
        var $CompID;

        //Agregar Pregunta
        $("body").on("click",".btnaddClav",function(e){
            e.preventDefault();
            $formCla[0].reportValidity();
            var table = $('#datatableClave').DataTable();

            if ($formCla[0].checkValidity()){
                var clave=$('#txtclave').val();
                var orden=$('#cla_NoOrden').val();
                var data2 = {}
                data2.competenciaID=$CompID;
                data2.clave=clave;
                data2.orden=orden;

                $.ajax({
                    url: BASE_URL + "Formacion/ajax_addAClaveCompetencia/",
                    type: "POST",
                    data: data2,
                    success: function(data){

                        dat=JSON.parse(data);
                        dat=dat.id;

                        table.row.add( [
                            orden,
                            clave,
                            '<button type="button" class="btn btn-icon waves-effect btnDelPre waves-light btn-danger" data-id="'+dat+'"> <i class="fas fa-times"></i> </button>',
                        ] ).draw( false );

                        $.toast({
                            text: "Acción clave agregada",
                            icon: "success",
                            loader: true,
                            loaderBg: '#c6c372',
                            position: 'top-right',
                            allowToastClose : true,
                        });

                    }
                });
            }
            $formCla[0].reset();
        });

        //Alain - Modal ver preguntas
        var flag=0;
        $("body").on("click",".veraclave",function(e){
            e.preventDefault();
            $("#formCla")[0].reset();
            $verclave.modal('show');

            if(flag==1){
                var table = $('#datatableClave').DataTable();
                table.destroy();
            }

            var data2 = {}
            data2.competenciaID=$(this).data('id');

            $CompID=$(this).data('id');


            $.ajax({
                url: BASE_URL + "Formacion/ajax_regresarAccionesClaveCompetencia/",
                type: "POST",
                data: data2,
                success: function(data){

                    dat=JSON.parse(data)
                    dat=dat.acciones;

                    $("#tbodyCla").empty();

                    var contador=0;
                    $.each(dat, function (index, item) {
                        contador++;
                        var row = "<tr>" +
                            "<td>"+item.cla_NoOrden+"</td>" +
                            "<td>"+item.cla_ClaveAccion+"</td>" +
                            "<td>"+'<button type="button" class="btn btn-icon btnDelCla waves-effect waves-light btn-danger" data-id="'+item.cla_ClaveCompetenciaID+'"> <i class="fas fa-times"></i> </button>'+"</td>" +
                            "</tr>";
                        $("#tbodyCla").append(row);

                    });

                    $('#datatableClave').DataTable({
                        "columns": [
                            { "width": "10%" },
                            { "width": "80%" },
                            { "width": "20%" },
                        ],
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
                    });

                    flag=1;

                }
            })


        });

        $("body").on("click",".btnDelCla",function(e){
            e.preventDefault();

            var data2 = {};
            data2.claveID=$(this).data('id');

            var tr=$(this).parents('tr');

            $.ajax({
                url: BASE_URL + "Formacion/ajax_borrarAccionClaveCompetencia/",
                type: "POST",
                data: data2,
                success: function(data){

                    $.toast({
                        text: "Acción clave eliminada correctamente",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose : true,
                    });

                    var table = $('#datatableClave').DataTable();

                    table
                        .row( tr )
                        .remove()
                        .draw();

                }
            })


        });
    });
</script>
