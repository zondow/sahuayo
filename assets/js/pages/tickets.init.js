$(document).ready(function(){$("#datatable").DataTable({
    language:
        {
            paginate: {
                previous:"<i class='zmdi zmdi-caret-left'>",
                next:"<i class='zmdi zmdi-caret-right'>"
            },
        },
    drawCallback:function(){
    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")}})});