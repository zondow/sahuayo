<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="content pt-0">
    <div class="row mb-3">
        <div class="col-md-12 mt-2 text-right">
            <?php if (revisarPermisos('Agregar', $this)) { ?>
                <button type="button" id="addArea" class="btn btn-success btn-round"> <i class="zmdi zmdi-plus"></i> Agregar </button>
            <?php } ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <input id="txtSearch" type="text" class="form-control search" placeholder="Buscar...">
    </div>
    <div class="col-md-8 pt-2 text-right ">
            <span class="text-muted text-small pt-1">Mostrando <b><?= isset($areas) ? count($areas) : 0 ?> </b> areas</span>
    </div>
</div>
<div class="row clearfix" >
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
             <div class="body table-responsive" id="divAreas">
             </div>
            </div>
        </div>
    
    </div>
</div>

<!--------------- Modal  ----------------->
<div id="modalArea" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <form id="formArea" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <input id="id" name="are_AreaID" hidden>
                    <div class="form-group col-md-12">
                        <label for="nombre">* Area </label>
                        <input type="text" id="nombre" class="form-control" name="are_Nombre" placeholder="Escriba el nombre" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                        <button id="guardar" type="button" class="btn btn-success btn-round">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(e) {
        $("#txtSearch").on("keyup", function() {
            var input = document.getElementById("txtSearch");
            var filter = input.value.toUpperCase();
            var table = document.getElementById("divAreas");
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
</script>