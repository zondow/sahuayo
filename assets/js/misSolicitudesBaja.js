$(document).ready(function (e) {

    var tblMisBajas = $("#tblMisBajas").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Personal/ajax_getMisBajas",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "baj_BajaEmpleadoID",render: function(data,type,row){return accionesBaja(data,type,row)}},
            { "data": "baj_FechaRegistro"},
            { "data": "baj_MotivoBaja"},
            { "data": "baj_Estado",render: function(data,type,row){return estatusMisBajas(data,type,row)}},
            { "data": "baj_Progreso",render: function(data,type,row){return progresoBaja(data,type,row)}},
            { "data": "baj_Comentarios"},

        ],
        columnDefs: [
            {targets:0,className: 'text-center'},
            {targets:3,className: 'text-center'},
        ],
        responsive:true,
        stateSave:false,
        //dom: 'Blfrtip',
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Mis solicitudes de baja',
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
                title: 'Mis solicitudes de baja',
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
                "sNext":    "<i class='mdi mdi-chevron-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },

        },
        "order": [[ 1, "desc" ]],
        "processing":false
    });

    $("body").on("click",".btnEliminarBaja",function (e) {
        var bajaID = $(this).data("baja");

        Swal.fire({
            title: 'Eliminar solicitud de baja',
            text: '¿Esta seguro que desea eliminar la solicitud?',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value)
                eliminarBaja(bajaID,$(this));
        })//swal
    });
    /****************FUNCTIONS******************/

    function accionesBaja(data,type,row){

        var btnEliminar = '';
        if(row.baj_Estado == 'PENDIENTE') {
            btnEliminar = '<button type="button" class="btn btn-danger btn-block waves-light waves-effect btnEliminarBaja" ' +
                'data-baja="'+data+'"><i class="dripicons-trash"></i>&nbsp; Eliminar</button>';
        }//if

        var entrevista = parseInt(row.entrevista);
        if(isNaN(entrevista) || entrevista == 0){
            var btnEntrevista = '<a href="'+BASE_URL+'Personal/entrevistaSalida/'+data+'" class="btn btn-dark btn-block waves-light waves-effect">' +
                '<i class="dripicons-clipboard"></i>&nbsp; Entrevista salida</a>';
        }else{
            var btnEntrevista = '<a href="'+BASE_URL+'PDF/imprimirEntrevistaSalida/'+entrevista+'" ' +
                'class="btn btn-dark btn-block waves-light waves-effect show-pdf" data-title="Entrevista de salida">' +
                '<i class="dripicons-clipboard"></i>&nbsp; Entrevista salida</a>';
        }

        return btnEliminar + btnEntrevista;
    }//accionesBaja

    function estatusMisBajas(st){
        var html = st;
        switch (st){
            case "PENDIENTE":
                html =  '<span class="badge label-table badge-light-warning pt-1 pb-1 pr-2 pl-2">PENDIENTE</span>';
                break;
            case "AUTORIZADA":
                html =  '<span class="badge label-table badge-light-info pt-1 pb-1 pr-2 pl-2">AUTORIZADA</span>';
                break;
            case "RECHAZADA":
                html =  '<span class="badge label-table badge-light-danger pt-1 pb-1 pr-2 pl-2">RECHAZADA</span>';
                break;
        }//switch
        return html;
    }//estatusMisBajas

    function eliminarBaja(bajaID,button){
        button.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Eliminando...');
        $.ajax({
            url: BASE_URL+'Personal/ajax_eliminarBaja',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {bajaID:bajaID}
        }).done(function(data){
            button.html('<i class="dripicons-trash"></i>&nbsp; Eliminar');
            if (data.code === 1){
                tblMisBajas.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: '¡Solicitud eliminada!',
                    text: 'La solicitud de baja se eliminó correctamente',
                    showConfirmButton: false,
                    timer: 3000
                })
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }//if-else
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
            button.html('<i class="dripicons-trash"></i>&nbsp; Eliminar');
        });//ajax

    }//eliminarBaja

    function progresoBaja(){
        var html = '<div class="progress cls-progress mb-0">' +
            '<div class="progress-bar" role="progressbar" style="width: 75%; padding: 3px; background: #29b32b;" ' +
            'aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">75%</div>\n' +
            '</div>';

        return html;
    }


    $(".select2").select2();

    $("body").on('keydown', '.numeric', function(e){
        var key = e.which;
        if ((key >= 48 && key <= 57) ||         //standard digits
            (key >= 96 && key <= 105) ||        //digits (numeric keyboard)
            key === 190 || //.
            key === 110 ||  //. (numeric keyboard)
            key === 8 || //retorno de carro
            key === 37 || // <--
            key === 39 || // -->
            key === 46 || //Supr
            key === 173 || //-
            key === 109 || //- (numeric keyboard)
            key === 9 //Tab
        ){
            return true;
        }//if
        return false;
    });//.numeric.keyup

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


    //Formato de moneda
    function number_format(amount) {

        if(!isNaN(amount) && amount > 0){
            amount =  '$ ' + amount.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }
        else
        {
            amount = ' $ 0.00';
        }

        return amount;
    }//number_format



});