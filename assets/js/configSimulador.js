$(document).ready(function (e) {


    var tblMontosAnticipos = $("#tblMontosAnticipos").DataTable({
        destroy: true,
        scrollCollapse: true,
        scrollX:        true,
        paging:         false,
        searching: false,
        "ordering": false,
        info: false,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getMontosAnticiposPorAntiguedad",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "anios"},
            { "data": "meses"},
            { "data": "quincenas"},
        ],
        columnDefs: [
            {targets:0,className: 'cls-Montos'},
            {targets:1,className: 'cls-Montos'},
            {targets:2,className: 'cls-Montos'},

        ],
        "createdRow": function (row, data, rowIndex) {
            $.each($('td', row), function (colIndex) {
                if(colIndex == 1)
                    $(this).attr('class', "cls-meses cls-Montos");
                else if(colIndex == 2)
                    $(this).attr('class', "cls-quincenas cls-Montos");


                $(this).attr('data-pk', data.pk);
                $(this).attr('data-name', colIndex);
                $(this).attr('data-type', "text");
            });
        },
        responsive:true,
        stateSave:false,
        "processing":false
    });

    var tblVariablesAnticipos = $("#tblVariablesAnticipos").DataTable({
        destroy: true,
        scrollCollapse: true,
        scrollX:        true,
        paging:         false,
        searching: false,
        "ordering": false,
        info: false,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getVariabesAnticipo",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "name"},
            { "data": "value"},
        ],
        columnDefs: [
            {targets:0,className: 'td-variables'},
            {targets:1,className: 'td-variables'},

        ],
        "createdRow": function (row, data, rowIndex) {
            $.each($('td', row), function (colIndex) {
                if(colIndex == 1)
                    $(this).attr('class', "cls-valueVariable td-variables");

                $(this).attr('data-pk', data.pk);
                $(this).attr('data-type', "text");
            });
        },
        responsive:true
    });


    $("#tbDatosEditables").editable({
        container:'body',
        selector:'td.cls-meses',
        validate: function (e) {
            if ("" == $.trim(e)) {
                showNotification("danger", "¡Este campo es requerido!");
                return '.';
            }
        },
        mode: "inline",
        inputclass: "form-control-sm numeric",
        url: BASE_URL + 'Incidencias/ajax_updateMontosSimuladorAnticipos',
        ajaxOptions: {
            type: 'post',
            dataType: 'json'
        },
        success: function (response, newValue) {
            if (response.code == 1) {
                tblMontosAnticipos.ajax.reload();
                showNotification("success","¡Dato actualizado correctamente!")
            }
            else
                tblMontosAnticipos.ajax.reload();
        }//success
    });

    $("#tbDatosEditables").editable({
        container:'body',
        selector:'td.cls-quincenas',
        validate: function (e) {
            if ("" == $.trim(e)) {
                showNotification("danger", "¡Este campo es requerido!");
                return '.';
            }
        },
        mode: "inline",
        inputclass: "form-control-sm numeric",
        url: BASE_URL + 'Incidencias/ajax_updateMontosSimuladorAnticipos',
        ajaxOptions: {
            type: 'post',
            dataType: 'json'
        },
        success: function (response, newValue) {
            if (response.code == 1) {
                tblMontosAnticipos.ajax.reload();
                showNotification("success","¡Dato actualizado correctamente!")
            }
            else
                tblMontosAnticipos.ajax.reload();
        }//success
    });

    $("#tbVariablesEditables").editable({
        container:'body',
        selector:'td.cls-valueVariable',
        validate: function (e) {
            if ("" == $.trim(e)) {
                showNotification("danger", "¡Este campo es requerido!");
                return '.';
            }
        },
        mode: "inline",
        inputclass: "form-control-sm numeric",
        url: BASE_URL + 'Incidencias/ajax_updateVariableAnticipos',
        ajaxOptions: {
            type: 'post',
            dataType: 'json'
        },
        success: function (response, newValue) {
            if (response.code == 1) {
                tblVariablesAnticipos.ajax.reload();
                showNotification("success","¡Dato actualizado correctamente!")
            }
            else
                tblVariablesAnticipos.ajax.reload();
        }//success
    });

    $.fn.editableform.buttons='<button type="submit" class="btn btn-success editable-submit btn-sm waves-effect waves-light">' +
        '<i class="mdi mdi-check"></i></button><button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect">' +
        '<i class="mdi mdi-close"></i></button>';

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