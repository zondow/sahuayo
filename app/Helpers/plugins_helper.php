<?php

defined('WRITEPATH') or exit('No direct script access allowed');

function load_datables(&$data){
    $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
    $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
    $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
}
function load_sweetalert(&$data){
    $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
    $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
}

function load_fullcalendar(&$data) {
    $data['styles'][] = base_url('assets/libs/fullcalendar/fullcalendar.min.css');
    $data['scripts'][] = base_url('assets/libs/fullcalendar/fullcalendar.min.js');
}

function load_select2(&$data) {
    $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
    $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
}

function load_moment(&$data){
    $data['scripts'][] = base_url('assets/libs/moment/moment.min.js');
}

function load_jquery_ui(&$data){
    $data['scripts'][] = base_url('assets/libs/jquery-ui/jquery-ui.min.js');
}

function load_select(&$data){
    $data['styles'][] = base_url('assets/plugins/bootstrap-select/css/bootstrap-select.css');
}