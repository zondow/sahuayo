<div class="col-md-12" >
    <div class="card-box">
        <h4 class="header-title mb-3">Tendencia tickets creados VS Resueltos en tiempo</h4>
        <div class="col-md-12">
            <form method="post" id="form" class="form-horizontal" autocomplete="off">
                <div class="form-group row">
                    <label class="col-2 col-form-label"> * Periodo: </label>
                    <div class="col-8">
                        <div class="input-daterange input-group" id="date-range">
                            <input value="<?=$fechaI?>" type="text" class="form-control" id="fechaInicio" name="fechaInicio" placeholder="Seleccione" >
                            <input value="<?=$fechaF?>" type="text" class="form-control" id="fechaFin" name="fechaFin" placeholder="Seleccione" >
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="buton" id="btnConsultar" class="btn btn-success waves-effect waves-light">Consultar</button>
                    </div>
                </div>
            </form>
        </div>
        <canvas id="creadoVresuelto" height="250" class="mt-2 mb-4"></canvas>
        <div class="col-md-12">
            <div>
                <table id="tblTickets" class="table table-hover  m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Tipo</th>
                        <th>Fecha de registro</th>
                        <th>ID</th>
                        <th>Agente</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>