<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-12">
            <div class="card">
                <ul class="row profile_state list-unstyled">
                    <li class="col-lg-6 col-md-6 col-6">
                        <div class="body">
                            <i class="zmdi zmdi-email col-amber"></i>
                            <h4><?=$inbox?></h4>
                            <span>Total de comunicados</span>
                        </div>
                    </li>
                    <li class="col-lg-6 col-md-6 col-6">
                        <div class="body">
                            <i class="zmdi zmdi-email-open col-blue"></i>
                            <h4><?=$sinLeer?></h4>
                            <span>Comunicados pendientes</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="inbox-rightbar">
                    <div class="pt-2">
                        <div class="mt-3">
                            <table id="datatableComunicados" class="table table-hover m-0 table-centered nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
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
    </div> <!-- end Col -->
</div><!-- End row -->

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