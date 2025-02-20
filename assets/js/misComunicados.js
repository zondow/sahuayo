$(document).ready(function(e) {

    var tblComunicados = $("#datatableComunicados").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        ajax: {
            url: BASE_URL + "Comunicados/ajax_getComunicadosByEmpleado",
            dataType: "json",
            type: "POST",
            "processing": true,
        },
        columns: [
            
            { "data": "com_Asunto", render: function (data, type, row) {return vistoAsunto(data, type, row)}},
            { "data": "com_Fecha", render: function (data, type, row) {return vistoFecha(data, type, row)}},
            { "data": "acciones", render: function (data, type, row) {return acciones(data, type, row)}},
        ],
        columnDefs: [
            {targets: 0, className: 'text-center'},
        ],
        dom: '<"row"<"col-md-6"l><"col-md-6 text-center"f><"col-md-6 cls-export-buttons"B>>rtip',
        responsive: true,
        stateSave: false,
        language: {
            paginate: {
                previous: "<i class='zmdi zmdi-caret-left'>",
                next: "<i class='zmdi zmdi-caret-right'>"
            },
            search: "_INPUT_",
            searchPlaceholder: "Buscar...",
            lengthMenu: "Registros por página _MENU_",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            zeroRecords: "No hay datos para mostrar",
            loadingRecords: "Cargando...",
            infoFiltered: "(filtrado de _MAX_ registros)",
            "processing": "Procesando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "<i class='zmdi zmdi-caret-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },
        },
        "order": [[2, "desc"]],
        "processing": true,

    });

    function acciones(data, type, row) {
        let button = '';
        button += ' <button type="button" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down verComunicado" title="Ver comunicado" data-id="' + row['com_ComunicadoID'] + '" data-not="' + row['com_ComunicadoID'] + '" style="color:#FFFFFF"><i class="zmdi zmdi-email-open"></i> </button>';

        if(row['not_Enterado'] == 0) button += ' <button type="button" class="btn btn-success btn-icon btn-icon-mini btn-round hidden-sm-down enteradoComunicado" title="Marcar como enterado" data-id="' + row['com_ComunicadoID'] + '" style="color:#FFFFFF"><i class="zmdi zmdi-check"></i> </button>';
        return button;
    }

    function vistoAsunto(data, type, row) {
        let span = '';
        return row['not_Visto'] == 0 ?
            span += '<span class=" font-weight-bold">' + row['com_Asunto'] + ' </span>'  :
            span += '<span>' + row['com_Asunto'] + ' </span>';
    }

    function vistoFecha(data, type, row) {
        let span = '';
        return row['not_Visto'] == 0 ?
            span += '<span class=" font-weight-bold">' + row['com_Fecha'] + '</span>' :
            span += '<span>' + row['com_Fecha'] + '</span>';
    }


    $("body").on("click", ".verComunicado", function (evt) {
        evt.preventDefault();

        let comunicadoID=$(this).data('id');
        let fd  = {"comunicadoID":comunicadoID};
        $.ajax({
            url: BASE_URL + "Comunicados/ajax_verComunicadoColaborador",
            type: "POST",
            data: fd,
            success: function(data){
                dat=JSON.parse(data)
                dat=dat.com
                $("#temFecCom").text("");
                $("#temAsuntoCom").text("");
                $('#temDesCom').html("");
                $("#temFecCom").text(dat.com_Fecha);
                $('#temDesCom').append(dat.com_Descripcion);
                $('#temAsuntoCom').text(dat.com_Asunto);
                $("#modalVerComunicado").modal("show");
            }
        })

    });


    $("body").on("click",".enteradoComunicado",function (e) {
        var comunicadoID = $(this).data("id");
        let fd  = {"comunicadoID":comunicadoID};
        Swal.fire({
            title: '',
            text: '¿Esta seguro que desea marcar como enterado el comunicado?',
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if(result.value)
                ajaxEnteradoComunicado(fd);
        })
    });

    function ajaxEnteradoComunicado(fd){
        $.ajax({
            url: BASE_URL + "Comunicados/ajaxEnteradoComunicado",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:fd
        }).done(function (data) {
            if(data.code === 1) {
                tblComunicados.ajax.reload();
                $.toast({
                    text:'El comunicado se marco como enterado.',
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
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