$(document).ready(function (e) {
    var btnAddChecklist = $("#btnAddChecklist");
    var modalAddChecklist = $("#modalAddChecklist");
    var btnGuardarChecklist = $("#btnGuardarChecklist");
    var modalEditChecklist = $("#modalEditChecklist");
    var btnUpdateChecklist = $("#btnUpdateChecklist");

    var tblCheklist = $("#tblCheklist").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Catalogos/ajax_getChecklistIngresoEgreso",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "id",render: function (data,type,row) {return accionesChecklist(data)}},
            { "data": "id"},
            { "data": "name"},
            { "data": "status",render: function (data,type,row) {return statusChecklist(data,row)}},
            { "data": "departamento"},
            { "data": "tipo",render:function (data,type,row) {return tipoChecklist(data,row)}},
        ],
        columnDefs: [
            {targets:3,className: 'text-center'},
        ],
        responsive:true,
        stateSave:false,
        //dom: 'Blfrtip',
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Checklist ingreso|egreso empleado',
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
                title: 'Checklist ingreso|egreso empleado',
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
                "sNext":    "<i class='zmdi zmdi-caret-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },

        },
        "order": [[ 1, "desc" ]],
        "processing":false
    });

    btnAddChecklist.click(function (e) {
        modalAddChecklist.modal("show");
    });

    btnGuardarChecklist.click(function (e) {
        var checklist = {};
        checklist.nombre = $("#txtNombre").val();
        checklist.departamento = $("#txtDepartamento").val();
        checklist.status = $("#txtEstatus").val();
        checklist.tipo = $("#txtTipo").val();

        if(checklist.nombre != ''){
            if(checklist.departamento > 0){
                if(checklist.status != '')
                    if(checklist.tipo != '')
                        ajax_guardarChecklist(checklist);
                    else
                        showNotification("warning","¡Selecciona el tipo de checklist!");
                else
                    showNotification("warning","¡Selecciona el estatus!")
            }
            else
                showNotification("warning","¡Selecciona el departamento!");
        }
        else
            showNotification("warning","¡Escribe nombre!");
    });

    $("body").on("click",".btnActivo",function (e) {
        var checklistID = $(this).data("checklist");
        Swal.fire({
            title: 'INACTIVAR',
            text: '¿Esta seguro que desea INACTIVAR?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            ajax_changeEstatusChecklist(checklistID,0);

        })//swal
    });

    $("body").on("click",".btnInactivo",function (e) {
        var checklistID = $(this).data("checklist");
        Swal.fire({
            title: 'ACTIVAR',
            text: '¿Esta seguro que desea ACTIVAR?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value)
                ajax_changeEstatusChecklist(checklistID,1);

        })//swal
    });

    $("body").on("click",".btnEditChecklist",function (e) {
        var checklistID = $(this).data("checklist");
        ajax_GetChecklistByID(checklistID);

    });

    btnUpdateChecklist.click(function (e) {
        var checklist = {};
        checklist.id = $("#txt_CatalogoID").val();
        checklist.nombre = $("#txt_Nombre").val();
        checklist.departamento = $("#txt_Departamento").val();
        checklist.status = $("#txt_Estatus").val();
        checklist.tipo = $("#txt_Tipo").val();

        if(checklist.nombre != ''){
            if(checklist.departamento > 0){
                if(checklist.status != '')
                    if(checklist.tipo != '')
                        ajax_updateChecklist(checklist);
                    else
                        showNotification("warning","¡Selecciona el tipo de checklist!");
                else
                    showNotification("warning","¡Selecciona el estatus!")
            }
            else
                showNotification("warning","¡Selecciona el departamento!");
        }
        else
            showNotification("warning","¡Escribe nombre!");
    });

    /**FUNCTIONS*/
    $(".select2").select2();
    function statusChecklist(status,row){

        var id = row.id;
        if(status == 1)
            return '<button class="btn btn-outline-success btn-rounded ' +
                'waves-light waves-effect pt-0 pb-0 btnActivo" data-checklist="'+id+'">Activo</button>';

        return '<button class="btn btn-outline-danger btn-rounded ' +
            'waves-light waves-effect pt-0 pb-0 btnInactivo" data-checklist="'+id+'">Inactivo</button>';

    }//statusChecklist

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

    function ajax_guardarChecklist(checklist){
        $.ajax({
            url: BASE_URL+'Catalogos/ajax_guardarCheklist',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: checklist
        }).done(function(data){
            if (data.code === 1){
                tblCheklist.ajax.reload();
                modalAddChecklist.modal("toggle");
                clear();
                Swal.fire({
                    type: 'success',
                    title: '¡La información se guardó correctamente!',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }//if-else
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax
    }//ajax_guardarChecklist

    function ajax_updateChecklist(checklist){
        $.ajax({
            url: BASE_URL+'Catalogos/ajax_updateCheklist',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: checklist
        }).done(function(data){
            if (data.code === 1){
                tblCheklist.ajax.reload();
                modalEditChecklist.modal("toggle");
                clear();
                Swal.fire({
                    type: 'success',
                    title: '¡La información se actualizó correctamente!',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }//if-else
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax
    }//ajax_updateChecklist

    function clear(){
        $("#txtNombre").val("");
        $("#txtDepartamento").val(0).trigger("change");
        $("#txtEstatus").val('').trigger("change");
        $("#txtTipo").val(0).trigger("change");
    }//clear

    function tipoChecklist(tipo){
        if(tipo == 'Ingreso')
            return '<span class="badge badge-info">INGRESO</span>';
        return '<span class="badge badge-danger">EGRESO</span>';
    }//tipoChecklist

    function ajax_changeEstatusChecklist(id, st){
        $.ajax({
            url: BASE_URL+'Catalogos/ajax_changeEstatusChecklist',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {id:id,status:st}
        }).done(function(data){
            if (data.code === 1){
                tblCheklist.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: '¡El estatus se actualizó correctamente!',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }//if-else
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax
    }//ajax_changeEstatusChecklist

    function accionesChecklist(id){

        var editButton = '';
        if(revisarPermisos('Editar','configChecklistIngresoEgreso')) {
            editButton = '<button type="button" data-checklist="' + id + '" class="btn btn-purple btnEditChecklist">' +
                '<i class="fa fa-edit"></i>&nbsp;&nbsp;Editar</button>';
        }
        return editButton;
    }//accionesChecklist

    function ajax_GetChecklistByID(id){
        $.ajax({
            url: BASE_URL+'Catalogos/ajax_getCheklist',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {id:id}
        }).done(function(data){
            if (data.code === 1){
                var checklist = data.checklist;
                $("#txt_CatalogoID").val(checklist.cat_CatalogoID);
                $("#txt_Nombre").val(checklist.cat_Nombre);
                $("#txt_Departamento").val(checklist.cat_DepartamentoID).trigger("change");
                $("#txt_Estatus").val(checklist.cat_Estatus).trigger("change");
                $("#txt_Tipo").val(checklist.cat_Tipo).trigger("change");
                modalEditChecklist.modal("show");
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }//if-else
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax
    }//ajax_GetChecklistByID
});