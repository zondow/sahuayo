$(document).ready(function (e) {

    var tblGuardia = $("#tblGuardia").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Configuracion/ajax_getGuardia",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "emp_Nombre"},
            { "data": "gua_FechaInicio"},
            { "data": "gua_FechaFin"},
            { "data": "gua_GuardiaID",render: function(data){return accionesGuardia(data)}},
        ],
        columnDefs: [
            {targets:0,className: 'text-center'},
        ],
        responsive:true,
        stateSave:false,
        //dom: 'Blfrtip',
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Guardias',
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
                title: 'Guardias',
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

    function accionesGuardia(guardiaID){
        let output = '';
        if(revisarPermisos('Eliminar','guardias'))
            output+= '<button type="button" data-id="' + guardiaID + '"' +
            'class="btn btn-danger btn-icon btn-icon-mini btn-round hidden-sm-down btnDeleteGuardia" title="Eliminar rol">' +
            '<i class="zmdi zmdi-delete"></i></button>';
        return output;
    }//accionesGuardia

    function semanaSpan(fecha){
        let output = '';
        output+='<span class="badge badge-success">'+fecha+'</span>';
        return output;
    }//accionesGuardia

    $("#addGuardia").click(function (e) {
        $("#frmGuardia")[0].reset();
        $("#modalAddGuardia").modal("show");
    });

    //Enviar notificacion a gerente
    $("body").on("click",".btnDeleteGuardia",function (e) {
        var guardiaID = $(this).data("id");
        Swal.fire({
            title: 'Eliminar guardia',
            text: '¿Esta seguro que desea eliminar la guardia?',
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if(result.value)
            ajaxEliminarGuardia(guardiaID);
        })
    });

    function ajaxEliminarGuardia(guardiaID){
        $("#btnAplicar").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Aplicando...');
        $.ajax({
            url: BASE_URL+'Configuracion/ajax_EliminarGuardia',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {guardiaID:guardiaID}
        }).done(function(data){
            if (data.code === 1){
                Swal.fire({
                    type: 'success',
                    title: "Guardia eliminada",
                    text: "Se ha eliminado la guardia exitosamente",
                    showConfirmButton: false,
                    timer: 2000
                })
                tblGuardia.ajax.reload();

            }else{
                $.toast({
                    text: "Ocurrido un error, por favor intente nuevamente.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }//if-else
        }).fail(function(data){
            $.toast({
                text: "Ocurrido un error, por favor intente nuevamente.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        }).always(function(e){
        });//ajax
    }

    $("body").on("click",".btnModalImportarGuardia",function (e) {
        $("#modalAddGuardiaMasivo").modal("show");
    });

    var drop=  $("#id_drop").dropzone({
        url: BASE_URL + "Configuracion/previewPlantilla",
        acceptedFiles: ".xls, .xlsx",
        maxFiles: 1,
        addRemoveLinks: true,
        success: function (file) {
            dat=JSON.parse(file.xhr.response)
            jexcel.fromSpreadsheet(BASE_URL+"assets/uploads/guardias/"+dat.nombre, function(result) {
                if(result[0].data[0].length === 2 && result[0].data[0][0]==="colaborador" && result[0].data[0][1]==="fecha sabado"){
                    objeto=convertToJSON(result[0].data);
                    var post = {}
                    post.datos=JSON.stringify(objeto);

                    $.ajax({
                        url: BASE_URL + "Configuracion/ajaxGuardarRegistroGuardias",
                        type: "POST",
                        data: post,
                        dataType: "json",
                        success: function(data){
                            if(data.code == 1){
                                var myDropzone = Dropzone.forElement("#id_drop");
                                myDropzone.removeAllFiles(true);

                                Swal.fire({
                                    type: 'success',
                                    title: '¡Registros importados!',
                                    text: 'Los registros de guardias se importaron correctamente',
                                    showConfirmButton: true,

                                });
                                window.location.reload();
                            }else if(data.code == 2){
                                var myDropzone = Dropzone.forElement("#id_drop");
                                myDropzone.removeAllFiles(true);

                                Swal.fire({
                                    type: 'error',
                                    title: 'Reporte registrado.',
                                    text: 'El reporte de guardias ya se habia guardado anteriormente. Por favor reviselo.',
                                    showConfirmButton: true
                                });

                            }else{
                                var myDropzone = Dropzone.forElement("#id_drop");
                                myDropzone.removeAllFiles(true);
                                $.toast({
                                    text: "Error al guardar los datos. Por favor, intentelo de nuevo",
                                    icon: "warning",
                                    loader: true,
                                    loaderBg: '#c6c372',
                                    position : 'top-right',
                                    allowToastClose : true,
                                    hideAfter: 9000,
                                    stack: 6
                                });
                            }

                        }
                    });

                }else{

                    var myDropzone = Dropzone.forElement("#id_drop");
                    myDropzone.removeAllFiles(true);
                    $.toast({
                        text: "El formato del archivo no es el correcto.",
                        icon: "warning",
                        loader: true,
                        loaderBg: '#c6c372',
                        position : 'top-right',
                        allowToastClose : true,
                        hideAfter: 9000,
                        stack: 6
                    });
                }
            });
        }
    });

    function convertToJSON(array) {
        var objArray = [];
        for (var i = 1; i < array.length; i++) {
            objArray[i - 1] = {};
            for (var k = 0; k < array[0].length && k < array[i].length; k++) {
                var key = array[0][k];
                objArray[i - 1][key] = array[i][k]
            }
        }

        return objArray;
    }



});
Dropzone.autoDiscover = false;