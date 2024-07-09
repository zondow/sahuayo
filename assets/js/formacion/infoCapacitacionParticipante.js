$(document).ready(function() {

    //Cell click
    $(".tdClick").click(function(e){
        var row = $(this).data("row");
        var valor = $(this).data("valor");
        clearRow(row);

        setInputValue(row,valor);
        $(this).html("&#10007");
    });//Cell click


    $("#btnGuardarEncuesta").click(function (e){
        $(this).find('i').removeClass();
        $(this).find('i').addClass("fa fa-spinner fa-spin");
    });


    /**----------------------FUNCTIONS---------------------**/

    //Limpiar row
    function clearRow(row){
        $("#TA_"+row).html('');
        $("#D_"+row).html('');
        $("#I_"+row).html('');
        $("#ED_"+row).html('');
        $("#TD_"+row).html('');
    }//clearRow

    //Guardar valor en input
    function setInputValue(row,value){

        switch(row){
            case "TblMetodologia1":$("#txtMetodologia1_A").val(value);break;
            case "TblMetodologia2":$("#txtMetodologia1_B").val(value);break;
            case "TblMetodologia3":$("#txtMetodologia1_C").val(value);break;
            case "TblMetodologia4":$("#txtMetodologia1_D").val(value);break;
            case "TblMetodologia5":$("#txtMetodologia1_E").val(value);break;
            case "TblInstructor1":$("#txtInstructor1_A").val(value);break;
            case "TblInstructor2":$("#txtInstructor1_B").val(value);break;
            case "TblInstructor3":$("#txtInstructor1_C").val(value);break;
            case "TblInstructor4":$("#txtInstructor1_D").val(value);break;
            case "TblInstructor5":$("#txtInstructor1_E").val(value);break;
            case "TblInstructor6":$("#txtInstructor1_F").val(value);break;
            case "TblOrganizacion1":$("#txtOrganizacion1_A").val(value);break;
            case "TblOrganizacion2":$("#txtOrganizacion1_B").val(value);break;
            case "TblSatisfaccion1":$("#txtSatisfaccion1_A").val(value);break;
            case "TblSatisfaccion2":$("#txtSatisfaccion1_B").val(value);break;
            case "TblSatisfaccion3":$("#txtSatisfaccion1_C").val(value);break;

        }//switch
    }//setInputValue

    //Si es movil
    function ifMobile(){
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            $(".data-table").removeClass('data-table-scrollable');
        }//if
    }//ifMobile
});