$(document).ready(function (e) {


    $puestoID=$('#PuestoID').val();

    var i=contador;
    //Christian->Crea nuevos inputs para las funciones
    function AgregarCampos(){
        i++;
        funcionesAdd =
            '<div class="row" id="divF'+i+'" >'+
                '<div class="form-group col-md-11">' +
                    '<textarea class="form-control" name="Funciones[]" placeholder="Ingresar función" required></textarea>' +
                '</div>'+
                '<div class="form-group col-md-1 text-center pt-3">' +
                    '<button  class="btn btn-danger btn-icon  btn-icon-mini btn-round btn-sm btnEliminar" data-id="'+i+'"><i class="zmdi zmdi-minus"></i></button>'+
                '</div>'+
            '</div>';
        $("#funciones").append(funcionesAdd);
    }

    //Christian->Elimina un input agregado en funciones
    function EliminarCampos($numFuncion){
        $("#divF"+$numFuncion).remove();

    }

    $('body').on('click', '#agregarFuncion',function(evt){
        evt.preventDefault();
        AgregarCampos();
    });

    $('body').on('click', '.btnEliminar',function(evt){
        evt.preventDefault();
       EliminarCampos($(this).data('id'));
    });

    //////////////////////////////////////////////////

    var btnAsignar = $("#btnAsignar");

    ajaxGetCompetenciasPuesto({"puestoID":$puestoID});

    function ajaxGetCompetenciasPuesto(fd){
        $.ajax({
            url: BASE_URL + "Catalogos/ajax_getCompetenciaPuesto",
            type: "POST",
            dataType: "json",
            data:fd
        }).done(function (data) {
            if(data.code == 1){
                addCompetenciaTabla(data.competencias,data.puesto);
            }
        }).fail(function (data) {
            toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","error");
        }).always(function (e) {
        });//ajax;
    }//ajaxGetCompetenciasPuesto

    function addCompetenciaTabla(data,puesto){
        $("#rowsCompetencias").html("");
        if(data.length){
            for(d in data){
                let id = data[d].cmp_CompetenciaPuestoID;
                let puestoID = puesto;
                let nombre = data[d].com_Nombre.trim();
                let tipo = data[d].com_Tipo.trim();
                let nivel = parseInt(data[d].cmp_Nivel);

                switch (nivel){
                    case 1: nivel = "Bajo"; break;
                    case 2: nivel = "Minimo"; break;
                    case 3: nivel = "Medio"; break;
                    case 4: nivel = "Alto"; break;
                    case 5: nivel = "Experto"; break;
                }

                let row = '<tr>';
                row += '<td data-expanded="true">'+nombre+'</td>';
                row += '<td data-expanded="true">'+nivel+'</td>';
                row += '<td data-expanded="true">'+tipo+'</td>';
                row += '<td data-expanded="true" class="text-center">';
                row += '<button class="btn btn-danger btn-icon btn-sm btn-icon-mini btn-round btnDeleteCompetencia" data-competencia="'+id+'" data-puesto="'+puestoID+'">';
                row += '<i class="zmdi zmdi-minus"></i>';
                row += '</button>';
                row += '</td>';
                row += '</tr>';

                $("#tblCompetencias").data("footable").appendRow(row);
            }//for
        }
        else
        {
            $("#tblCompetencias").data("footable").appendRow('<tr><td colspan="4" class="text-center">No hay competencias asignadas</tr>');
        }

    }//addCompetenciaTabla

    btnAsignar.click(function (e) {
        var competenciaID = $("#selectCompetencias").val();
        var nivel = $("#selectNivel").val();
        var puestoID = $puestoID;

        if(nivel && competenciaID){
            let fd  = {"puestoID":puestoID,"competenciaID":competenciaID,"nivel":nivel};
            ajaxAsignarCompetencia(fd);
        }
        else
        {
            toastr("Selecciona la competencia y el nivel","warning");
        }//if
    });//btnAsignar

    function ajaxAsignarCompetencia(fd){
        $.ajax({
            url: BASE_URL + "Catalogos/ajax_asignarCompetencia",
            type: "POST",
            dataType: "json",
            data:fd
        }).done(function (data) {
            resetSelect();
            if(data.code == 1){
                addCompetenciaTabla(data.competencias,data.puesto);
                toastr("Se asigno la competencia al puesto.","success");

            }else if(data.code == 2)
                toastr("La competencia ya esta asignada al puesto","error");
            else
                toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","error");

        }).fail(function (data) {
            toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","error");
        }).always(function (e) {
        });//ajax;
    }//ajaxAsignarCompetencia

    $("body").on("click",".btnDeleteCompetencia",function (e) {
        let id = $(this).data("competencia");
        let puesto = $(this).data("puesto");

        ajaxEliminarCompetencia({"id":id,"puesto":puesto});

    });//btnDeleteCompetencia
    function ajaxEliminarCompetencia(fd){
        $.ajax({
            url: BASE_URL + "Catalogos/ajax_eliminarCompetenciaPuesto",
            type: "POST",
            dataType: "json",
            data:fd
        }).done(function (data) {
            if(data.code == 1){
                addCompetenciaTabla(data.competencias,data.puesto);
                toastr("La competencia se eliminó correctamente","success");
            }
            else
                toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","error");
        }).fail(function (data) {
            toastr("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","error");
        }).always(function (e) {
        });//ajax;
    }//ajaxGetCompetenciasPuesto

    /*function addCompetenciaTabla(data,puesto){
        $("#rowsCompetencias").html("");
        if(data.length){
            for(d in data){
                let id = data[d].cmp_CompetenciaPuestoID;
                let puestoID = puesto;
                let nombre = data[d].com_Nombre.trim();
                let tipo = data[d].com_Tipo.trim();
                let nivel = parseInt(data[d].cmp_Nivel);

                switch (nivel){
                    case 1: nivel = "Bajo"; break;
                    case 2: nivel = "Minimo"; break;
                    case 3: nivel = "Medio"; break;
                    case 4: nivel = "Alto"; break;
                    case 5: nivel = "Experto"; break;
                }

                let row = '<tr>';
                row += '<td data-expanded="true">'+nombre+'</td>';
                row += '<td data-expanded="true">'+nivel+'</td>';
                row += '<td data-expanded="true">'+tipo+'</td>';
                row += '<td data-expanded="true" class="text-center">';
                row += '<button class="btn btn-danger btn-sm btn-icon btnDeleteCompetencia" data-competencia="'+id+'" data-puesto="'+puestoID+'">';
                row += '<i class="fa fa-times"></i>';
                row += '</button>';
                row += '</td>';
                row += '</tr>';

                $("#tblCompetencias").data("footable").appendRow(row);
            }//for
        }
        else
        {
            $("#tblCompetencias").data("footable").appendRow('<tr><td colspan="4" class="text-center">No hay competencias asignadas</tr>');
        }

    }*///addCompetenciaTabla

    function toastr(txt,tipo){
        $.toast({
            text: txt,
            icon: tipo,
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose : true,
        });
    }//toastr

    function resetSelect(){
        $("#selectNivel").val(null).trigger('change');
        $("#selectCompetencias").val(null).trigger('change');
    }

    /**===FOOTABLE===*/
    var t=$("#tblCompetencias");

    t.footable().on("footable_filtering",function(o){
        var t=$("#selectTipos").find(":selected").val();
        o.filter+=o.filter&&0<o.filter.length?" "+t:t,o.clear=!o.filter
    });

    $("#selectTipos").change(function(o){
        o.preventDefault();
        t.trigger("footable_filter",{filter:$(this).val()})
    });

    $("#tblCom-search").on("input",function(o){
        o.preventDefault();
        t.trigger("footable_filter",{filter:$(this).val()})
    });

});