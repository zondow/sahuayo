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

    //Candidatos
    function ajaxGetCandidatos(solicitudID) {
        var tblCandidatos = $("#tableCandidatos").DataTable({
            destroy: true,
            //lengthMenu: [[3, 6, 9, -1], [3, 6, 9,, "All"]],
            lengthMenu: [[4, 8, 12, -1], [4, 8, 12, , "All"]],
            //pageLength: 5, // Limitar a 5 registros por página

            ajax: {
                url: BASE_URL + "Reclutamiento/ajax_getCandidatosSolicitud/" + solicitudID,
                dataType: "json",
                type: "post",
            },
            columns: [
                { "data": "can_Nombre" },
                { "data": "check" },
                { "data": "acciones" },
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
                if (data.info.can_Observacion !== "") {
                    $('#can_Observacion').val(data.info.can_Observacion);
                } else {
                    $('#can_Observacion').val();
                }
                /*$('#can_Observacion').summernote('disable');
                $('#candidatoID').val(data.info.candidatoID);
                if (data.info.can_Observacion !== "") {
                    $('#can_Observacion').summernote('code', data.info.can_Observacion);
                } else {
                    $('#can_Observacion').summernote();
                }*/
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

    /*var candidatosSeleccionados = []; // Array para almacenar los ID de los candidatos seleccionados

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
    });*/
    var candidatosSeleccionados = []; // Array para almacenar los ID de los candidatos seleccionados

    // Detectar cambios en los checkboxes
    $(document).on('change', '.chk-candidato', function () {
        var candidatoID = $(this).val();

        if ($(this).is(':checked')) {
            if (!candidatosSeleccionados.includes(candidatoID)) {
                candidatosSeleccionados.push(candidatoID); // Agregar ID al array si no existe
            }
        } else {
            var index = candidatosSeleccionados.indexOf(candidatoID);
            if (index !== -1) {
                candidatosSeleccionados.splice(index, 1); // Eliminar ID del array si existe
            }
        }

        console.log('Candidatos seleccionados:', candidatosSeleccionados); // Para depuración
    });

    // Enviar candidatos seleccionados al servidor
    $('#btnSelCandidatos').on('click', function () {
        // Validar que haya seleccionados antes de enviar
        if (candidatosSeleccionados.length === 0) {
            alert('Por favor, selecciona al menos un candidato.');
            return;
        }

        // Hacer la solicitud Ajax
        $.ajax({
            url: BASE_URL + "Reclutamiento/ajaxSeleccionarCandidatos",
            method: 'POST',
            data: {
                candidatos: candidatosSeleccionados,
                solicitudID: $('#solicitudID').val()
            },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.code === 1) {
                    location.reload(); // Recargar la página si es necesario
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('No se pudo procesar la solicitud. Inténtalo de nuevo.');
            }
        });
    });

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

});