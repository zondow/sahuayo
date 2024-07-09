$(document).ready(function () {
    $(".datatableVacaciones").DataTable({
        responsive:true,
        stateSave:false,
        //dom: 'Blfrtip',
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Vacaciones pendientes',
                text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn btn-warning",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'pdfHtml5',
                title: 'Vacaciones pendientes',
                text: '<i class="fa fa-file-pdf-o"></i>&nbsp;PDF',
                titleAttr: "Exportar a PDF",
                className: "btn btn-warning",
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
        language: {
            paginate: {
                previous:"<i class='mdi mdi-chevron-left'>",
                next:"<i class='mdi mdi-chevron-right'>"
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
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "<i class='mdi mdi-chevron-right'>",
                "sPrevious": "<i class='mdi mdi-chevron-left'>"
            },

        },
        //"order": [[ 3, "desc" ]],
        "processing":false,
    });

    $("body").on("click",".autorizarRechazar",function (e) {
        var vacacionID = $(this).data("id");
        var estatus = $(this).data("estatus");
        var type = $(this).data("type");

        if(estatus==='AUTORIZADO_RH'){
            txt='¿Estás seguro que deseas autorizar la solicitud de vacaciones?';
            est=estatus;
            titulo="Autorizar solicitud";
            html="";
            $("#btnAplicar").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Aplicando...');
        } else if(estatus==='RECHAZADO'){
            txt='¿Estás seguro que deseas rechazar la solicitud de vacaciones?';
            est=estatus;
            titulo="Rechazar solicitud";
            html= '<textarea id="txtObservaciones" placeholder="Escribe aquí algunas observaciones" ' +
            'class="swal2-textarea" style="display: flex;" style="resize: none;"></textarea>';
            $("#btnRechazar").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Rechazando...');
        }

        let fd  = {"vacacionID":vacacionID,"estatus":est,"type":type,"observaciones": $("#txtObservaciones").val()};
        Swal.fire({
            title: titulo,
            text: txt,
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            html:html
        }).then((result) => {
            if(result.value)
                ajaxCambiarEstado(fd);
        })
    });

    function ajaxCambiarEstado(fd){
        $.ajax({
            url: BASE_URL + "Incidencias/ajax_cambiarEstatusVacaciones",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:fd
        }).done(function (data) {
            if(data.code === 1) {
                Swal.fire({
                    type: 'success',
                    title: 'Solicitud revisada!',
                    text: 'La solicitud de vacaciones se reviso correctamente.',
                    showConfirmButton: false,
                    timer: 2000
                })
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            }
            else {
                $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
            }

        }).fail(function (data) {
            $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
        }).always(function (e) {

        });//ajax
    }

    $("body").on("click",".declinarVacaciones",function (e) {
        var vacacionID = $(this).data("id");

        Swal.fire({
            title: 'Declinar vacaciones',
            text: '¿Esta seguro de declinar las vacaciones?',
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#f72800",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            html: '<textarea id="txtObsDeclinar" placeholder="Escriba el motivo" ' +
                'class="swal2-textarea" style="display: flex;" style="resize: none;"></textarea>',
        }).then((result) => {
            if(result.value)
                ajaxDeclinarEstatus(vacacionID,$("#txtObsDeclinar").val());
        })
    });

    function ajaxDeclinarEstatus(vacacionID,obs){
        $.ajax({
            url: BASE_URL + "Incidencias/ajax_declinarVacaciones",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:{vacacionID:vacacionID,obs:obs}
        }).done(function (data) {
            if(data.code === 1) {
                $.toast({
                    text:'Se ha actualizado el estado de la vacación.',
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
                setTimeout(function () {
                    window.location.reload();
                }, 1200);
            }
            else {
                $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
            }

        }).fail(function (data) {
            $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
        }).always(function (e) {

        });//ajax
    }
});