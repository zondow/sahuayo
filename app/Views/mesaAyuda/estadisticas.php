<div class="row ">
    <!-- Card Total tickets -->
    <div class="col-md-5">
        <div class="card-box">
            <div class="text-center mb-3">
                <div class="row">
                    <div class="col-12">
                        <div class="mt-2">
                            <h4><?= $totales['total'] ?></h4>
                            <p class="mb-0 text-muted">Total</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-2">
                            <h4><?= $totales['normales'] ?></h4>
                            <p class="mb-0 text-muted">Tickets</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-2">
                            <h4><?= $totales['genericos'] ?></h4>
                            <p class="mb-0 text-muted">Tickets genéricos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- card tickets -->
    <!-- Tendencia tickets -->
    <div class="col-md-7" id="div1">
        <div class="card-box">
            <div class="dropdown float-right">
                <a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">
                    <h3 class="m-0 text-muted"><i class="mdi mdi-dots-horizontal"></i></h3>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" id="btnExpG1"  href="#">Expandir</a>
                    <a class="dropdown-item" id="btnMinG1"  href="#">Minimizar</a>
                    <a class="dropdown-item" href="<?=base_url('MesaAyuda/infoEstadistica/1')?>">Más información</a>
                </div>
            </div>
            <h4 class="header-title mb-3">Tendencia tickets creados VS Resueltos en tiempo</h4>
            <canvas id="creadoVresuelto" height="250" class="mt-2"></canvas>
        </div>
    </div>
    <!-- Tickets por prioridad -->
    <div class="col-md-6" id="div4">
        <div class="card-box">
            <div class="dropdown float-right">
                <a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">
                    <h3 class="m-0 text-muted"><i class="mdi mdi-dots-horizontal"></i></h3>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop4">
                    <a class="dropdown-item" id="btnExpG4" href="#">Expandir</a>
                    <a class="dropdown-item" id="btnMinG4"  href="#">Minimizar</a>
                    <a class="dropdown-item" href="<?=base_url('MesaAyuda/infoEstadistica/4')?>">Más información</a>
                </div>
            </div>
            <h4 class="header-title mb-3">Tickets por prioridad</h4>
            <canvas id="ticketsPrioridad" height="250" class="mt-2"></canvas>
        </div>
    </div>
    <!-- Tickets por estatus -->
    <div class="col-md-6" id="div5">
        <div class="card-box">
            <div class="dropdown float-right">
                <a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">
                    <h3 class="m-0 text-muted"><i class="mdi mdi-dots-horizontal"></i></h3>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop5">
                    <a class="dropdown-item" id="btnExpG5" href="#">Expandir</a>
                    <a class="dropdown-item" id="btnMinG5"  href="#">Minimizar</a>
                    <a class="dropdown-item" href="<?=base_url('MesaAyuda/infoEstadistica/5')?>">Más información</a>
                </div>
            </div>
            <h4 class="header-title mb-3">Tickets por estatus</h4>
            <canvas id="ticketsEstatus" height="250" class="mt-2"></canvas>
        </div>
    </div>
    <!-- Tickets genericos por cooperativa -->
    <div class="col-md-6" id="div6">
        <div class="card-box">
            <div class="dropdown float-right">
                <a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">
                    <h3 class="m-0 text-muted"><i class="mdi mdi-dots-horizontal"></i></h3>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop6">
                    <a class="dropdown-item" id="btnExpG6" href="#">Expandir</a>
                    <a class="dropdown-item" id="btnMinG6"  href="#">Minimizar</a>
                    <a class="dropdown-item" href="<?=base_url('MesaAyuda/infoEstadistica/6')?>">Más información</a>
                </div>
            </div>
            <h4 class="header-title mb-3">Tickets genéricos</h4>
            <canvas id="ticketsGCoop" height="250" class="mt-2"></canvas>
        </div>
    </div>
    <!-- Tickets vencidos por agente -->
    <div class="col-md-6">
        <div class="card-box">
            <h4 class="header-title mb-3">Tickets vencidos por agente</h4>
            <div class="inbox-widget slimscroll" >
                <?php if ($vencidosAgente) {
                    foreach ($vencidosAgente as $vencido) { ?>
                        <a href="<?=base_url('MesaAyuda/ticketsVencidosAgente/'.$vencido['empleado'])?>">
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="<?= $vencido['foto'] ?>" class="rounded-circle shadow" alt=""></div>
                                <p class="inbox-item-author"><?= $vencido['nombre'] ?></p>
                                <span class="float-right text-danger tran-price"><?= $vencido['tickets'] ?> tickets vencidos</span>
                            </div>
                        </a>
                    <?php }
                } else { ?>
                    <a>
                        <div class="inbox-item text-center">
                            <p class="inbox-item-author">No hay ningun ticket vencido por ningun agente</p>
                        </div>
                    </a>
                <?php } ?>
            </div>

        </div>
    </div>
    <!-- Card Total % calificacion -->
    <div class="col-md-6">
        <div class="card-box">
            <div class="text-center mb-3">
                <h4 class="header-title mb-3">Experiencia del usuario (<?= numMeses(date('m')) ?> <?= date('Y') ?>)</h4>
                <div class="row">
                    <div class="col-4">
                        <div class="mt-2">
                            <img src="<?=base_url('assets/images/icons8/icons8-happy.png')?>">
                            <h4 style="color:#008744"><?= $califExperiencia['positivo'] ?> %</h4>
                            <h6 class="mb-0 ">Positivo</h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mt-2">
                        <img src="<?=base_url('assets/images/icons8/icons8-neutral.png')?>">
                            <h4 style="color:#eeba30"><?= $califExperiencia['neutro'] ?> %</h4>
                            <h6 class="mb-0">Neutro</h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mt-2">
                        <img src="<?=base_url('assets/images/icons8/icons8-sad.png')?>">
                            <h4 style="color:#AE0001"><?= $califExperiencia['negativo'] ?> %</h4>
                            <h6 class="mb-0 ">Negativo</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->



