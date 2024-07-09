$(document).ready(function (e) {
   var btnGuardarTree =  $("#btnGuardarTree");

    $('#checklistEgreso').jstree({
        "plugins" : [ "checkbox"],
        get_selected: true,
        'core' : {
            'data' : {
                url:  BASE_URL+'Catalogos/ajax_GetChecklistEgreso',
                type: "POST",
                dataType : "json",
                data:{puestoID:btnGuardarTree.data("puesto")}
            }
        }
    }).on('changed.jstree', function (e, data) {
        /*var i, j, r = [];

        for(i = 0, j = data.selected.length; i < j; i++) {
            const tipo = $("#"+data.selected[i]).attr("tipo");
            if(tipo == "item")
                r.push(data.instance.get_node(data.selected[i]).id);
        }*/
    });



    btnGuardarTree.click(function (e) {
        var data = [];
        var selectedNodes = $('#checklistEgreso').jstree(true).get_selected('full',true);

        for(s in selectedNodes){
            var id = selectedNodes[s].id;
            var tipo = selectedNodes[s].li_attr.tipo;

            if(tipo == 'item')
                data.push(id);

        }//for
        guardarChecklist(JSON.stringify(data),btnGuardarTree.data("puesto"));
    });//btnGuardarTree

    /************FUNCTIONS**************/

    function guardarChecklist(data,puesto){
        btnGuardarTree.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Guardando...');
        $.ajax({
            url: BASE_URL+'Catalogos/ajax_guardarChecklistEgreso',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {data:data,puesto:puesto}
        }).done(function(data){
            if (data.code === 1){
                Swal.fire({
                    type: 'success',
                    title: "El checklist de egreso se guardó correctamente",
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#checklistEgreso').jstree(true).refresh();
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }//if-else
        }).fail(function(data){
            btnGuardarTree.html('<i class="fa fa-save"></i>&nbsp;Guardar');
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
            btnGuardarTree.html('<i class="fa fa-save"></i>&nbsp;Guardar');
        });//ajax
    }//guardarChecklist


    function showNotification(tipo,msg){
        $.toast({
            text:msg,
            icon: tipo,
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose : true,
        });
    }//showNotification
});