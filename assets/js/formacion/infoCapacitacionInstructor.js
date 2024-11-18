$(document).ready(function (e) {

    ajaxGetParticipantes();
    ajaxGetParticipantesLista();

    //Participantes
    function ajaxGetParticipantes(){
        let capacitacionID=$("#cap_CapacitacionID").val();
        var tblParticipantes = $("#tblParticipantes").DataTable({
            destroy: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: {
                url: BASE_URL + "Formacion/ajax_getParticipantes/"+capacitacionID,
                dataType: "json",
                type: "post",
            },
            columns: [
                { "data": "emp_Numero"},
                { "data": "emp_Nombre"},
                { "data": "pue_Nombre"},
                { "data": "are_Nombre"},
                { "data": "suc_Sucursal"},
                { "data": "cape_Calificacion"},
                { "data": "acciones", render: function(data,type,row){return acciones(data,type,row)} },
            ],
            columnDefs: [
                {targets:0,className: 'text-center'},
            ],
            responsive:true,
            stateSave:false,
            dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Lista de participantes',
                    text: '<i class="zmdi zmdi-collection-text"></i>&nbsp;Excel',
                    titleAttr: "Exportar a excel",
                    className: "btn l-slategray btn-round",
                    autoFilter: true,
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Lista de participantes',
                    text: '<i class="zmdi zmdi-collection-pdf"></i>&nbsp;PDF',
                    titleAttr: "Exportar a PDF",
                    className: "btn l-slategray btn-round",
                    orientation: 'landscape',
                    pageSize: 'LETTER',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Columnas',
                    className: "btn l-slategray btn-round",
                }
            ],
            language: {
                paginate: {
                    previous:"<i class='zmdi zmdi-caret-left'>",
                    next:"<i class='zmdi zmdi-caret-right'>"
                },
                search: "_INPUT_",
                searchPlaceholder: "Buscar...",
                lengthMenu: "Registros por página _MENU_",
                info:"Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty:"Mostrando 0 a 0 de 0 registros",
                zeroRecords: "No hay datos para mostrar",
                loadingRecords: "Cargando...",
                infoFiltered:"(filtrado de _MAX_ registros)",
                "processing": "Procesando...",

            },
            "order": [[ 2, "asc" ]],
            "processing":true
        });

        function acciones(data,type,row){
            let button = '';
                button += '<button href="#" class="btn btn-info btn-icon btn-icon-mini btn-round hidden-sm-down btnCalificacionEmpleado" data-id="'+row['cape_CapacitacionEmpleadoID']+'"   title="Calificación"><i class="zmdi zmdi-star"></i></button>';
            return button;
        }
    }


    $("body").on("click", ".btnCalificacionEmpleado", function (evt) {
        evt.preventDefault();
        let idParticipante=$(this).data('id');
        ajaxGetInfoParticipante(idParticipante);
        $("#modalCalificacion").modal("show");

    });

    function ajaxGetInfoParticipante(idParticipante){
        $.ajax({
            url: BASE_URL + "Formacion/ajaxInfoParticipante",
            type: "POST",
            dataType: 'json',
            data: {participanteID : idParticipante}
        }).done(function (data) {
            $("#cape_Calificacion").val(data.info.cape_Calificacion);
            $("#cape_CapacitacionEmpleadoID").val(idParticipante);
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax
    }

    $("#btnAsiganrCalificacion").click(function () {
        $.ajax({
            url: BASE_URL + "Formacion/ajaxAsignarCalificacionPartic",
            type: "POST",
            dataType: 'json',
            data:$("#formAsignarCalificacion").serialize()
        }).done(function (data) {
            if (data.code === 1) {
                $("#tblParticipantes").DataTable().ajax.reload();
                $("#modalCalificacion").modal("toggle");
                showNotification("success", "Se asigno correctamente la calificación al participante", "top");
            }else{
                showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
            }
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax

    });

    var $btnCargar= $("#btnSubirMaterial");
    var $form = $("#formMaterial");

    $btnCargar.click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        if($("#fileMaterial").val() !== '' ){

            var form = $form[0];
            var dataForm = new FormData(form);
            var capacitacionID=$("#cap_CapacitacionID").val();

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: BASE_URL + "Formacion/ajaxSubirMaterialCapacitacion/"+capacitacionID,
                data: dataForm,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function () {
                    swal.fire({
                        title: 'Guardando archivos.',
                        text: 'Por favor espere mientras guardamos la información.',
                        timer: 20000,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                                Swal.getContent().querySelector('strong')
                                    .textContent = Swal.getTimerLeft();
                            }, 1000);
                        },
                        onClose: () => {
                            clearInterval(timerInterval);
                        }
                    });
                }
            }).done(function (data) {
                data = JSON.parse(JSON.stringify(data));
                $("#fileMaterial").val('');
                if (data.response === 1) {
                    swal.fire({
                        title: "¡Archivos guardados exitosamente!",
                        text: "",
                        type: 'success',
                    }).then(() => {

                        location.reload();
                    });

                } else {
                    swal.fire({
                        title: '¡Tuvimos un problema!',
                        type: 'error',
                        text: 'Ocurrio un error al tratar de guardar los archivos,por favor intente de nuevo.',
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }else{
            $.toast({
                text: "Asegurece de que haya seleccionado al menos un archivo. Intente nuevamente.",
                icon: "warning",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        }
    });

    function showNotification(tipo,msg){
        $.toast({
            text:msg,
            icon: tipo,
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose : true,
        });
    }//showNotification

    //Borrar Material
    $('body').on('click', '#borrarMaterial',function(evt){

        evt.preventDefault();
        $capacitacionID=$(this).data('id');
        $archivo=$(this).data('archivo');
        var post = {}
        post.$capacitacionID=$capacitacionID;
        post.$archivo=$archivo;

        $.ajax({
            url: BASE_URL + "Formacion/ajax_borrarMaterial/",
            type: "POST",
            data: post,
            success: function(data){

                datos=JSON.parse(data);

                if(datos.response=="success"){

                    $.toast({
                        text: "Material borrado",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose : true,
                    });
                    location.reload();


                }
            }
        });

    });

    //Lista de asistencia
    function ajaxGetParticipantesLista(){
        let capacitacionID=$("#cap_CapacitacionID").val();
        var tblListaAsistencia = $("#tblListaAsistencia").DataTable({
            destroy: true,
            fixedHeader: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: {
                url: BASE_URL + "Formacion/ajax_getParticipantesLista/"+capacitacionID,
                dataType: "json",
                type: "post",
            },
            columns: [
                { "data": "emp_Numero"},
                { "data": "emp_Nombre"},
                { "data": "check"},

            ],
            columnDefs: [
                {targets:2,className: 'text-center'},
            ],
            responsive:true,
            stateSave:false,
            //dom: 'Bfrtip',
            "paging": false,
            language: {
                paginate: {
                    previous:"<i class='zmdi zmdi-caret-left'>",
                    next:"<i class='zmdi zmdi-caret-right'>"
                },
                search: "_INPUT_",
                searchPlaceholder: "Buscar...",
                lengthMenu: "Registros por página _MENU_",
                info:"Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty:"Mostrando 0 a 0 de 0 registros",
                zeroRecords: "No hay datos para mostrar",
                loadingRecords: "Cargando...",
                infoFiltered:"(filtrado de _MAX_ registros)",
                "processing": "Procesando...",

            },
            "order": [[ 1, "asc" ]],
            "processing":true
        });
    }


    $("#btnSaveAsistencia").click(function (e) {
        e.preventDefault();
        let capacitacionID=$("#asi_CapacitacionID").val();
        let fecha=$("#asi_Fecha");
        var empleados = [];
        $('input[type=checkbox]:checked').each(function() {
            empleados.push(($(this).attr("value")));
        });


        if(fecha.val() !== ''){
            $("#btnSaveAsistencia").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Guardando...');
            $.ajax({
                url: BASE_URL+'Formacion/ajax_addAsistenciaCapacitacion',
                type: 'post',
                dataType: 'json',
                data: {capacitacionID : capacitacionID,fecha:fecha.val(), empleados: JSON.stringify(empleados)}
            }).done(function(data){
                $("#btnSaveAsistencia").html('<span class="fa fa-save"></span> Guardar');
                if (data.code === 1){
                    swal.fire({
                        type: 'success',
                        title: '',
                        text: 'Registro de asistencia guardado correctamente.',
                        showConfirmButton: true,
                    }).then(() => {
                        location.reload();
                    });
                }else if (data.code === 2){
                    showNotification("warning",'La asistencia de la fecha seleccionada ya se guardo previamente, por favor seleccione otra fecha.',"top");
                }else{
                    showNotification("error",'Ocurro in error al tratar de registrar la asistencia, por favor intente mas tarde.',"top");
                }
            }).fail(function(data){
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }).always(function(e){
            });//ajax

        }else{
            showNotification("error","Por favor seleccione la fecha.","top");
        }
    });

});