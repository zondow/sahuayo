$(document).ready(function (e) {

    var file =$("#fileMaterial");
    var numero= $("#numero");
    var titulo =$("#titulo");
    var $btnCargar= $("#btnSubirMaterial");
    var $form = $("#formMaterial");

    var capsulaID=$("#idCapsula").val();

    $btnCargar.click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        if(file.val() !== '' && numero.val() !== '' && titulo.val() !== '' ){

            var form = $form[0];
            var dataForm = new FormData(form);
            

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: BASE_URL + "Comunicados/ajaxSubirContenidoCapsula",
                data: dataForm,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function () {
                    swal.fire({
                        title: 'Guardando archivos.',
                        text: 'Por favor espere mientras guardamos la información.',
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
                $("#fileMaterial").val('');
                numero.val('');
                titulo.val('');
                if (data.code == 1) {
                    Swal.fire({
                        title: "¡Contenido guardado exitosamente!",
                        text: "",
                        icon: 'success',
                    }).then(() => {

                        location.reload();
                    });

                } else {
                    swal.fire({
                        title: '¡Tuvimos un problema!',
                        icon: 'error',
                        text: 'Ocurrio un error al tratar de guardar el contenido,por favor intente de nuevo.',
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }else{
            $.toast({
                text: "Llene los campos reuqeridos y seleccione un archivo. Intente nuevamente.",
                icon: "warning",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        }
    });


    
    //Borrar Material
    $('body').on('click', '.borrarContenido',function(evt){


        evt.preventDefault();
        $archivo=$(this).data('archivo');
        $id=$(this).data('id');
        var post = {}
        post.$archivo=$archivo;
        post.$capsulaID=capsulaID;
        post.$id=$id;
        
        swal.fire({
            title: '<strong>Confirmación</strong>',
            icon: 'question',
            text: '¿Esta seguro que desea eliminar el material seleccionado?',
            showCancelButton:true,
            closeOnConfirm: false,
            cancelButtonText: ' Cerrar',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: BASE_URL + "Comunicados/ajax_borrarContenidoByID/",
                    type: "POST",
                    data: post,
                    success: function(data){
        
                        datos=JSON.parse(data);
        
                        if(datos.response==1){
                            $.toast({
                                text: "Contenido borrado",
                                icon: "success",
                                loader: true,
                                loaderBg: '#c6c372',
                                position: 'top-right',
                                allowToastClose : true,
                            });
        
                            setTimeout(function(){
                                location.reload();
                            }, 3000);
        
                        }
                    }
                });
            }
        });

    });

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

    
    $("body").on("click", ".videocapsula", function (evt) {
        evt.preventDefault();
        let id = $(this).data('id');
        let urlv = $(this).data('url');
        let titulo = $(this).data('titulo');
        $.ajax({
            url: BASE_URL + "Comunicados/ajax_GuardarVista/" + id,
            type: "POST",
            async: true,
            cache: false,
            dataType: "json"
        });
        
        $('#capsula').empty();
        var video = $('<video />', {
            src: urlv,
            type: 'video',
            controls: true,
            width: '100%',
            id:"vidcap",
        });
        video.appendTo($('#capsula'));
        
        $("h4.modal-title ").html(titulo);
        $("#modalVerVideo").modal("show");
    });
  
    $('#modalVerVideo').on('hidden.bs.modal', function () {
        $('#vidcap').get(0).pause()
    });

    $("body").on("click", ".verVistas", function (evt) {
        let id = $(this).data('id');
         verVistas(id);
        $("#modalVerVistas").modal("show");
    });

    function verVistas(id){
        $.ajax({
            url: BASE_URL + "Comunicados/ajaxGetVistasContenido" ,
            type: "POST",
            dataType: "json",
            data:'contenidoID='+id
        }).done(function (data){
             
           
            $("#divVistas").html(data.capsulas);
        
        }).fail(function () {
            $.toast({
                text: "Ocurrio un error, por favor intente mas tarde.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        });
    }
    
    

});