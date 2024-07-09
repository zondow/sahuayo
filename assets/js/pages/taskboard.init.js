$(document).ready(function(){
    $("#upcoming, #inprogress,#testing, #completed").sortable({
        connectWith:".taskList",
        placeholder:"task-placeholder",
        forcePlaceholderSize:!0,
        update:function(e,o){
            $("#todo").sortable("toArray"),
                $("#upcoming").sortable("toArray"),
                $("#inprogress").sortable("toArray"),
                $("#testing").sortable("toArray"),
                $("#completed").sortable("toArray")
        },
        change: function( event, ui ) {
            let tareaID = $(this).data('id');
            console.log(tareaID);
        }
    }).disableSelection()
});