$(document).ready(function (e) {

    //Alain-Oculta tabla
    $('#tabla').hide();
    $('#divanim').hide();
    $('#fechap').hide();
    $('#fechap2').hide();
    $('#fe').hide();
    $('#fj').hide();

    //Alain - boton ver resultado desempeño
    $('body').on('click', '.btnver',function(evt){
        evt.preventDefault();

        $('#tabla').hide();
        $('#divanim').hide();
        $('#fechap').hide();
        $('#fechap2').hide();
        $('#fe').hide();
        $('#fj').hide();

        let empleadoID= $(this).data('id');
        ajaxEmpleadoInfo(empleadoID);
        ajaxResultadoDesempeno90(empleadoID);

        $('#modalDesempeno90').modal("show");
    });


    //Alain regresar datos de el resultado del desempeño
    function ajaxEmpleadoInfo(empleadoID){
        var obj = {};
        obj.empleadoID=empleadoID;
        $.ajax({
            url: BASE_URL + "Evaluaciones/ajaxEmpleadoInfo",
            type: "POST",
            dataType: "json",
            data:obj
        }).done(function (data) {


            if (data.response=="success"){

                /*if(data.result.Fotoe===""){

                    $('#imge').attr("src", BASE_URL+"assets/images/avatar.jpg");
                }else{

                    $('#imge').attr("src", BASE_URL+"assets/uploads/fotosPerfil/"+data.result.Fotoe);
                }


                if(data.result.Fotoj===""){

                    $('#imgj').attr("src",  BASE_URL+"assets/images/avatar.jpg");

                }else{

                    $('#imgj').attr("src", BASE_URL+"assets/uploads/fotosPerfil/"+data.result.Fotoj);

                }*/

                $('#imgj').attr("src", data.fotojb);
                $('#imge').attr("src", data.fotoeb);
                $('#emp').text(data.result.Nombre);
                $('#emp_p').text(data.result.Puesto);
                $('#jefe').text(data.result.Nombrej);
                $('#jefe_p').text(data.result.Puestoj);

            }

        }).fail(function (data) {
            toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","error");
        }).always(function (e) {

        });//ajax;
    }ajaxEmpleadoInfo


        //Alain regresar datos de el resultado del desempeño
    function ajaxResultadoDesempeno90(empleadoID){

        var obj = {};
        obj.empleadoID=empleadoID;
        $.ajax({
            url: BASE_URL + "Evaluaciones/ajaxResultadoDesempeno90",
            type: "POST",
            dataType: "json",
            data:obj
        }).done(function (data) {

            if (data.response=="success"){

                if (data.result==null ){

                    //alert("nuell")
                    $('#fe').hide();
                    $('#fj').hide();
                    $('#fechap').hide();
                    $('#fechap2').hide();
                    $('#tabla').hide();
                    $('#divanim').show();
                    return;
                }



                if (data.result.evad_RespuestasJefe ==="" && data.result.evad_RespuestasEmpleado ==="" ){

                    $('#fe').hide();
                    $('#fj').hide();
                    $('#fechap').hide();
                    $('#fechap2').hide();
                    $('#tabla').hide();
                    $('#divanim').show();
                    return;
                }

                $("#tabla-body tr").remove();
                $("#tabla-body td").remove();

                $("#tablaj-body tr").remove();
                $("#tablaj-body td").remove();

                var trHTML = '';

                if(data.result.evad_RespuestasJefe ==="" || data.result.evad_RespuestasJefe===null ){

                    //alert("vacia-jefe");

                    $.each(JSON.parse(data.result.evad_RespuestasEmpleado), function (i, item) {

                        //alert(JSON.stringify(datos));
                        trHTML +='<tr><td>'+item.Funcion+ '</td><td align="center" style="vertical-align:middle">' + item.Calificacion + '</td><td align="center" style="vertical-align:middle">0</td></tr>';
                    });

                    trHTML +='<tr class="table-success"><td>Promedio</td><td align="center" style="vertical-align:middle">'+data.result.evad_CalificacionEmpleado+'</td><td align="center" style="vertical-align:middle">0</td></tr>';
                    tot=(0+Number(data.result.evad_CalificacionEmpleado))/2

                    trHTML +='<tr class="table-warning"><td>Total</td><td align="center" colspan="2" style="vertical-align:middle">'+tot.toFixed(2)+'</td></tr>';

                    $('#tabla').append(trHTML);

                    $('#fechap').text(data.result.evad_FechaEmpleado);
                    $('#fechap2').hide();
                    $('#fechap').show();
                    $('#fe').show();
                    $('#fj').hide();

                    $('#divanim').hide();
                    $('#tabla').show();
                    return;


                }

                if(data.result.evad_RespuestasEmpleado ==="" || data.result.evad_RespuestasEmpleado === null){
                   // alert("vacia-empleado");

                    $.each(JSON.parse(data.result.evad_RespuestasJefe), function (i, item) {

                        //alert(JSON.stringify(datos));
                        trHTML +='<tr><td>'+item.Funcion+ '</td><td align="center" style="vertical-align:middle">0</td><td align="center" style="vertical-align:middle">'+ item.Calificacion +'</td></tr>';
                    });

                    trHTML +='<tr class="table-success"><td>Promedio</td><td align="center" style="vertical-align:middle">0</td><td align="center" style="vertical-align:middle">'+data.result.evad_CalificacionJefe+'</td></tr>';

                    tot=(Number(data.result.evad_CalificacionJefe)+0)/2

                    trHTML +='<tr class="table-warning"><td>Total</td><td align="center" colspan="2" style="vertical-align:middle">'+tot.toFixed(2)+'</td></tr>';


                    $('#tabla').append(trHTML);

                    $('#fechap').hide();
                    $('#fechap2').show();
                    $('#fe').hide();
                    $('#fj').show();
                    $('#fechap2').text(data.result.evad_FechaJefe);

                    $('#divanim').hide();
                    $('#tabla').show();
                    return;

                }


                datos=JSON.parse(data.result.evad_RespuestasJefe);

               $.each(JSON.parse(data.result.evad_RespuestasEmpleado), function (i, item) {

                    //alert(JSON.stringify(datos));
                    trHTML +='<tr><td>'+item.Funcion+ '</td><td align="center" style="vertical-align:middle">' + item.Calificacion + '</td><td align="center" style="vertical-align:middle">'+datos[i].Calificacion+'</td></tr>';
                });

                trHTML +='<tr class="table-success"><td>Promedio</td><td align="center" style="vertical-align:middle">'+data.result.evad_CalificacionEmpleado+'</td><td align="center" style="vertical-align:middle">'+data.result.evad_CalificacionJefe+'</td></tr>';

                tot=(Number(data.result.evad_CalificacionJefe)+Number(data.result.evad_CalificacionEmpleado))/2

                trHTML +='<tr class="table-warning"><td>Total</td><td align="center" colspan="2" style="vertical-align:middle">'+tot.toFixed(2)+'</td></tr>';


                $('#tabla').append(trHTML);
                $('#fechap').innerHTML+='<i class="fe-calendar "></i>';

                $('#fechap').text(data.result.evad_FechaEmpleado);
                $('#fechap2').text(data.result.evad_FechaJefe);

                $('#fechap').show();
                $('#fechap2').show();

                $('#fe').show();
                $('#fj').show();

                $('#divanim').hide();
                $('#tabla').show();
                $('#fechad').show();

            }


        }).fail(function (data) {
            //toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","error");
        }).always(function (e) {

        });//ajax;
    }//ajaxResultadoDesempeno90

});

