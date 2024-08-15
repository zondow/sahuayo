<?php

defined('WRITEPATH') or exit('No direct script access allowed');

function load_plugins($plugins, &$data)
{
    foreach ($plugins as $plugin) {
        $function_name = 'load_' . $plugin;
        if (function_exists($function_name)) {
            call_user_func_array($function_name, array(&$data));
        }
    }
}

function load_datatables(&$data)
{
    $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
    $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
    $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
}
function load_sweetalert2(&$data)
{
    $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
    $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
}

function load_fullcalendar(&$data)
{
    $data['styles'][] = base_url('assets/libs/fullcalendar/fullcalendar.min.css');
    $data['scripts'][] = base_url('assets/libs/fullcalendar/fullcalendar.min.js');
}

function load_select2(&$data)
{
    $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
    $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
}

function load_moment(&$data)
{
    $data['scripts'][] = base_url('assets/libs/moment/moment.min.js');
}

function load_jquery_ui(&$data)
{
    $data['scripts'][] = base_url('assets/libs/jquery-ui/jquery-ui.min.js');
}

function load_select(&$data)
{
    $data['styles'][] = base_url('assets/plugins/bootstrap-select/css/bootstrap-select.css');
    $data['scripts'][] = base_url('assets/plugins/bootstrap-select/js/i18n/defaults-es_ES.js');
    $data['scripts'][] = base_url('assets/plugins/bootstrap-select/js/bootstrap-select.js');
    
}

function load_datables4(&$data)
{
    $data['styles'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.css');
    $data['styles'][] = base_url('assets/libs/datatables/responsive.bootstrap4.css');
    $data['scripts'][] = base_url('assets/libs/datatables/jquery.dataTables.min.js');
    $data['scripts'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.min.js');
    $data['scripts'][] = base_url('assets/libs/datatables/dataTables.responsive.min.js');
}

function load_sweetalert(&$data)
{
    $data['styles'][] = base_url("assets/plugins/sweetalert/sweetalert.css");
    $data['scripts'][] = base_url("assets/plugins/sweetalert/sweetalert.min.js");
    $data['scripts'][] = base_url("assets/plugins/sweetalert/jquery.sweet-alert.custom.js");
}

function load_datatables_buttons(&$data)
{
    $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
    $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
    $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
    $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
    $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
    $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
    $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
    $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
    $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
    $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
    $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
}

function load_moment_locales(&$data)
{
    $data['scripts'][] = base_url('assets/plugins/momentjs/moment-with-locales.js');
}

function load_datetimepicker(&$data)
{
    $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
    $data['scripts'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');
}

function load_jstree(&$data)
{
    $data['styles'][] = base_url("assets/plugins/jstree/css/style.min.css");
    $data['scripts'][] = base_url("assets/plugins/jstree/jstree.min.js");
}

function load_tooltipster(&$data)
{
    $data['styles'][] = base_url("assets/libs/tooltipster/tooltipster.bundle.min.css");
    $data['scripts'][] = base_url("assets/libs/tooltipster/tooltipster.bundle.min.js");
}

function load_dropzone(&$data)
{
    $data['styles'][] = base_url('assets/plugins/dropzone/min/dropzone.min.css');
    $data['scripts'][] = base_url('assets/plugins/dropzone/min/dropzone.min.js');
}

function load_datepicker(&$data)
{
    $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
    $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
}

function load_custombox(&$data)
{
    $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.css');
    $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
}

function load_footable(&$data)
{
    $data['styles'][] = base_url("assets/libs/footable/footable.core.min.css");
    $data['scripts'][] = base_url("assets/libs/footable/footable.all.min.js");
}

function load_tomselect(&$data){
    $data['styles'][] = "https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css";
    $data['scripts'][] = "https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js";
}
