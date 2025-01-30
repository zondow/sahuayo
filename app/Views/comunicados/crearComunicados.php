<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 text-right">
                    <a href="#" class="btn btn-success btn-round btnComunicado">
                        <i class="zmdi zmdi-plus"></i> Agregar
                    </a>
                </div>
                <div class="mt-3">
                    <div class="table-responsive">
                        <table id="datatableComunicados" class=" table table-hover nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Estado</th>
                                    <th>Asunto</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--------------- Modal Agregar ----------------->
<div id="modalComunicado" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="titleModal">Nuevo comunicado</h4>
            </div>
            <form id="formComunicado" enctype="multipart/form-data" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <div class="form-group col-md-12">
                        <label for="com_Asunto" class="col-form-label">* Asunto</label>
                        <input type="text" class="form-control" id="com_Asunto" name="com_Asunto" placeholder="Asunto del comunicado" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="filtro" class="col-form-label">* Filtro:</label>
                        <select id="filtro" class="select2" name="filtro" style="width: 100%" style="width: 100%">
                            <option value="" hidden>Seleccione</option>
                            <option value="empleados">Todos</option>
                            <option value="filtrar">Filtrar empleados</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12" id="divColaboradores">
                        <label for="com_Empleados" class="col-form-label">* Colaboradores</label>
                        <select id="com_Empleados" class="select2" required name="com_Empleados[]" style="width: 100%" multiple="multiple">
                            <?php foreach ($empleados as $empleado) { ?>
                                <option value="<?= encryptDecrypt('encrypt', $empleado['emp_EmpleadoID']) ?>"><?= $empleado['emp_Nombre'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="com_Descripcion" class="col-form-label">* Contenido</label>
                        <textarea class="form-control" rows="3" id="com_Descripcion" name="com_Descripcion" placeholder="Contenido del comunicado" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success btn-round" id="btnGuardar">Guardar</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>


<!--------------- Modal ----------------->
<div id="modalRemitentes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Destinatarios</h4>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 p-4">
                        <table class="table table-hover m-0 table-centered  nowrap" cellspacing="0" width="100%" id="tableRemitentes">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Colaborador</th>
                                    <th>Visto</th>
                                    <th>Enterado</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------------- Ver comunicado ----------------->
<div id="modalVerComunicado" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="temAsuntoCom"></h4>
            </div>
            <div class="modal-body" style="overflow-x: auto; overflow-y: auto;  max-height: 550px;">

                <div class="text-center" id="temDesCom">

                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function(e) {
        $('.select2').select2({
            dropdownParent: $('#modalComunicado .modal-body'),
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>