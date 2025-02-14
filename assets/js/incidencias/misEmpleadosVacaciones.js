$(document).ready(function () {

    $(".datatableVacaciones").DataTable({
        responsive:true,
        stateSave:false,
        //dom: 'Blfrtip',
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Vacaciones mis colaboradores',
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
                title: 'Vacaciones mis colaboradores',
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
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "<i class='zmdi zmdi-caret-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },

        },
        "order": [[ 3, "desc" ]],
        "processing":false
    });


    $("body").on("click",".autorizarRechazar",function (e) {
        var vacacionID = $(this).data("id");
        var estatus = $(this).data("estatus");

        if(estatus==='AUTORIZADO'){
            titulo="Autorizar vacaciones";
            txt='¿Estás seguro que deseas autorizar la solicitud de vacaciones?';
            est=estatus;
            html="";
        } else if(estatus==='RECHAZADO'){
            titulo="Rechazar vacaciones";
            txt='¿Estás seguro que deseas rechazar la solicitud de vacaciones?';
            est=estatus;
            html= '<textarea id="txtObservaciones" placeholder="Escribe aquí algunas observaciones" ' +
                  'class="swal2-textarea" style="display: flex;" style="resize: none;"></textarea>';
        }

        let fd  = {"vacacionID":vacacionID,"estatus":est,"observaciones": $("#txtObservaciones").val()};
        Swal.fire({
            title: titulo,
            text: txt,
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            html:html,

        }).then((result) => {
            if(result.value)
                ajaxCambiarEstado(fd);
        })
    });
    function ajaxCambiarEstado(fd){
        $.ajax({
            url: BASE_URL + "Incidencias/ajax_cambiarEstatusAutorizarVacaciones",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:fd
        }).done(function (data) {
            if(data.code === 1) {
                Swal.fire({
                    icon: 'success',
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

});