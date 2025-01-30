$(document).ready(function (e) {
    $("#divPlanes").hide();
    $("#divProv").hide();
    $("#divInstructor").hide();

    $('.timepicker').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        clearButton: false,
        date: false,
        cancelText: 'Cancelar',
        okText: 'Aceptar',
    });

    $(".datepicker").datepicker({
        daysOfWeekDisabled: [0],
        format: "yyyy-mm-dd",
        toggleActive: !0,
        todayHighlight: true,
        autoclose: true,
    });

    $(".datatableCapacitacion").DataTable({
        dom: '<"row"<"col-md-4"l><"col-md-4"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Matriz de capacitación',
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
                title: 'Matriz de capacitación',
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
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>",
                "sNext": "<i class='zmdi zmdi-caret-right'>"
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });

    document.querySelectorAll('button[data-href]').forEach(button => {
        button.addEventListener('click', function() {
            window.location.href = this.getAttribute('data-href');
        });
    });    

    var DIAS = 1;

    $btnNuevoDia = $("#btnNuevoDia");
    $divDias = $("#divDias");
    $btnEliminarDia = $("#btnEliminarDia");

    //Agregar dia
    $btnNuevoDia.click(function () {
        if (DIAS < 10) {
            DIAS++;

            //ID de inicio 2
            var html = '<div id="dia_' + DIAS + '" class="row  mb-2">' +
                '     <div class="form-group col-md-4">' +
                '         <label for="fecha' + DIAS + '"> * Fecha </label>' +
                '           <input class="form-control datepicker" id="fecha' + DIAS + '" name="fecha[]"  placeholder=" Seleccione">' +
                '     </div>' +
                '     <div class="form-group col-md-4">' +
                '        <label for="inicio' + DIAS + '">* Hora inicio</label>' +
                '        <input  class="input-sm form-control timepicker" name="inicio[]" id="inicio' + DIAS + '" placeholder="Seleccione" />' +
                '    </div>' +
                '    <div class="form-group col-md-4">' +
                '        <label for="fin' + DIAS + '">* Hora fin</label>' +
                '        <input type="text" class="input-sm form-control timepicker" name="fin[]" id="fin' + DIAS + '" placeholder="Seleccione" />' +
                '    </div>' +
                '  <hr>' +
                ' </div>';

            $divDias.append(html);

            $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                toggleActive: !0,
                todayHighlight: true,
                autoclose: true,
                daysOfWeekDisabled: [0],
            });

            $('.timepicker').bootstrapMaterialDatePicker({
                format: 'HH:mm',
                clearButton: false,
                date: false,
                cancelText: 'Cancelar',
                okText: 'Aceptar',
            });
        }

    });//Agregar

    //Eliminar dia
    $btnEliminarDia.click(function () {
        if (DIAS > 1) {
            $("#dia_" + DIAS).remove();
            DIAS--;
        }
    });//Eliminar


    $("body").on("change", "#cap_Tipo", function (e) {
        e.preventDefault();
        let tipo = $("#cap_Tipo").val();
        if (tipo === 'INTERNO') {
            //mostrar div
            $("#divInstructor").show();
            //ocultar div
            $("#divProv").hide();
            //requeridos selects
            $("#cap_InstructorID").prop('required', true);
            //no requeridos select
            $("#cap_ProveedorCursoID").prop('required', false);
        } else {
            //ocultar div
            $("#divInstructor").hide();
            //mostrar div
            $("#divProv").show();
            //requeridos selects
            $("#cap_ProveedorCursoID").prop('required', true);
            //no requeridos select
            $("#cap_InstructorID").prop('required', false);

        }
    });

    //Elegir comprobante
    $('#cap_Comprobante').on('change', function () {
        // Verifica si la opción seleccionada es la primera opción
        if ($(this).val() === 'SI') {
            // Muestra el segundo select y la imagen previsualizada
            $('#selectComprobante').show();
            $('#imagenPrevisualizada').show();
        } else {
            // Oculta el segundo select y la imagen previsualizada
            $('#selectComprobante').hide();
            $('#imagenPrevisualizada').hide();
        }
    });
    $("#cap_TipoComprobante").change(function () {
        if ($(this).val() === '1') {
            // Primer comprobante
            $("#selectImagen").attr("src", "http://localhost/sahuayo/assets/images/capacitacion/comprobante.png");
        } else if ($(this).val() === '2') {
            // Segundo comprobvante
            $("#selectImagen").attr("src", "http://localhost/sahuayo/assets/images/capacitacion/comprobante2.png");
        }
    });

    $("body").on("click", "#btnAddCapacitacion", function (evt) {
        evt.preventDefault();

        $("#formCapacitacion")[0].reset();
        $("#dia_1").empty();
        $("#cap_CursoID").val('').trigger('change');
        $("#cap_Tipo").val('').trigger('change');
        $("#cap_ProveedorCursoID").val('').trigger('change');
        $("#cap_Comprobante").val('').trigger('change');
        $("#cap_TipoComprobante").val('').trigger('change');

        $("#modalAddCapacitacion").modal("show");
    });

    $("body").on("click", ".btnEditCapacitacion", function (evt) {
        evt.preventDefault();
        $("#formCapacitacion")[0].reset();
        $divDias.empty();

        let capacitacionID = $(this).data('id');
        $(".dia1").hide();
        ajaxGetCapacitacionInfo(capacitacionID);
        $("#modalAddCapacitacion").modal("show");
    });

    $('.restrictCalificacion').on("input", function () {
        switch (true) {
            case this.value < 0:
                $(this).val('');
                break;
            case this.value.indexOf('-') !== -1:
                $(this).val('0');
                break;
            case this.value > 10:
                $(this).val('10');
                break;
            case this.value.length > 4:
                this.value = this.value.slice(0, 4);
                break;
        }
    });

    function ajaxGetCapacitacionInfo(capacitacionID) {

        $.ajax({
            url: BASE_URL + 'Formacion/ajaxGetCapacitacionInfo',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: 'capacitacionID=' + capacitacionID
        }).done(function (data) {
            if (data.code === 1) {

                let capacitacionInfo = data.capacitacionInfo;
                $("#cap_CapacitacionID").val(capacitacionID);
                $("#cap_CursoID").val(capacitacionInfo.cap_CursoID).trigger('change');
                $("#cap_Tipo").val(capacitacionInfo.cap_Tipo).trigger('change');

                $("#cap_InstructorID").val(capacitacionInfo.cap_InstructorID).trigger('change');
                $("#cap_ProveedorCursoID").val(capacitacionInfo.cap_ProveedorCursoID).trigger('change');

                $("#cap_TipoComprobante").val(capacitacionInfo.cap_TipoComprobante).trigger('change');

                $("#cap_Observaciones").val(capacitacionInfo.cap_Observaciones);
                $("#cap_Costo").val(capacitacionInfo.cap_Costo);
                $("#cap_Comprobante").val(capacitacionInfo.cap_Comprobante).trigger('change');
                $("#cap_CalAprobatoria").val(capacitacionInfo.cap_CalAprobatoria);
                $("#cap_Lugar").val(capacitacionInfo.cap_Lugar);
                $("#cap_Dirigido").val(capacitacionInfo.cap_Dirigido);

                let info = data.fechas;
                let x = 0;

                jQuery.each(info, function (i, val) {

                    var html = '<div id="dia_' + x + '" class="row  mb-2">' +
                        '     <div class="form-group col-md-4">' +
                        '         <label for="fecha' + x + '"> * Fecha </label>' +
                        '           <input class="form-control datepicker" id="fecha' + x + '" name="fecha[]" value="' + val.fecha + '"  placeholder=" Seleccione">' +
                        '     </div>' +
                        '     <div class="form-group col-md-4">' +
                        '        <label for="inicio' + x + '">* Hora inicio</label>' +
                        '        <input  class="input-sm form-control timepicker" name="inicio[]" id="inicio' + x + '" value="' + val.inicio + '" placeholder="Seleccione" />' +
                        '    </div>' +
                        '    <div class="form-group col-md-4">' +
                        '        <label for="fin' + x + '">* Hora fin</label>' +
                        '        <input type="text" class="input-sm form-control timepicker" name="fin[]" id="fin' + x + '" value="' + val.fin + '" placeholder="Seleccione" />' +
                        '    </div>' +
                        '  <hr>' +
                        ' </div>';
                    x++;
                    $divDias.append(html);
                });

                $('.datepicker').datepicker({
                    format: "yyyy-mm-dd",
                    toggleActive: !0,
                    todayHighlight: true,
                    autoclose: true,
                    daysOfWeekDisabled: [0],
                });

                $('.timepicker').bootstrapMaterialDatePicker({
                    format: 'hh:mm A', // Formato de 12 horas con AM/PM
                    clearButton: false,
                    date: false,
                    cancelText: 'Cancelar',
                    okText: 'Aceptar',
                });
            }
            else {
                toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "info");
            }

        }).fail(function (data) {
            toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "info");
        }).always(function (e) { });//

    }


    //Enviar la convocatoria
    $("body").on("click", ".btnEnviarConvocatoriaCap", function (evt) {
        evt.preventDefault();
        let idCapacitacion = $(this).data('id');

        Swal.fire({
            title: '<strong>Confirmación</strong>',
            icon: 'question',
            text: '¿Esta seguro que desea publicar la convocatoria?',
            showCancelButton: true,
            closeOnConfirm: false,
            cancelButtonText: ' Cerrar',
        }).then((result) => {
            if (result.value) {
                enviarConvocatoriaCapacitacion(idCapacitacion);
            }
        });
    });

    function enviarConvocatoriaCapacitacion(idCapacitacion) {
        $.ajax({
            type: "POST",
            url: BASE_URL + "Formacion/ajaxEnviarConvocatoriaCapacitacion",
            data: 'idCapacitacion=' + idCapacitacion,
            dataType: "json",
            beforeSend: function () {
                swal.fire({
                    title: 'Enviando la convocatoria.',
                    text: 'Por favor espere mientras se envian los correos correspondientes.',
                    timer: 20000,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                            Swal.getContent().querySelector('strong')
                                .textContent = Swal.getTimerLeft();
                        }, 1000);
                    },
                    onClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            }
        }).done(function (data) {
            data = JSON.parse(JSON.stringify(data));
            if (data.response === 1) {
                swal.fire({
                    title: "¡Convocatoria enviada exitosamente!",
                    text: "",
                    icon: 'success',
                }).then(() => {

                    location.reload();
                });

            } else {
                swal.fire({
                    title: '¡Tuvimos un problema!',
                    type: 'error',
                    text: 'Ocurrio un error al tratar de enviar la convocatoria,por favor intente de nuevo.',
                }).then(() => {
                    location.reload();
                });
            }
        });
    }

    $("body").on("click", ".btnComentarios", function (evt) {
        evt.preventDefault();
        $("#formComentarios")[0].reset();
        let capacitacionID = $(this).data('id');
        ajaxGetComentarios(capacitacionID);
        $("#modalAddComentarios").modal("show");
    });


    function ajaxGetComentarios(capacitacionID) {
        $.ajax({
            url: BASE_URL + "Formacion/ajax_getComentariosCap",
            type: "POST",
            data: "capacitacionID=" + capacitacionID,
            dataType: "json"
        }).done(function (data) {
            if (data.response === "success") {
                $('#cap_CapacitacionID').val(data.capacitacion.cap_CapacitacionID);
                /*if (data.capacitacion.cap_ComentariosInstructor !== "") {
                    $('#cap_ComentariosInstructor').summernote('code', data.capacitacion.cap_ComentariosInstructor);
                } else {
                    $('#cap_ComentariosInstructor').summernote();
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

    //Enviar la convocatoria
    $("body").on("click", ".btnTerminarCapacitacion", function (evt) {
        evt.preventDefault();
        let idCapacitacion = $(this).data('id');

        Swal.fire({
            title: '<strong>Confirmación</strong>',
            icon: 'question',
            text: '¿Esta seguro que desea finalizar la capacitacion?',
            showCancelButton: true,
            closeOnConfirm: false,
            cancelButtonText: ' Cerrar',
        }).then((result) => {
            if (result.value) {
                terminarCapacitacion(idCapacitacion);
            }
        });
    });

    function terminarCapacitacion(idCapacitacion) {
        $.ajax({
            type: "POST",
            url: BASE_URL + "Formacion/ajaxTerminarCapacitacion",
            data: 'idCapacitacion=' + idCapacitacion,
            dataType: "json",
        }).done(function (data) {
            data = JSON.parse(JSON.stringify(data));
            if (data.code == 1) {
                swal.fire({
                    title: "¡Capacitacion Finalizada!",
                    text: "",
                    icon: 'success',
                }).then(() => {
                    location.reload();
                });
            } else if (data.code == 0) {
                swal.fire({
                    title: '¡Tuvimos un problema!',
                    type: 'error',
                    text: 'Ocurrio un error al tratar de eliminar la capacitacion,por favor intente de nuevo.',
                }).then(() => {
                    location.reload();
                });
            }
        });
    }



    /*$('#cap_ComentariosInstructor').summernote({
        //placeholder: 'Hello bootstrap 4',
        tabsize: 2,
        height: 400,
        lang: 'es-ES' // default: 'en-US'
    });*/


    $("body").on('keydown', '.numeric', function (e) {
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
        ) {
            return true;
        }//if
        return false;
    });//.numeric.keyup

});