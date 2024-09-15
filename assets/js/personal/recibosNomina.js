$(document).ready(function (e) {

    $(".datepicker").datepicker({
        autoclose:!0,
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });

    var btnImportar= $("#btnSubirRecibos");
    var formRecibos = $("#formRecibos");

    btnImportar.click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        if($("#fileZip").val() !== '' && $("#year").val() !== "" && $("#quincena").val() !== ""){

            var form = formRecibos[0];
            var dataForm = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: BASE_URL + "Personal/ajaxSubirRecibosNomina",
                data: dataForm,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function () {
                    swal.fire({
                        title: 'Guardando archivos.',
                        text: 'Por favor espere mientras guardamos la información.',
                        timer: 50000,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        },
                        onClose: () => {
                            clearInterval(timerInterval);
                        }
                    });
                }
            }).done(function (data) {
                data = JSON.parse(JSON.stringify(data));
                $("#fileZip").val('');
                if (data.code == 1) {
                    Swal.fire({
                        title: "¡Archivos guardados exitosamente!",
                        text: "",
                        icon: 'success',
                    }).then(() => {

                        location.reload();
                    });

                }else if(data.code == 2)  {
                    swal.fire({
                        title: '¡Tuvimos un problema!',
                        type: 'warning',
                        text: 'Algunos de los archivos zip ya existen por favor reviselos.',
                    }).then(() => {
                        location.reload();
                    });
                } else  {
                    swal.fire({
                        title: '¡Tuvimos un problema!',
                        type: 'error',
                        text: 'Ocurrio un error al tratar de guardar los archivos,por favor intente de nuevo.',
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }else{
            $.toast({
                text: "Asegurece de que haya llenado los campos requeridos. Intente nuevamente.",
                icon: "warning",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        }
    });

    $('#checklistEgreso').jstree({
        get_selected: true,
        'core' : {
            'data' : {
                url:  BASE_URL+'Personal/ajax_GetRecibosNomina',
                type: "POST",
                dataType : "json",
            }
        }
    }).on('select_node.jstree', function (e, data) {
        data.node; // this is the selected node
        //console.log(data.node.a_attr.href);
        window.open(data.node.a_attr.href);
    });



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