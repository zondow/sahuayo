$(document).ready(function() {

    //Cell click
    $(".tdClick").click(function(e){
        var row = $(this).data("row");
        var valor = $(this).data("valor");
        clearRow(row);

        setInputValue(row,valor);
        $(this).html("&#10007");
    });//Cell click


    $("#btnGuardarEntrevistaSalida").click(function (e){
        $(this).find('i').removeClass();
        $(this).find('i').addClass("fa fa-spinner fa-spin");
    });


    /**----------------------FUNCTIONS---------------------**/

    //Limpiar row
    function clearRow(row){
        $("#E_"+row).html('');
        $("#MB_"+row).html('');
        $("#B_"+row).html('');
        $("#R_"+row).html('');
        $("#M_"+row).html('');
        $("#MM_"+row).html('');
        $("#P_"+row).html('');
    }//clearRow

    //Guardar valor en input
    function setInputValue(row,value){

        switch(row){
            case 1:$("#txtAmbienteLaboral2_A").val(value);break;
            case 2:$("#txtAmbienteLaboral2_B").val(value);break;
            case 3:$("#txtAmbienteLaboral2_C").val(value);break;
            case 4:$("#txtAmbienteLaboral2_D").val(value);break;
            case 5:$("#txtAmbienteLaboral2_E").val(value);break;
            case 6:$("#txtAmbienteLaboral2_F").val(value);break;
            case 7:$("#txtAmbienteLaboral2_G").val(value);break;
            case 8:$("#txtAmbienteLaboral2_H").val(value);break;
            case 9:$("#txtAmbienteLaboral2_I").val(value);break;
            case 10:$("#txtAmbienteLaboral2_J").val(value);break;
            case "Tbl3_1":$("#txtAmbienteLaboral3_A").val(value);break;
            case "Tbl3_2":$("#txtAmbienteLaboral3_B").val(value);break;
            case "Tbl3_3":$("#txtAmbienteLaboral3_C").val(value);break;
            case "Tbl3_4":$("#txtAmbienteLaboral3_D").val(value);break;
            case "Tbl3_5":$("#txtAmbienteLaboral3_E").val(value);break;
            case "Tbl3_6":$("#txtAmbienteLaboral3_F").val(value);break;
            case "Tbl3_7":$("#txtAmbienteLaboral3_G").val(value);break;
            case "TblDesarrollo1":$("#txtDesarrollo1_A").val(value);break;
            case "TblDesarrollo2":$("#txtDesarrollo1_B").val(value);break;
            case "TblDesarrollo3":$("#txtDesarrollo1_C").val(value);break;
            case "TblDesarrollo4":$("#txtDesarrollo1_D").val(value);break;
            case "TblDesarrollo5":$("#txtDesarrollo1_E").val(value);break;
            case "TblDesarrollo6":$("#txtDesarrollo1_F").val(value);break;
            case "TblGral1":$("#txtAspGrales1_A").val(value);break;
            case "TblGral2":$("#txtAspGrales1_B").val(value);break;
            case "TblGral3":$("#txtAspGrales1_C").val(value);break;
            case "TblCH1":$("#txtservCH1_A").val(value);break;
            case "TblCH2":$("#txtservCH1_B").val(value);break;
            case "TblCH3":$("#txtservCH1_C").val(value);break;
            case "TblCH4":$("#txtservCH1_D").val(value);break;
            case "TblCH5":$("#txtservCH1_E").val(value);break;

        }//switch
    }//setInputValue

    //Si es movil
    function ifMobile(){
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            $("#tbl_CH1").removeClass('data-table-scrollable');
        }//if
    }//ifMobile
});