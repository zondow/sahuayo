$(document).ready(function () {
    $(".datatableSolicitudPersonal").DataTable({
        language:
        {
            paginate: {
                previous: "<i class='zmdi zmdi-caret-left'>",
                next: "<i class='zmdi zmdi-caret-right'>"
            },
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla.",
            "sInfo": "",
            "sInfoEmpty": "",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
        },
    });

    



    $('body').on('click', '.btnCandidatos', function (e) {
        e.preventDefault();
        let solicitudID = $(this).data('id');

        $("#solicitudID").val(solicitudID);

        $("#modalselectCandidato").modal("show");

        ajaxGetCandidatos(solicitudID);
    });
/*
    //modal para seleccion de candidatos del solicitante
    $('body').on('click', '.btnCandidatosFinal', function (e) {
        e.preventDefault();
        let solicitudID = $(this).data('id');

        $("#solicitudID").val(solicitudID);

        $("#modalselectFinal").modal("show");
        ajaxGetCandidatosFinalistas(solicitudID);
    });
*/

    //Candidatos
    function ajaxGetCandidatos(solicitudID) {
        var tblCandidatos = $("#tableCandidatos").DataTable({
            destroy: true,
            //lengthMenu: [[3, 6, 9, -1], [3, 6, 9,, "All"]],
            lengthMenu: [[4, 8, 12, -1], [4, 8, 12,, "All"]],
            //pageLength: 5, // Limitar a 5 registros por página

            ajax: {
                url: BASE_URL + "Reclutamiento/ajax_getCandidatosSolicitud/" + solicitudID,
                dataType: "json",
                type: "post",
            },
            columns: [
                { "data": "acciones" },
                { "data": "can_Nombre" },
                { "data": "check" },
            ],
            columnDefs: [
                { targets: 0, className: 'text-center' },
                { targets: 1, className: 'text-center' },
                { targets: 2, className: 'text-center' },
            ],
            responsive: true,
            stateSave: false,
            dom: 'Bfrtip',
            paging: true,
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
            },
            "order": [[1, "asc"]],
            "processing": true
        });
        
    }
/*
    //Candidatos
    function ajaxGetCandidatosFinalistas(solicitudID) {

        var tblCandidatos = $("#tableFinalistas").DataTable({
            destroy: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: {
                url: BASE_URL + "Reclutamiento/ajax_getCandidatosFinalistas/" + solicitudID,
                dataType: "json",
                type: "post",
            },
            columns: [
                { "data": "acciones" },
                { "data": "can_Nombre" },
                { "data": "seleccion" },
            ],
            columnDefs: [
                { targets: 2, className: 'text-center' },
            ],
            responsive: true,
            stateSave: false,
            dom: 'Bfrtip',
            "paging": false,
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

            },
            "order": [[1, "asc"]],
            "processing": true
        });
    }
*/
    $("body").on("click", ".observacionesBtn", function (e) {
        e.preventDefault();
        candidatoID = $(this).data('id');
        document.getElementById('candidatoIDInput').value = candidatoID;
        //document.getElementById('formObservaciones').submit();
        getRegistroObservaciones(candidatoID);
        $("#modalCambios").modal("toggle");
        
    });

    

    function getRegistroObservaciones(candidatoID) {
        $.ajax({
            url: BASE_URL + "Reclutamiento/ajax_getRegistroObservaciones",
            type: "POST",
            data: "candidatoID=" + candidatoID,
            dataType: "json"
        }).done(function (data) {
            if (data.response === "success") {
                $('#can_Observacion').summernote('disable');
                $('#candidatoID').val(data.info.candidatoID);
                if (data.info.can_Observacion !== "") {
                    $('#can_Observacion').summernote('code', data.info.can_Observacion);
                } else {
                    $('#can_Observacion').summernote();
                }
            }
        }).fail(function () {
            $.toast({
                text: "Ocurrido un error, por favor intente nuevamente.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        });
    }

    $('#can_Observacion').summernote({
        //placeholder: 'Hello bootstrap 4',
        toolbar: false,
        tabsize: 2,
        height: 400,
        lang: 'es-ES' // default: 'en-US'
    });


    /*$("#btnSelCandidatos").click(function () {

        let solicitudID = $("#solicitudID").val();
        var candidatos = [];
        $('input[type=checkbox]:checked').each(function () {
            candidatos.push(($(this).attr("value")));
        });

        $.ajax({
            url: BASE_URL + "Reclutamiento/ajaxSeleccionarCandidatos",
            type: "POST",
            dataType: 'json',
            data: { solicitudID: solicitudID, candidatos: JSON.stringify(candidatos) }
        }).done(function (data) {
            if (data.code === 1) {
                $("#modalselectCandidato").modal("toggle");
                showNotification("success", "Se seleccionaron los candidatos.", "top");
                setTimeout(function () {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
            }
        }).fail(function (data) {
            showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
        }).always(function (e) {
        });//ajax

    });*/

    var candidatosSeleccionados = []; // Array para almacenar los ID de los candidatos seleccionados

    $(document).on('change', '.checkbox input[type="checkbox"]', function() {
        var candidatoID = $(this).val();

        if ($(this).is(':checked')) {
            candidatosSeleccionados.push(candidatoID); // Agregar ID al array cuando se selecciona
        } else {
            var index = candidatosSeleccionados.indexOf(candidatoID);
            if (index !== -1) {
                candidatosSeleccionados.splice(index, 1); // Eliminar ID del array cuando se deselecciona
            }
        }
    });

    $('#btnSelCandidatos').on('click', function() {
        // Enviar los ID de los candidatos seleccionados al servidor
        $.ajax({
            url: BASE_URL + "Reclutamiento/ajaxSeleccionarCandidatos",
            method: 'POST',
            data: {
                candidatos: candidatosSeleccionados,
                solicitudID: $('#solicitudID').val()
            },
            success: function(response) {
                // Manejar la respuesta del servidor
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Manejar errores
                console.error(error);
            }
        });
    });




    /*
    $("#btnSelCandidato").click(function () {

        let solicitudID = $("#solicitudID").val();
        var candidatos = [];
        $('input[type=checkbox]:checked').each(function () {
            candidatos.push(($(this).attr("value")));
        });


        $.ajax({
            url: BASE_URL + "Reclutamiento/ajaxSeleccionarCandidatos",
            type: "POST",
            dataType: 'json',
            data: { solicitudID: solicitudID, candidatos: JSON.stringify(candidatos) }
        }).done(function (data) {
            if (data.code === 1) {
                $("#modalselectCandidato").modal("toggle");
                showNotification("success", "Se seleccionaron los candidatos.", "top");
                setTimeout(function () {
                    window.location.reload();
                }, 2000);


            } else {
                showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
            }
        }).fail(function (data) {
            showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
        }).always(function (e) {
        });//ajax

    });
    */

    //Boton seleccionado
    /*$("body").on("click", ".seleccionadoBtn", function (e) {
        var candidatoID = $(this).data("id");
        var candidato = $(this).data("candidato");
        var estatus = 'SELECCIONADO';

        Swal.fire({
            title: 'Seleccionar candidato',
            text: '',
            type: "question",
            html: '<form>¿Esta seguro que desea seleccionar al candidato ' + candidato + '? <br></form>',
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value)
                ajaxSeleccionarCandidato(candidatoID, estatus);
        })
    });*/

    /*function ajaxSeleccionarCandidato(candidatoID, estatus) {
        $("#btnAplicar").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Seleccionando...');
        Swal.fire({
            type: 'info',
            title: 'Cargando...',
            text: 'Espere un momento por favor',
            showConfirmButton: false,
            timer: 3000
        })
        $.ajax({
            url: BASE_URL + 'Reclutamiento/ajax_SeleccionandoCandidato',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: { candidatoID: candidatoID, estatus: estatus}
        }).done(function (data) {
            $("body").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Seleccionando...');
            if (data.code === 1) {
                Swal.fire({
                    icon: 'success',
                    title: data.mensaje,
                    text: data.mensaje,
                    showConfirmButton: false,
                    timer: 2000
                })
                setTimeout(function () { window.location.reload(); }, 400);

            } else {
                $.toast({
                    text: "Ocurrido un error, por favor intente nuevamente.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
            }//if-else
        }).fail(function (data) {
            $.toast({
                text: "Ocurrido un error, por favor intente nuevamente.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        }).always(function (e) {
        });//ajax
    }*/

    function showNotification(tipo, msg) {
        $.toast({
            text: msg,
            icon: tipo,
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose: true,
        });
    }//showNotification

    /*$('#modalCambios').on("hide.bs.modal", function () {
        window.scrollTo(0, 0); // Desplaza la ventana de vuelta al principio
        console.log('here');
    });*/

    /*document.getElementById('modalCambios').addEventListener('hidden.bs.modal', function () {
        var modalPrincipal = document.getElementById('modalselectCandidato');
        modalPrincipal.scrollTop = 0;
    });*/

});