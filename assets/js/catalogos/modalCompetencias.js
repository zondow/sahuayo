
$(document).ready(function (e) {

    let cNombre = $("#com_Nombre");
    let cDescripcion = $("#com_Descripcion");
    let cTipo = $("#com_Tipo");
    let orden = $("#com_NoOrden");

    $('body').on('click', '.modal-competencias', function(e) {
        e.preventDefault();

        $('#formCompetencias')[0].reset();
        $("#com_Descripcion").html('');

        let $this = $(this);
        let competenciaID = $this.data('id');

        $("#competenciaID").val('');
        if(competenciaID !== undefined){
            $("#competenciaID").val(competenciaID);
            ajaxCompetenciaInfo(competenciaID);
        }
        // Open
        $("#modalCompetencias").modal("show");

    });

    $('body').on('click', '#guardarCompetencia', function(e) {
        e.preventDefault();

        if(cNombre.val() != '' && cDescripcion.val().trim() != '' && cTipo.val() != '' && orden.val() != '') {
            let formData = $('#formCompetencias').serialize();
            $.ajax({
                url: BASE_URL + "Catalogos/ajax_operacionesCompetencias",
                type: "POST",
                async: true,
                cache: false,
                data: formData,
                dataType: "json"
            }).done(function (data) {
                console.log(data);

                if(data.response === "success"){
                    $.toast({
                        text: data.msg,
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
                        text: data.msg,
                        icon: "error",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose : true,
                    });
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
        }else {
            $.toast({
                text: "Todos los campos son requeridos.",
                icon: "warning",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        }

    });

    function ajaxCompetenciaInfo(IDCompetencia){

        $.ajax({
            url: BASE_URL + "Catalogos/ajax_getCompetenciaInfo" ,
            type: "POST",
            async:true,
            cache:false,
            data: "competenciaID="+IDCompetencia,
            dataType: "json"
        }).done(function (data){
            if(data.response === "success"){
                $("#com_Nombre").val(data.info['com_Nombre']);
                $("#com_Descripcion").html(data.info['com_Descripcion']);
                $("#com_Tipo").val(data.info['com_Tipo']);
                $("#com_Tipo").trigger('change');
                $("#com_NoOrden").val(data.info['com_NoOrden']);
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

});