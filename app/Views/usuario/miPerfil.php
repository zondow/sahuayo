<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12">
            <div class="card member-card">
                <div class="header l-blush-azul">
                    <h6 class="m-t-10"><?= session('nombre') ?></h6>
                </div>
                <div class="member-img">
                    <a href="#" class="">
                        <img src="<?= fotoPerfil(encryptDecrypt('encrypt', session('id'))); ?>" class="rounded-circle" alt="profile-image">
                    </a>
                </div>
                <div class="body">
                    <div class="col-12">
                        <p class="text-muted"><?= session('nombrePuesto') ?></p>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-muted">Total de solicitudes</p>
                        </div>
                        <div class="col-4">
                            <h5>852</h5>
                            <small>Vacaciones</small>
                        </div>
                        <div class="col-4">
                            <h5>13k</h5>
                            <small>Permisos</small>
                        </div>
                        <div class="col-4">
                            <h5>234</h5>
                            <small>Incapacidades</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#about">Mis datos</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#friends">Friends</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane body active" id="about">
                        <small class="text-muted">Correo: </small>
                        <p><?= $informacion['correo']; ?></p>
                        <hr>
                        <small class="text-muted">Phone: </small>
                        <p>+ 202-555-0191</p>
                        <hr>
                        <ul class="list-unstyled">
                            <li>
                                <div>Photoshop</div>
                                <div class="progress m-b-20">
                                    <div class="progress-bar l-blue " role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%"> <span class="sr-only">62% Complete</span> </div>
                                </div>
                            </li>
                            <li>
                                <div>Wordpress</div>
                                <div class="progress m-b-20">
                                    <div class="progress-bar l-green " role="progressbar" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100" style="width: 56%"> <span class="sr-only">87% Complete</span> </div>
                                </div>
                            </li>
                            <li>
                                <div>HTML 5</div>
                                <div class="progress m-b-20">
                                    <div class="progress-bar l-amber" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%"> <span class="sr-only">32% Complete</span> </div>
                                </div>
                            </li>
                            <li>
                                <div>Angular</div>
                                <div class="progress m-b-20">
                                    <div class="progress-bar l-blush" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: 43%"> <span class="sr-only">56% Complete</span> </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane body" id="friends">
                        <ul class="new_friend_list list-unstyled row">
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="assets/images/sm/avatar1.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Jackson</h6>
                                    <small class="join_date">Today</small>
                                </a>
                            </li>
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="assets/images/sm/avatar2.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Aubrey</h6>
                                    <small class="join_date">Yesterday</small>
                                </a>
                            </li>
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="assets/images/sm/avatar3.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Oliver</h6>
                                    <small class="join_date">08 Nov</small>
                                </a>
                            </li>
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="assets/images/sm/avatar4.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Isabella</h6>
                                    <small class="join_date">12 Dec</small>
                                </a>
                            </li>
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="assets/images/sm/avatar1.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Jacob</h6>
                                    <small class="join_date">12 Dec</small>
                                </a>
                            </li>
                            <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                <a href="">
                                    <img src="assets/images/sm/avatar5.jpg" class="img-thumbnail" alt="User Image">
                                    <h6 class="users_name">Matthew</h6>
                                    <small class="join_date">17 Dec</small>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#project">Project</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#timeline">Timeline</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#usersettings">Setting</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="project">
                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card project_widget">
                                <div class="header">
                                    <h2><strong>Mi departamento</strong><small class="text-muted"><?= session('departamentoNombre') ?></small></h2>
                                </div>
                                <div class="body">
                                    <ul class="list-unstyled team-info m-t-20">
                                        <li class="m-r-15"><small>Team</small></li>
                                        <?php $colaboradores = db()->query("SELECT emp_EmpleadoID,emp_Nombre FROM empleado WHERE emp_DepartamentoID=? AND emp_EmpleadoID != ?", [session('departamento'),session('id')])->getResultArray();
                                        if ($colaboradores) {
                                            foreach ($colaboradores as $col) {
                                                echo '<li><img src="' . fotoPerfil(encryptDecrypt('encrypt', $col['emp_EmpleadoID'])) . '" alt="' . $col['emp_Nombre'] . '"></li>';
                                            }
                                        } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card project_widget">
                                <div class="header">
                                    <h2><strong>ID</strong> 32564 <small class="text-muted">Last Update: 12 Dec 2017</small></h2>
                                    <ul class="header-dropdown">
                                        <li class="edit">
                                            <a role="button" class="boxs-edit"><i class="zmdi zmdi-edit"></i></a>
                                        </li>
                                        <li class="remove">
                                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="pw_img">
                                    <img class="img-responsive" src="assets/images/image3.jpg" alt="About the image">
                                </div>
                                <div class="body">
                                    <h6>eCommerce Website</h6>
                                    <ul class="list-unstyled team-info m-t-20">
                                        <li class="m-r-15"><small>Team</small></li>
                                        <li><img src="assets/images/xs/avatar10.jpg" alt="Avatar"></li>
                                        <li><img src="assets/images/xs/avatar9.jpg" alt="Avatar"></li>
                                        <li><img src="assets/images/xs/avatar8.jpg" alt="Avatar"></li>
                                        <li><img src="assets/images/xs/avatar7.jpg" alt="Avatar"></li>
                                        <li><img src="assets/images/xs/avatar6.jpg" alt="Avatar"></li>
                                    </ul>
                                    <div class="progress-container progress-primary">
                                        <span class="progress-badge">Project Status</span>
                                        <div class="progress ">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100" style="width: 86%;">
                                                <span class="progress-value">86%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card project_widget">
                                <div class="header">
                                    <h2><strong>ID</strong> 25846 <small class="text-muted">Last Update: 12 Dec 2017</small></h2>
                                    <ul class="header-dropdown">
                                        <li class="edit">
                                            <a role="button" class="boxs-edit"><i class="zmdi zmdi-edit"></i></a>
                                        </li>
                                        <li class="remove">
                                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="pw_img">
                                    <img class="img-responsive" src="assets/images/image1.jpg" alt="About the image">
                                </div>
                                <div class="body">
                                    <h6>iOS Game Development</h6>
                                    <ul class="list-unstyled team-info m-t-20">
                                        <li class="m-r-15"><small>Team</small></li>
                                        <li><img src="assets/images/xs/avatar3.jpg" alt="Avatar"></li>
                                        <li><img src="assets/images/xs/avatar4.jpg" alt="Avatar"></li>
                                        <li><img src="assets/images/xs/avatar5.jpg" alt="Avatar"></li>
                                        <li><img src="assets/images/xs/avatar6.jpg" alt="Avatar"></li>
                                        <li><img src="assets/images/xs/avatar7.jpg" alt="Avatar"></li>
                                    </ul>
                                    <div class="progress-container progress-success">
                                        <span class="progress-badge">Project Status</span>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 23%;">
                                                <span class="progress-value">23%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card project_widget">
                                <div class="header">
                                    <h2><strong>ID</strong> 32564 <small class="text-muted">Last Update: 12 Dec 2017</small></h2>
                                    <ul class="header-dropdown">
                                        <li class="edit">
                                            <a role="button" class="boxs-edit"><i class="zmdi zmdi-edit"></i></a>
                                        </li>
                                        <li class="remove">
                                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="pw_img">
                                    <img class="img-responsive" src="assets/images/image4.jpg" alt="About the image">
                                </div>
                                <div class="body">
                                    <h6>Home Development</h6>
                                    <ul class="list-unstyled team-info m-t-20">
                                        <li class="m-r-15"><small>Team</small></li>
                                        <li><img src="assets/images/xs/avatar1.jpg" alt="Avatar"></li>
                                        <li><img src="assets/images/xs/avatar2.jpg" alt="Avatar"></li>
                                        <li><img src="assets/images/xs/avatar3.jpg" alt="Avatar"></li>
                                    </ul>
                                    <div class="progress-container progress-info">
                                        <span class="progress-badge">Project Status</span>
                                        <div class="progress ">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100" style="width: 68%;">
                                                <span class="progress-value">68%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="timeline">
                    <ul class="cbp_tmtimeline">
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-04T18:30"><span class="hidden">25/12/2017</span> <span class="large">Now</span></time>
                            <div class="cbp_tmicon"><i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel empty"> <span>No Activity</span> </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-04T03:45"><span>03:45 AM</span> <span>Today</span></time>
                            <div class="cbp_tmicon bg-info"><i class="zmdi zmdi-label"></i></div>
                            <div class="cbp_tmlabel">
                                <h2><a href="javascript:void(0);">Art Ramadani</a> <span>posted a status update</span></h2>
                                <p>Tolerably earnestly middleton extremely distrusts she boy now not. Add and offered prepare how cordial two promise. Greatly who affixed suppose but enquire compact prepare all put. Added forth chief trees but rooms think may.</p>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>01:22 PM</span> <span>Yesterday</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                <h2><a href="javascript:void(0);">Job Meeting</a></h2>
                                <p>You have a meeting at <strong>Laborator Office</strong> Today.</p>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> <span>Two weeks ago</span></time>
                            <div class="cbp_tmicon bg-blush"><i class="zmdi zmdi-pin"></i></div>
                            <div class="cbp_tmlabel">
                                <h2><a href="javascript:void(0);">Arlind Nushi</a> <span>checked in at</span> <a href="javascript:void(0);">New York</a></h2>
                                <blockquote>
                                    <p class="blockquote blockquote-primary">
                                        "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout."
                                        <br>
                                        <small>
                                            - Isabella
                                        </small>
                                    </p>
                                </blockquote>
                                <div class="row clearfix">
                                    <div class="col-lg-12">
                                        <div class="map m-t-10">
                                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.91477011208!2d-74.11976308802028!3d40.69740344230033!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sin!4v1508039335245" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> <span>Two weeks ago</span></time>
                            <div class="cbp_tmicon bg-orange"><i class="zmdi zmdi-camera"></i></div>
                            <div class="cbp_tmlabel">
                                <h2><a href="javascript:void(0);">Eroll Maxhuni</a> <span>uploaded</span> 4 <span>new photos to album</span> <a href="javascript:void(0);">Summer Trip</a></h2>
                                <blockquote>Pianoforte principles our unaffected not for astonished travelling are particular.</blockquote>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"><img src="assets/images/image1.jpg" alt="" class="img-fluid img-thumbnail m-t-30"></a> </div>
                                    <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"> <img src="assets/images/image2.jpg" alt="" class="img-fluid img-thumbnail m-t-30"></a> </div>
                                    <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"> <img src="assets/images/image3.jpg" alt="" class="img-fluid img-thumbnail m-t-30"> </a> </div>
                                    <div class="col-lg-3 col-md-6 col-6"><a href="javascript:void(0);"> <img src="assets/images/image4.jpg" alt="" class="img-fluid img-thumbnail m-t-30"> </a> </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>01:22 PM</span> <span>Two weeks ago</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-case"></i></div>
                            <div class="cbp_tmlabel">
                                <h2><a href="javascript:void(0);">Job Meeting</a></h2>
                                <p>You have a meeting at <strong>Laborator Office</strong> Today.</p>
                            </div>
                        </li>
                        <li>
                            <time class="cbp_tmtime" datetime="2017-10-22T12:13"><span>12:13 PM</span> <span>Month ago</span></time>
                            <div class="cbp_tmicon bg-blush"><i class="zmdi zmdi-pin"></i></div>
                            <div class="cbp_tmlabel">
                                <h2><a href="javascript:void(0);">Arlind Nushi</a> <span>checked in at</span> <a href="javascript:void(0);">Laborator</a></h2>
                                <blockquote>Great place, feeling like in home.</blockquote>
                            </div>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane" id="usersettings">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Security</strong> Settings</h2>
                        </div>
                        <div class="body">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Current Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="New Password">
                            </div>
                            <button class="btn btn-info btn-round">Save Changes</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2><strong>Account</strong> Settings</h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="E-mail">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Country">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="4" class="form-control no-resize" placeholder="Address Line 1"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <input id="procheck1" type="checkbox">
                                        <label for="procheck1">Profile Visibility For Everyone</label>
                                    </div>
                                    <div class="checkbox">
                                        <input id="procheck2" type="checkbox">
                                        <label for="procheck2">New task notifications</label>
                                    </div>
                                    <div class="checkbox">
                                        <input id="procheck3" type="checkbox">
                                        <label for="procheck3">New friend request notifications</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-round">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>