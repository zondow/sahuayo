$(document).ready(function(e) {


    $(".datatableCapacitacion").DataTable({
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Capacitaciones',
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
                title: 'Capacitaciones',
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
        language:
            {
                paginate: {
                    previous:"<i class='mdi mdi-chevron-left'>",
                    next:"<i class='mdi mdi-chevron-right'>"
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
                    "sPrevious":     "<i class='mdi mdi-chevron-left'>",
                    "sNext": "<i class='mdi mdi-chevron-right'>"
                },
            },
        drawCallback:function(){
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")}
    });

    $("body").on("click", ".btnComentarios", function (evt) {
        evt.preventDefault();
        $("#formComentarios")[0].reset();
        let capacitacionID = $(this).data('id');
        ajaxGetComentarios(capacitacionID);
        $("#modalAddComentarios").modal("show");
    });

    function ajaxGetComentarios(capacitacionID){
        $.ajax({
            url: BASE_URL + "Formacion/ajax_getComentariosCap" ,
            type: "POST",
            data:"capacitacionID="+capacitacionID,
            dataType: "json"
        }).done(function (data){
            if(data.response === "success"){
                $('#cap_CapacitacionID').val(data.capacitacion.cap_CapacitacionID);
                if(data.capacitacion.cap_ComentariosInstructor !== ""){
                    $('#cap_ComentariosInstructor').summernote('code',data.capacitacion.cap_ComentariosInstructor);
                }else{
                    $('#cap_ComentariosInstructor').summernote();
                }
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
    }



    $('#cap_ComentariosInstructor').summernote({
        //placeholder: 'Hello bootstrap 4',
        tabsize: 2,
        height: 400,
        lang: 'es-ES' // default: 'en-US'
    });


});