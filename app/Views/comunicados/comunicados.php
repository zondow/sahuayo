
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <div class="inbox-leftbar">
                <div class="mail-list mt-2">
                    <span href="#" id="inboxID" class="list-group-item border-0" style="padding-top: 35px;"><i class="mdi mdi-inbox font-18 align-middle mr-1"></i>Inbox <span class="badge badge-info"><?=$inbox['total']?> </span></span>
                </div>
            </div>

            <div class="inbox-rightbar">
                <div class="pt-2">
                    <div class="mt-3">
                        <table id="datatableComunicados" class="table table-hover m-0 table-centered nowrap" cellspacing="0" width="100%" >
                            <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Asunto</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
            <div class="modal-body" style="overflow-x: auto; overflow-y: auto;  max-height: 550px;" >
            
                <div class="text-center" id="temDesCom" >
                    
                </div>
            </div>
            
        </div>
    </div>
</div>