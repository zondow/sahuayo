<div class="modal fade" id="modalOnboarding" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Onboarding</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card member-card">
                        <div class=" text-center">
                            <a href="#" id="btnNotificarIngreso"  class="btn btn-primary btn-sm btn-round  "><i class="zmdi zmdi-notifications-active"></i> Notificar ingreso</a>
                        </div>
                        <div class="header l-blue">
                            <h6 class="m-t-4" id="nombre-onboarding"></h6>
                        </div>
                        <div class="member-img" id="fotoEmpOnboarding">
                        </div>
                        <div class="body">
                            <div class="col-12">
                                <p class="text-muted" id="puesto-onboarding"></p>
                                <p class="text-muted" id="departamento-onboarding"></p>
                            </div>
                            
                            <div class="progress" id="progress-container">
                            </div>
                            <p class="text-muted" id="porcentaje"></p>


                            <hr>
                            <h6 class="text-center">Checklist de ingreso</h6>
                            <form action="<?= base_url("Personal/saveOnboarding") ?>" class="form" role="form" method="post" autocomplete="off">
                                <input hidden name="col" id="col">
                                <div class="col-md-12  text-justify" id="checklist-container">                               
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-dark btn-round" data-dismiss="modal">Cancelar</button>
                    <button  type="button" id="bntGuardarOnboarding"  class="btn btn-success btn-round" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

