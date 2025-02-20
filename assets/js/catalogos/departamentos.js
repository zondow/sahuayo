$("#tblDepartamentos").DataTable({
    destroy: true,
    lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
    fixedHeader: true,
    scrollX: true,
    paging: true,
    responsive: true,
    stateSave: false,
    dom: '<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
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
            "sInfo":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
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
            title: 'Catalogo de Departamentos',
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
            title: 'Catalogo de Departamentos',
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
});


$('body').on('click', '.editar', function(e) {
    e.preventDefault();
    $("#departamento")[0].reset();
    $("#myModalLabel").html("Editar departamento");
    let departamentoID = $(this).data('id');
    $.ajax({
        url: BASE_URL + "Catalogos/ajax_getInfoDepartamento/"+departamentoID ,
        type: "POST",
        async:true,
        cache:false,
        dataType: "json"
    }).done(function (data){

        if(data.response === "success"){
            $("#id").val(data.result.dep_DepartamentoID);
            $("#nombre").val(data.result.dep_Nombre);
            $("#selectJefeID").val(data.result.dep_JefeID);
            $("#selectJefeID").trigger('change');
            
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

    $("body").on("click","#addDepartamento",function (e) {
        e.preventDefault();
        $("#departamento")[0].reset();
        $("#titleModal").html('Editar departamento');
        $("#id").val(0);
       // modal.modal("show");
    });
   
    $("#addDepartamento").modal("show");

    $('body').on('click', '.guardar', function(evt) {
        
        evt.preventDefault();
        $formulario = $("#departamento");

        data = new FormData($formulario[0]);
        let departamentoID = $("#id").val();
        $.ajax({
            url: BASE_URL + "Catalogos/ajax_editarDepartamento/"+departamentoID ,
            type: "POST",
            data: data,
            async:true,
            cache:false,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            dataType: "json"
        }).done(function (data){
            if(data.response === "success"){

                $.toast({
                    text: "Los datos se guardaron correctamente",
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
                setTimeout(function (e) {
                    location.reload();
                }, 1200);
            } else {
                $.toast({
                    text: "Ha ocurrido un error",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
        });

    });
});



$("body").on("click",".activarInactivar",function (e) {
    var departamentoID = $(this).data("id");
    var estado = $(this).data("estado");
 
    if(estado === 0){
        txt='¿Estás seguro que deseas inactivar el departamento seleccionado?';
        est=0;
    } else {
        txt='¿Estás seguro que deseas activar el departamento seleccionado?';
        est=1;
    }

    let fd  = {"departamentoID":departamentoID,"estado":est};
    Swal.fire({
        title: '',
        text: txt,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if(result.value)
            ajaxCambiarEstado(fd);
    })
});

function ajaxCambiarEstado(fd){
    $.ajax({
        url: BASE_URL + "Catalogos/ajaxUpdateDepEstatus",
        cache: false,
        type: 'post',
        dataType: 'json',
        data:fd
    }).done(function (data) {
        if(data.code === 1) {

            $.toast({
                text:'Cambio el estado del registro seleccionado.',
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
