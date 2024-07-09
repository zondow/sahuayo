$(document).ready(function () {

    /**CONFGURACION***/
    $("#date-range").datepicker({
        daysOfWeekDisabled: [0],
        format: "yyyy-mm-dd",
        toggleActive: !0,
        todayHighlight: true,
        autoclose: true,
    }).on('changeDate', function (e) {
        $("#vac_FechaFin").focus();
    });

    $(".datepicker").datepicker({
        daysOfWeekDisabled: [0],
        format: "yyyy-mm-dd",
        toggleActive: !0,
        todayHighlight: true,
        autoclose: true,
    });

    $('#reportes').jstree({
        get_selected: true,
        'core' : {
            'data' : {
                url:  BASE_URL+'Incidencias/ajax_GetReportesAsistencia',
                type: "POST",
                dataType : "json",
            }
        }
    }).on('select_node.jstree', function (e, data) {
        data.node; // this is the selected node
        //console.log(data.node.a_attr.href);
        window.open(data.node.a_attr.href);
    });

});