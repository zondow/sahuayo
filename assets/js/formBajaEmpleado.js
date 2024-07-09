$(document).ready(function () {

    $(".datepicker").datepicker({
        autoclose:!0,
        todayHighlight:!0,
        format: "yyyy-mm-dd",
        daysOfWeek:["D","L","M","M","J","V","S"],
        monthNames:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
    });

    $('.select2').select2({
        //theme:'bootstrap'
    });

    var SITIOS_WEB = 1;

    $btnNuevoSitio = $("#btnNuevoSitio");
    $divSitiosWeb = $("#divSitiosWeb");
    $btnEliminarSitio = $("#btnEliminarSitio");
    $cheklistVehicularFile = $("#cheklistVehicularFile");
    $finiquitoFile = $("#finiquitoFile");

    //Agregar sitio web
    $btnNuevoSitio.click(function (){
        if(SITIOS_WEB < 3) {
            SITIOS_WEB ++;

            //ID de inicio sitio_2
            var html = '<div id="sitio_'+SITIOS_WEB+'" class="form-row">' +
                '            <div class="form-group col-md-4">' +
                '            <label for="txtUrlSitio'+SITIOS_WEB+'">URL</label>' +
                '            <input id="txtUrlSitio'+SITIOS_WEB+'" name="txtUrlSitio'+SITIOS_WEB+'" type="text" class="form-control" placeholder="Escribe la url del sitio">' +
                '            </div>' +
                '            <div class="form-group col-md-4">' +
                '            <label for="txtUserSitio'+SITIOS_WEB+'">Usuario</label>' +
                '            <input id="txtUserSitio'+SITIOS_WEB+'" name="txtUserSitio'+SITIOS_WEB+'" type="text" class="form-control" placeholder="Escribe el usuario">' +
                '            </div>' +
                '            <div class="form-group col-md-4">' +
                '            <label for="txtContrasenaSitio'+SITIOS_WEB+'">Contraseña</label>' +
                '            <input id="txtContrasenaSitio'+SITIOS_WEB+'" name="txtContrasenaSitio'+SITIOS_WEB+'" type="text" class="form-control" placeholder="Escribe la contraseña del sitio">' +
                '            </div>' +
                '            </div>';

            $divSitiosWeb.append(html);
        }

    });//Agregar sitio web

    //Eliminar sitio web
    $btnEliminarSitio.click(function (){
        if(SITIOS_WEB > 1) {
            $("#sitio_" + SITIOS_WEB).remove();
            SITIOS_WEB--;
        }
    });//Eliminar sitio web


    //Validar formato de archivos
    $cheklistVehicularFile.change(function (){filesFormat(this,$cheklistVehicularFile,$("#lbl_cheklistVehicularFile"))});//File checklist vehicular
    $finiquitoFile.change(function (){filesFormat(this,$finiquitoFile,$("#lbl_finiquitoFile"))});//File finiquito


    /**FUNCTIONS**/
    //Validar formato del archivo
    function filesFormat(x,inputFile,lblInput){
        var file = x.files.length;

        if(file == 1) {
            var typeDoc = x.files[0].type;
            console.log(typeDoc);
            if(typeDoc != "image/png" && typeDoc != "image/jpeg" && typeDoc != "application/pdf" &&
                typeDoc != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" &&
                typeDoc != "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                inputFile.val('');
                lblInput.html('Seleccionar archivo');
                toastr.error("Solo se permiten archivos pdf, jpg y png","¡Formato incorrecto!");
            }
            else
            {
                var fileName = x.files[0].name;
                //fileName = fileName.substring(0, 50);
                lblInput.html(fileName);
            }
        }
    }//filesFormat
});