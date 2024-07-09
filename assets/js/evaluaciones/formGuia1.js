$(document).ready(function(e){
    $("#recuerdosDiv").hide();
    $("#esfuerzoDiv").hide();
    $("#afectacionDiv").hide();

    $("#rdoATS_SI").change(function (evt) {
        evt.preventDefault();
        ats = $('#rdoATS_SI:checked').val();
        $("#recuerdosDiv").show();
        $("#esfuerzoDiv").show();
        $("#afectacionDiv").show();
        $("input").prop('required',true);
    });
    $("#rdoATS_NO").change(function (evt) {
        evt.preventDefault();
        ats = $('#rdoATS_NO:checked').val();
        $("#recuerdosDiv").hide();
        $("#esfuerzoDiv").hide();
        $("#afectacionDiv").hide();
        $("input").prop('required',false);
    });
});