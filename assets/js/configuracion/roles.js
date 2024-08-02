$(document).ready(function (e) {
    //Variables

    var tbl =  $("#tblRoles").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        ajax: {
            url: BASE_URL + "Configuracion/ajaxGetRoles",
            dataType: "json",
            type: "POST",
        },
        columns: [
            { "data": "cont"},
            { "data": "rol_Nombre"},
            { "data": "acciones", render: function(data,type,row){return acciones(data,type,row)} },
        ],
        responsive:true,
        stateSave:false,
        dom: 'Bfrtip',
        language: {
            paginate: {
                previous:"<i class='zmdi zmdi-caret-left'>",
                next:"<i class='zmdi zmdi-caret-right'>"
            },
            search: "_INPUT_",
            searchPlaceholder: "Buscar...",
            lengthMenu: "Registros por página _MENU_",
            info:"Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty:"Mostrando 0 a 0 de 0 registros",
            zeroRecords: "No hay datos para mostrar",
            loadingRecords: "Cargando...",
            infoFiltered:"(filtrado de _MAX_ registros)"
        },
        "order": [[ 0, "asc" ]],
        "processing":true
    });

    $('body').on('click','.addRol',function(evt){
        evt.preventDefault();
        limpiarForm();
        $("#tituloModalRol").html('Agregar rol');
        $("#modalAddEditRol").modal('show');
    });

    $('body').on('click','.editRol',function(evt){
        evt.preventDefault();
        let rolID = $(this).data("id");
        limpiarForm();
        $("#rol_RolID").val(rolID);
        ajaxGetRolByID(rolID);
        $("#tituloModalRol").html('Editar rol');
        $("#modalAddEditRol").modal('show');
    });

    function acciones(data,type,row){
        let output = '';
        let id = row.rol_RolID;
        let txt = row.rol_Nombre;
        if(revisarPermisos('Permisos','roles'))
            output += '<button type="button" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down permisosRol"  data-id="'+id+'" title="Permisos del rol"><i class="zmdi zmdi-key"></i></button>';
        if(revisarPermisos('Editar','roles'))
            output += '<button type="button" class="btn btn-info btn-icon btn-icon-mini btn-round hidden-sm-down editRol"  data-id="'+id+'" title="Permisos del rol"><i class="zmdi zmdi-edit"></i></button>';
        if(revisarPermisos('Eliminar','roles'))
            output += '<button type="button" class="btn btn-danger btn-icon btn-icon-mini btn-round hidden-sm-down deleteRol"  data-id="'+id+'" title="Eliminar rol"><i class="zmdi zmdi-delete"></i></button>';
        return output;
    }//acciones

    $("body").on("click",".deleteRol",function (e) {
        var rol = $(this).data("id");
        let fd  = {"rolID":rol};
        Swal.fire({
            title: '',
            text: '¿Esta seguro que desea eliminar el registro seleccionado?',
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if(result.value)
                ajaxEliminarRol(fd);
        })
    });

    function ajaxEliminarRol(fd){
        $.ajax({
            url: BASE_URL + "Configuracion/ajaxDeleteRol",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:fd
        }).done(function (data) {
            if(data.code === 1) {
                tbl.ajax.reload();
                $.toast({
                    text:'El registro se elimino correctamente.',
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
            else {
                $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
            }

        }).fail(function (data) {
            $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
        }).always(function (e) {

        });//ajax
    }

    function limpiarForm() {
        $('#formRol')[0].reset();
    }

    function ajaxGetRolByID(rolID){
        $.ajax({
            url: BASE_URL + "Configuracion/ajaxGetRolByID",
            type: 'post',
            dataType: 'json',
            data: "rolID="+rolID
        }).done(function (data) {
            if(data.code === 1) {
                let info = data.info;
                $("#rol_Nombre").val(info.rol_Nombre);
            } else {
                $.toast({
                    text: "No se pudo obtener la información. Por favor recargue la página e intente de nuevo.",
                    icon: "warning",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
        }).fail(function (data) {
            $.toast({
                text: "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        }).always(function (e) {

        });//ajax
    }

    /** Permisos **/
    $('body').on('click','.permisosRol',function(evt){
        evt.preventDefault();
        let rolID = $(this).data("id");
        $("#divPermisos").html('');
        ajaxGetPermisosByRol(rolID);
        $("#modalSavePermisosRol").modal('show');
    });

    function ajaxGetPermisosByRol(rolID){
        $.ajax({
            url: BASE_URL + "Configuracion/ajaxGetPermisosByRol",
            type: 'post',
            dataType: 'json',
            data: "rolID="+rolID
        }).done(function (data) {
            if(data.code === 1) {

                let funciones = data.funciones;
                let permisos = data.permisos;
                let html = '';

                html = '<table class="table table-bordered">';
                html += '<thead><tr><th>Acciones</th><th>Módulo</th><th>Descripción</th></tr></thead>';
                html += '<tbody>';
                
                $.each(funciones, function (index, value) {
                    let acciones = JSON.parse(value.fun_Acciones);
                
                    html += '<tr>';
                    html += '<td>';
                
                    $.each(acciones, function (key, val) {
                        let c = '';
                        if (permisos !== null && permisos !== '') {
                            c = (jQuery.inArray(val, permisos[value['fun_Nombre']]) >= 0) ? 'checked' : '';
                        }
                        html += '<div class="checkbox">';
                        html += '   <input type="checkbox"  id="' + value['fun_Nombre'] + key + '" name="' + value['fun_Nombre'] + '[]" value="' + val + '" ' + c + '>';
                        html += '   <label for="' + value['fun_Nombre'] + key + '">' + val + '</label>';
                        html += '</div>';
                    });
                
                    html += '</td>';
                    html += '<td>' + value['fun_Modulo'] + '</td>';
                    html += '<td class="find_Nombre">' + value['fun_Descripcion'] + '</td>';
                    html += '</tr>';
                });
                
                html += '</tbody>';
                html += '</table>';


                $("#bodyRolPermisos").html(html);
                $("#rol_RolIDP").val(rolID);
            } else {
                $.toast({
                    text: "No se pudo obtener la información. Por favor recargue la página e intente de nuevo.",
                    icon: "warning",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
        }).fail(function (data) {
            $.toast({
                text: "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        }).always(function (e) {
        });//ajax
    }

    $("#txtSearch").on("keyup", function() {
        var input = document.getElementById("txtSearch");
        var filter = input.value.toUpperCase();
        var table = document.getElementById("bodyRolPermisos");
        var rows = table.getElementsByTagName("tr");
    
        for (var i = 0; i < rows.length; i++) {
            var descripcionCell = rows[i].getElementsByClassName("find_Nombre")[0];
            if (descripcionCell) {
                var txtValue = descripcionCell.textContent || descripcionCell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }       
        }
    });
});
