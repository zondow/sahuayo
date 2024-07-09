<!--------------- Modal  ----------------->
<div class="modal fade in" id="modalAddTicket" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-next"></b> Registrar ticket</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form id="formTicket" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <label for="tituloTicket">* Titulo del inicidente</label>
                        <input type="text" id="tituloTicket" class="form-control text-center" name="tituloTicket" placeholder="Escriba el titulo del incidente" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="areaTicket">* Área de Federación</label>
                        <select type="text" id="areaTicket" class="form-control text-center select2" name="areaTicket" style="width: 100%;" required>
                            <option hidden>Seleccione</option>
                            <?php
                                foreach($areas as $area){
                                    echo '<option value="'.encryptDecrypt('encrypt',$area['are_AreaID']).'">'.$area['are_Nombre'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="servicioTicket">* Servicio</label>
                        <select type="text" id="servicioTicket" class="form-control text-center select2" name="servicioTicket" style="width: 100%;" required>
                            <option hidden>Seleccione</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="archivoTicket" class="col-form-label"> Archivo</label>
                        <input type="file" class="form-control" type="file" id="archivoTicket" name="archivoTicket[]" multiple data-msg-placeholder="Seleccione los archivos de apoyo. (Formatos: .jpg, .jpeg, .png, .docx, .xlsx, .txt, .pdf)." >
                    </div>
                    <div class="form-group col-md-12">
                        <label for="descripcionTicket">* Descripción</label>
                        <textarea class="form-control" rows="3" id="descripcionTicket" name="descripcionTicket" value=''></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="cancelTicket" type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button id="guardarTicket" type="button" class="btn btn-primary waves-effect waves-light guardar">Guardar</button>
                    <button id="loadTicket" class="btn btn-primary waves-effect waves-light "><i class="fas fa-spinner fa-pulse"></i>&nbsp; Guardando...</button>
                </div>
            </form>

        </div>
    </div>
</div>