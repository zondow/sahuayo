$(document).ready(function (e) {
    var btnAddHorario = $("#btnAddHorario");
    var modalAddHorario = $("#modalAddHorario");
    var modalEditHorario = $("#modalEditHorario");
    var btnGuardarHorario = $("#btnGuardarHorario");
    var btnActualizarHorario = $("#btnActualizarHorario");
    var frmHorario = document.getElementById("frmHorario");
    var frmHorarioEdit = document.getElementById("frmHorarioEdit");

    var tblHorarios = $("#tblHorarios").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Configuracion/ajax_getHorarios",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "hor_Nombre"},
            { "data": "hor_Tolerancia"},
            { "data": "hor_Estatus",render: function (data,type,row) {return estatusHorario(data,row)}},
            { "data": "hor_HorarioID",render: function(data){return accionesHorario(data)}},
        ],
        columnDefs: [
            {targets:0,className: 'text-center'},
            {targets:2,className: 'text-center'},
        ],
        responsive:true,
        stateSave:false,
        //dom: 'Blfrtip',
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Horarios',
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
                title: 'Horarios',
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
                "sNext":     "<i class='zmdi zmdi-caret-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },

        },
        "order": [[ 0, "asc" ]],
        "processing":false
    });

    btnAddHorario.click(function (e) {
        modalAddHorario.modal("show");
    });

    btnGuardarHorario.click(function (e) {
        let nombre = $("#txtNombre").val();
        let estatus = $("#txtEstatus").val();
        let tolerancia = $("#txtTolerancia").val();

        if(nombre != ""){
            if(tolerancia >= 0) {
                if (estatus != "")
                    ajax_saveSchedule();
                else
                    showNotification("error", "¡Elige el estatus del horario!")
            }
            else
                showNotification("error","¡Ecribe los minutos de tolerancia!")
        }
        else
            showNotification("error","¡Escribe el nombre del horario!")
    });

    btnActualizarHorario.click(function (e) {
        let nombre = $("#txtNombreEdit").val();
        let estatus = $("#txtEstatusEdit").val();

        if(nombre != ""){
            if(estatus != "")
                ajax_updateSchedule();
            else
                showNotification("error","¡Elige el estatus del horario!")
        }
        else
            showNotification("error","¡Escribe el nombre del horario!")
    });

    $("body").on("click",".btnVerHorario",function (e) {
        var horarioID = $(this).data("horario");
        $("#txtHorarioID").val(horarioID);
        ajax_getSchedule();
    });
    /*******************CONFIGURACIO***************/
    $('.select2').select2({});

    $('.timepicker').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        clearButton: false,
        date: false,
        cancelText: 'Cancelar',
        okText: 'Aceptar',
    });
    /*******************FUNCTIONS***************/
    function estatusHorario(value,row){
        let id = row['hor_HorarioID'] ;
        return value == 1 ? '<a class="badge badge-info" title="Click para cambiar estatus" href="'+BASE_URL+'Configuracion/cambioEstatusHorario/'+ id+'/0"  >Activo</a>' :
            '<a class="badge badge-default" title="Click para cambiar estatus" href="'+BASE_URL+'Configuracion/cambioEstatusHorario/'+ id+'/1" >Inactivo</a>';
    
    }//estatusHorario

    function accionesHorario(horarioID){
        let output = '';
        if(revisarPermisos('Editar','horarios'))
            output+= '<button type="button" style="color: #FFFFFF" data-horario="' + horarioID + '"' +
            'class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down btnVerHorario">' +
            '<i class="zmdi zmdi-key"></i></button>';
        return output;
    }//accionesHorario

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

    function ajax_saveSchedule(){
        $.ajax({
            url: BASE_URL+'Configuracion/ajax_saveSchedule',
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            dataType: 'json',
            data: new FormData(frmHorario)
        }).done(function(data){
            if (data.code === 1){
                limpiarForm();
                tblHorarios.ajax.reload();
                modalAddHorario.modal('toggle');
                showNotification("success","¡El horario se guardo exitosamente!","top");
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }//if-else
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax
    }//ajax_saveSchedule

    function ajax_updateSchedule(){
        $.ajax({
            url: BASE_URL+'Configuracion/ajax_updateSchedule',
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            dataType: 'json',
            data: new FormData(frmHorarioEdit)
        }).done(function(data){
            if (data.code === 1){
                limpiarFormEdit();
                tblHorarios.ajax.reload();
                modalEditHorario.modal('toggle');
                showNotification("success","¡El horario se actualizo exitosamente!","top");
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }//if-else
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax
    }//ajax_updateSchedule

    function ajax_getSchedule(){
        $.ajax({
            url: BASE_URL+'Configuracion/ajax_getSchedule',
            cache: false,
            type: 'post',
            dataType: 'json',
            data:{horarioID: $("#txtHorarioID").val()}
        }).done(function(data){
            if (data.code === 1){
                setInfoSchedule(data.schedule);
                modalEditHorario.modal('show');
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }//if-else
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax
    }//ajax_saveSchedule

    function limpiarForm(){
        $('#frmHorario')[0].reset();
        $("#txtEstatus").val(0).trigger('change');
    }//limpiarForm

    function limpiarFormEdit(){
        $('#frmHorarioEdit')[0].reset();
        $("#txtEstatusEdit").val(0).trigger('change');
    }//limpiarFormEdit

    function setInfoSchedule(info){
        $("#txtNombreEdit").val(info.hor_Nombre);

        if(parseInt(info.hor_LunesDescanso))
            $('#ckLunes_Edit').prop('checked', true);
        if(parseInt(info.hor_MartesDescanso))
            $('#ckMartes_Edit').prop('checked', true);
        if(parseInt(info.hor_MiercolesDescanso))
            $('#ckMiercoles_Edit').prop('checked', true);
        if(parseInt(info.hor_JuevesDescanso))
            $('#ckJueves_Edit').prop('checked', true);
        if(parseInt(info.hor_ViernesDescanso))
            $('#ckViernes_Edit').prop('checked', true);
        if(parseInt(info.hor_SabadoDescanso))
            $('#ckSabado_Edit').prop('checked', true);
        if(parseInt(info.hor_DomingoDescanso))
            $('#ckDomingo_Edit').prop('checked', true);

        $('#lunesE_Edit').val(info.hor_LunesEntrada);
        $('#lunesS_Edit').val(info.hor_LunesSalida);

        $('#martesE_Edit').val(info.hor_MartesEntrada);
        $('#martesS_Edit').val(info.hor_MartesSalida);

        $('#miercolesE_Edit').val(info.hor_MiercolesEntrada);
        $('#miercolesS_Edit').val(info.hor_MiercolesSalida);

        $('#juevesE_Edit').val(info.hor_JuevesEntrada);
        $('#juevesS_Edit').val(info.hor_JuevesSalida);

        $('#viernesE_Edit').val(info.hor_ViernesEntrada);
        $('#viernesS_Edit').val(info.hor_ViernesSalida);

        $('#sabadoE_Edit').val(info.hor_SabadoEntrada);
        $('#sabadoS_Edit').val(info.hor_SabadoSalida);

        $('#domingoE_Edit').val(info.hor_DomingoEntrada);
        $('#domingoS_Edit').val(info.hor_DomingoSalida);

        $("#txtToleranciaEdit").val(info.hor_Tolerancia);
    }//setInfoSchedule

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
});
