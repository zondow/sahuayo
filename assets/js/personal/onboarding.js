$(document).ready(function (e) {

    /// Onboarding///
    $('body').on('click', '.onboarding', function(e) {
        e.preventDefault();
        let colaboradorID = $(this).data('id');
        $("#col").val(colaboradorID);
        ajaxInfoOnboardingColaboradorByID(colaboradorID);
        getCheckList(colaboradorID);
        $("#modalOnboarding").modal("show");
    });

    function ajaxInfoOnboardingColaboradorByID(colaboradorID){
        $.ajax({
            url: BASE_URL + "Personal/ajax_getInfoOnboardingColaboradorByID/"+colaboradorID ,
            type: "POST",
            async:true,
            cache:false,
            dataType: "json"
        }).done(function (data){

            if(data.response === "success"){
                
                $("#nombre-onboarding").text(data.colaborador.emp_Nombre);
                $("#puesto-onboarding").text(data.colaborador.pue_Nombre);
                $("#departamento-onboarding").text(data.colaborador.dep_Nombre);
                $("#fotoEmpOnboarding").html('<img src="'+data.foto+'" class="rounded-circle avatar" alt="'+data.colaborador.emp_Nombre+'">');

                let porcentaje= (data.totalCheck * 100) / data.total;

                $("#porcentaje").text(Math.round(porcentaje)+"% completo");
                var progressBar = $('<div></div>')
                    .addClass('progress-bar progress-bar-success')  
                    .attr('role', 'progressbar')  
                    .attr('aria-valuenow', porcentaje)  
                    .attr('aria-valuemin', '0')  
                    .attr('aria-valuemax', '100')  
                    .css('width', porcentaje+"%");  

                // Crear el span dentro de la progress-bar
                var progressText = $('<span></span>')
                    .addClass('sr-only')  
                    .text(porcentaje+ ' Completo'); 

                progressBar.append(progressText);
                $('#progress-container').append(progressBar);

            }
        }).fail(function () {
            $.toast({
                text: "Ocurrio un error, por favor intente nuevamente.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        });
    };

    $("body").on("click", "#btnNotificarIngreso", function (evt) {
        evt.preventDefault();
        let empleadoID = $("#col").val();
        swal.fire({
            title: '',
            icon: 'question',
            text: '¿Esta seguro que desea notificar el nuevo ingreso a las areas correspondientes?',
            showCancelButton:true,
            closeOnConfirm: false,
            cancelButtonText: ' Cerrar',
        }).then((result) => {
            if (result.value) {
                enviarComunicado(empleadoID);
            }
        });
    });

    function enviarComunicado(empleadoID){
        $.ajax({
            type: "POST",
            url: BASE_URL + "Personal/ajaxEnviarNotiNuevoIngreso",
            data: 'empleadoID='+empleadoID,
            dataType: "json",
            beforeSend: function () {
                swal.fire({
                    title: 'Enviando la notificacion de nuevo ingreso.',
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
                    title: "¡Correos enviados exitosamente!",
                    text: "",
                    icon: 'success',
                }).then(() => {

                    location.reload();
                });

            } else {
                swal.fire({
                    title: '¡Tuvimos un problema!',
                    type: 'error',
                    text: 'Ocurrio un error al tratar de enviar los correos,por favor intente de nuevo.',
                }).then(() => {
                    location.reload();
                });
            }
        });
    }

    function getCheckList(colaboradorID){
        $.ajax({
            url: BASE_URL + "Personal/ajax_getChecklist/"+colaboradorID,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var checklistContainer = $('#checklist-container');
                checklistContainer.empty();
                
                // Recorrer la respuesta y generar el HTML
                $.each(response, function(index, item) {
                    var requiredText = item.requerido == 1 ? '<b>' + item.nombre + '</b>' : item.nombre;
                    var isChecked = item.checked ? 'checked' : '';
                    
                    var checkboxHTML = `
                        <div class="col-lg-12 offset-lg-1">
                            <div class="checkbox checkbox-warning">
                                <input id="${item.id}" name="check[]" value="${item.id}" type="checkbox" ${isChecked}>
                                <label for="${item.id}">
                                    ${requiredText}
                                </label>
                            </div>
                        </div>
                    `;
                    
                    // Añadir el checkbox al contenedor
                    checklistContainer.append(checkboxHTML);
                });
            },
            error: function() {
                $.toast({
                    text: "Ocurrio un error, por favor intente nuevamente.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
        });
    }
    

    $("body").on("click", "#bntGuardarOnboarding", function (evt) {
        evt.preventDefault();
        let empleadoID = $("#col").val();
        swal.fire({
            title: '',
            icon: 'question',
            text: '¿Esta seguro que desea guardar los cambios al checklist de ingreso del colaborador?',
            showCancelButton:true,
            closeOnConfirm: false,
            cancelButtonText: ' Cerrar',
        }).then((result) => {
            if (result.value) {
                saveCheckList(empleadoID);
            }
        });
    });

    function saveCheckList(empleadoID){

        var selectedChecks = [];
        $('input[name="check[]"]:checked').each(function() {
            selectedChecks.push($(this).val());
        });

        $.ajax({
            type: "POST",
            url: BASE_URL + "Personal/ajax_saveOnboarding",
            data: {
                col: empleadoID,           
                check: selectedChecks   
            },
            dataType: "json"
        }).done(function (data) {
            data = JSON.parse(JSON.stringify(data));
            if (data.code === 1) {
                swal.fire({
                    title: "¡Onboarding actualizado correctamente!",
                    text: "",
                    icon: 'success',
                }).then(() => {

                    location.reload();
                });

            } else {
                swal.fire({
                    title: '¡Tuvimos un problema!',
                    type: 'error',
                    text: 'Ocurrio un error al tratar de actualizar el onboarding,por favor intente de nuevo.',
                }).then(() => {
                    location.reload();
                });
            }
        });

    }

});