Dropzone.autoDiscover = false;

$(document).ready(function (e) {


    $(".dropzone").dropzone({
        url: BASE_URL + "Incidencias/ajax_guardarArchivosAnticipo",
        acceptedFiles: ".docx, .pdf, .png, .jpg, .jpeg",
        maxFiles: 1,
        paramName: "file",
        init: function () {
            this.on("success", function (file, data) {
                data = JSON.parse(data);

               var fileID =  this.element.dataset.doc;
                var id = "#txtDrop_" + fileID;

                var myDropzone = Dropzone.forElement(id);
                myDropzone.removeAllFiles(true);
                if (data.code === 2) {
                    showNotification("warning","¡No fue posible guardar el archivo!")
                }
                else {
                    $("#cntEmpty_" + fileID).addClass("ocultar");
                    $("#cntFill_" + fileID).removeClass("ocultar");
                    $("#urlFile_" + fileID).attr("href", data.url);
                    $("#urlIcon_" + fileID).attr("src", data.icon);
                    $("#urlFile_" + fileID).attr("target", "_blank");
                }//if


                ///
            });
            this.on("sending", function (file, xhr, formData) {
                var doc = this.element.dataset.doc;

                formData.append("anticipoID", $("#txtAnticipoFilesID").val());
                formData.append("archivoID", doc);

            });
        },
        thumbnailWidth: 190,
        previewTemplate: '<div class="dz-preview dz-file-preview mb-3">' +
        '<div class="d-flex flex-row ">' +
        '<div class="p-0">' +
        '<div class="dz-error-mark">' +
        '<span>' +
        '<i></i>' +
        '</span>' +
        '</div>' +
        '<div class="dz-success-mark">' +
        '<span>' +
        '<i></i>' +
        '</span>' +
        '</div>' +
        '<div class="preview-container">' +
        '<img data-dz-thumbnail class="img-thumbnail border-0" />' +
        '<i class="simple-icon-doc preview-icon" ></i>' +
        '</div>' +
        '</div>' +
        '<div class="pl-3 pt-2 pr-2 pb-1 dz-details position-relative ocultar"><div>' +
        '<span data-dz-name></span>' +
        '</div>' +
        '<div class="text-primary text-extra-small" data-dz-size />' +
        '<div class="dz-progress">' +
        '<span class="dz-upload" data-dz-uploadprogress></span>' +
        '</div>' +
        '<div class="dz-error-message">' +
        '<span data-dz-errormessage></span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<a href="#/" class="remove" data-dz-remove>' +
        '<i class="glyph-icon simple-icon-trash ocultar"></i>' +
        '</a>' +
        '</div>'
    });

    $("body").on("click", ".btnDeleteFile", function (e) {
        var file = $(this).data("file");
        var anticipoID = $("#txtAnticipoFilesID").val();
        var fd = new FormData();
        fd.append("file", file);
        fd.append("anticipoID", anticipoID);


        if($("#txtEstatusAnticipo").val() == "PENDIENTE") {
            Swal.fire({
                title: 'Eliminar archivo',
                text: '¿Esta seguro que desea eliminar el archivo?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value)
                    eliminarArchivoAnticipo(fd);
            })//swal
        }
        else
        {
            Swal.fire({
                type: 'success',
                title: '¡El archivo no se puede eliminar !',
                showConfirmButton: false,
                timer: 4000
            })
        }

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

    function eliminarArchivoAnticipo(fd){
        $.ajax({
            url: BASE_URL + "Incidencias/ajax_eliminarArchivoAnticipo",
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            dataType: 'json',
            data: fd
        }).done(function (data) {
            if (data.code === 1) {
                $("#cntEmpty_" + data.file).removeClass("ocultar");
                $("#cntFill_" + data.file).addClass("ocultar");
                showNotification("success","¡El archivo se eliminó correctamente!")

                var id = "#txtDrop" + data.file;

                var myDropzone = Dropzone.forElement(id);
                myDropzone.removeAllFiles(true);
            }
            else {
                showNotification("warning","¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!")
            }//if-else
        }).fail(function (data) {
            showNotification("warning","¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!")
        }).always(function (e) {

        });//ajax
    }
});
