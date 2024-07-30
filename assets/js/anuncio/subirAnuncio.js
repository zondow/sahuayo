$(document).ready(function(e) {

    $(".select2-multiple").select2({
        language: "es",
        selectOnClose: false,
        allowClear: true,
        placeholder: " Seleccione",

    });

    $(".select2").select2();


    var tblPoliticas = $("#tblGestion").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        ajax: {
            url: BASE_URL + "Usuario/ajax_getAnuncio",
            dataType: "json",
            type: "POST",
            "processing": true,
        },
        columns: [
            { "data": "acciones",render: function(data,type,row){return acciones(data,type,row)}},
            { "data": "anu_Titulo"},
            { "data": "anu_FechaRegistro"},
            { "data": "estatus",render: function(data,type,row){return estado(data,type,row)}},
        ],
        columnDefs: [
            {targets:0,className: 'text-center'},
        ],
        dom:'<"row"<"col-md-6"l><"col-md-6 text-center"f><"col-md-6 cls-export-buttons"B>>rtip',
        responsive:true,
        stateSave:false,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            search: "_INPUT_",
            searchPlaceholder: "Buscar...",
            lengthMenu: "Registros por página _MENU_",
            info:"Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty:"Mostrando 0 a 0 de 0 registros",
            zeroRecords: "No hay datos para mostrar",
            loadingRecords: "Cargando...",
            infoFiltered:"(filtrado de _MAX_ registros)",
            "processing": "Procesando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":    "<i class='mdi mdi-chevron-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },
        },
        "order": [[ 2, "desc" ]],
        "processing":true,

    });

    function acciones(data,type,row){
        let button = '';
        if(row['archivo']){
            button+=' <a type="button" target="_blank"  href="'+row['archivo']+'" class="btn btn-block btn-info waves-effect waves-light " title="Ver anuncio" style="color:#FFFFFF"><i class="far fa-eye"></i> </a>';
        }
        button+=' <a type="button" href="'+BASE_URL+'Usuario/borrarAnuncio/'+row['anu_AnuncioID']+'" class="btn btn-block btn-danger waves-effect waves-light " title="Borrar" style="color:#FFFFFF"><i class="fas fa-trash"></i> </a>';
        //button+=' <a type="button" data-id="'+row['gal_Galeria']+'" data-nombre="'+row['nombre']+'" class="btn btn-block btn-success waves-effect waves-light btnEditGaleria" title="Editar nombre" style="color:#FFFFFF"><i class="fas fa-edit "></i> </a>';
        return button;
    }

    function estado(data,type,row){
        return row['anu_Estatus'] == 1 ?
        '<a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" title="Click para cambiar estatus" href="'+BASE_URL+'Usuario/estatusAnuncio/0/'+row['anu_AnuncioID']+'" >Activo</a>' :
        '<a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0 "  title="Click para cambiar estatus" href="'+BASE_URL+'Usuario/estatusAnuncio/1/'+row['anu_AnuncioID']+'" >Inactivo</a>';

    }

    $("body").on("click",".btnModalGaleria",function (e) {
        e.preventDefault();
        $("#form")[0].reset();
        $("#modalGaleria").modal("show");
    });

    $("body").on("click",".btnEditGaleria",function (e) {
        e.preventDefault();
        $("#formEdit")[0].reset();

        $("#gal_Galeria").val($(this).data('id'));
        $("#gal_NombreE").val($(this).data('nombre'));
        $("#modalEditGaleria").modal("show");
    });

});