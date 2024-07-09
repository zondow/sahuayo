//Options Dropzone
Dropzone.autoDiscover = false;
Dropzone.prototype.defaultOptions.dictRemoveFile = "Eliminar archivo";
Dropzone.prototype.defaultOptions.dictInvalidFileType = "No puedes subir archivos con esta extensión.";
Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "No puedes subir más de 1 archivo.";

$(document).ready(function (e) {


    //Borrar
    $('body').on('click', '.btndel',function(evt){

        evt.preventDefault();
        $empleadoID=$(this).data('empleadoid');
        $expedienteID=$(this).data('expedienteid');
        $nombreArchivo=$(this).data('nombre');
        var post = {}
        post.$empleadoID=$empleadoID;
        post.$expedienteID=$expedienteID;
        post.$nombreArchivo=$nombreArchivo;

        $.ajax({
            url: BASE_URL + "Personal/ajax_borrarFile/",
            type: "POST",
            data: post,
            success: function(data){

                datos=JSON.parse(data);

                if(datos.response=="success"){

                    $("#idimg"+$expedienteID).attr("href","");
                    $("#idbox"+$expedienteID).hide();
                    $("#idimg"+$expedienteID).hide();
                    $("#iddel"+$expedienteID).hide();
                    $("#idpdf"+$expedienteID).hide();
                    $("#iddrop"+$expedienteID).show();
                    $("#idpdf"+$expedienteID).attr("href", "");
                    $("#idtxt"+$expedienteID).text("Sin subir");
                    $("#idpdf"+$expedienteID).addClass("show-pdf");

                    var myDropzone = Dropzone.forElement("#iddrop"+$expedienteID);
                    myDropzone.removeAllFiles(true);


                    $.toast({
                        text: "Archivo borrado",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose : true,
                    });

                }
            }
        });

    });



})