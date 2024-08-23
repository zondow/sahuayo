<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

class Incidencias extends BaseController
{


    /*
     __      _______  _____ _______        _____
     \ \    / /_   _|/ ____|__   __|/\    / ____|
      \ \  / /  | | | (___    | |  /  \  | (___
       \ \/ /   | |  \___ \   | | / /\ \  \___ \
        \  /   _| |_ ____) |  | |/ ____ \ ____) |
         \/   |_____|_____/   |_/_/    \_\_____/
    */

    //Lia->vista de mis vacaciones
    public function misVacaciones()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Mis vacaciones';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Mis vacaciones', "link" => base_url('Incidencias/misVacaciones'), "class" => "active"),
        );

        //Data
        $data['idEmpleado'] = encryptDecrypt('encrypt', session('id'));
        $data['empleado'] = $empleado = $this->IncidenciasModel->getInfoEmpleado(session('id'));
        $data['diasLey'] = diasLey($empleado['emp_FechaIngreso']);
        $data['diasRestantes'] = diasPendientes(session('id'));
        $data['registros'] = $this->IncidenciasModel->getRegistrosByEmpleadoID();

        load_plugins(['daterangepicker', 'datatables_buttons', 'sweetalert2'], $data);

        //Custom
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/incidencias/misVacaciones.js');

        echo view("htdocs/header", $data);
        echo view("incidencias/formVacaciones");
        echo view('htdocs/modalPdf');
        echo view("htdocs/footer");
    } //end misVacaciones

    //Lia -> Lista de solicitues de vacaciones de sus empleados
    public function vacacionesMisEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Autorizar vacaciones';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Autorizar vacaciones', "link" => base_url('Incidencias/vacacionesMisEmpleados'), "class" => "active"),
        );
        $data['listVacaciones'] = $this->IncidenciasModel->getVacacionesEmpleadosJefe(session('numero'));

        load_plugins(['datatables_buttons', 'moment', 'fullcalendar', 'sweetalert2'], $data);

        //Custom Styles
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url('assets/js/incidencias/misEmpleadosVacaciones.js');
        $data['scripts'][] = base_url('assets/js/calendarioVacacionesJefe.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view("incidencias/misEmpleadosVacaciones");
        echo view('htdocs/modalPdf', $data);
        echo view('htdocs/footer', $data);
    } //end vacacionesMisEmpleados

    //Lia -> Obtiene el listado de las vacaciones para aplicar o autorizar
    public function listVacaciones()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        //Titulo
        $data['title'] = 'Aplicar vacaciones';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Aplicar vacaciones', "link" => base_url('Incidencias/listVacaciones'), "class" => "active"),
        );

        $data['listVacaciones'] = $this->IncidenciasModel->getListVacaciones(array("AUTORIZADO",  "AUTORIZADO_RH", "DECLINADO", "RECHAZADO"));

        load_plugins(['sweetalert2', 'datatables_buttons'], $data);
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        //Custom
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/incidencias/listVacaciones.js');

        echo view("htdocs/header", $data);
        echo view("incidencias/listVacaciones");
        echo view('htdocs/modalPdf');
        echo view("htdocs/footer");
    } //end listVacaciones

    //Diego->vista cambiar dias de vacacion por horas
    public function cambioVacacionesHoras()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Cambio de Vacaciones por Horas';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Cambio de Vacaciones por Horas', "link" => base_url('Incidencias/cambioVacacionesHoras'), "class" => "active"),
        );

        //Data
        $data['empleado'] = $empleado = $this->IncidenciasModel->getInfoEmpleado(session('id'));
        $data['diasLey'] = diasLey($empleado['emp_FechaIngreso']);
        $data['diasRestantes'] = diasPendientes(session('id'));
        $data['registros'] = $this->IncidenciasModel->getVacacionesHorasByEmpleadoID(session('id'));
        $data['horasExtra'] = $this->BaseModel->getHorasExtra(session('id'));

        load_plugins(['daterangepicker', 'datatables_buttons', 'sweetalert2'], $data);

        //Custom
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/incidencias/misHorasVacaciones.js');

        echo view("htdocs/header", $data);
        echo view("incidencias/formVacacionesHoras");
        echo view('htdocs/modalPdf');
        echo view("htdocs/footer");
    } //end cambioVacacionesHoras

    //Diego -> Obtiene el listado de las solicitude de horas vacaciones para aplicar o autorizar
    public function aplicarCambioHorasVac()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        //Titulo
        $data['title'] = 'Aplicar solicitud horas-vacaciones';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Aplicar solicitud', "link" => base_url('Incidencias/aplicarCambioHorasVac'), "class" => "active"),
        );

        $data['listVacaciones'] = $this->IncidenciasModel->getListVacacionesHoras();

        load_plugins(['sweetalert2', 'datatables_buttons'], $data);

        //Custom
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/incidencias/listVacacionesHoras.js');

        echo view("htdocs/header", $data);
        echo view("incidencias/listVacacionesHoras");
        echo view('htdocs/modalPdf');
        echo view("htdocs/footer");
    } //end listVacaciones

    //Lia ->El empleado solicita sus permisos
    public function misPermisos()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Mis permisos';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Mis permisos', "link" => base_url('Permiso/misPermisos'), "class" => "active");

        $data['empleado'] = $this->IncidenciasModel->getInfoEmpleado(session('id'));
        $data['catalogoPermisos'] = $this->IncidenciasModel->getCatalogoPermisos();
        $data['horasExtra'] = $this->BaseModel->getHorasExtra(session('id'));

        //Custom Styles
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Custom Scripts
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url("assets/libs/select2/select2.min.js");
        $data['scripts'][] = base_url('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

        $data['scripts'][] = base_url("assets/js/incidencias/permisos.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/formPermiso', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('htdocs/footer', $data);
    } //misPermisos

    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */

    //Diego -> Registra las vacaciones
    public function crearVacaciones()
    {
        $post = $this->request->getPost();
        $post['dias'] = calculoDias(0, session('sucursal'), $post['vac_FechaInicio'], $post['vac_FechaFin'], session('id'));

        //if ($post['dias'] <= $post['diasRestantes']) {
        if (crearVacaciones($post)) {
            $builder = db()->table("empleado");
            $empleado = $builder->getWhere(array("emp_EmpleadoID" => session('id')))->getRowArray();
            if (session('id') == 7) {
                $jefe = $this->db->query("SELECT * FROM empleado WHERE emp_EmpleadoID=19")->getRowArray();
            } else {
                $jefe = $this->db->query("SELECT * FROM empleado WHERE emp_Numero=?", array($empleado['emp_Jefe']))->getRowArray();
            }
            $datos = array();

            $datos['titulo'] = 'Solicitud de Vacaciones';
            $datos['nombre'] = $jefe['emp_Nombre'];
            $datos['cuerpo'] = 'Mediante el presente se le comunica que el colaborador a su cargo ' . $empleado['emp_Nombre'] . ', ha registrado una nueva solicitud de vacaciones en la plataforma PEOPLE.<br> Para mayor información, revise la solicitud de vacaciones en la plataforma.';

            //Enviar correo
            if (sendMail($jefe['emp_Correo'], 'Nueva solicitud de vacaciones', $datos)) {

                $notificacion = array(
                    "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
                    "not_Titulo" => 'Nueva solicitud de vacaciones',
                    "not_Descripcion" => 'El colaborador ' . $empleado['emp_Nombre'] . ' ha solicitado vacaciones.',
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/vacacionesMisEmpleados',
                    "not_Icono" => 'zmdi zmdi-flight-takeoff',
                    "not_Color" => 'bg-amber',
                );
                insert('notificacion', $notificacion);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se ha registrado la solicitud de vacaciones correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'warning', 'txttoastr' => '¡Se ha registrado la solicitud pero no se ha enviado el correo!'));
            }
        }
        /*} else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Has excedido los días permitidos!'));
        }*/
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end crearVacaciones

    //Diego -> Registra cambio de horas
    public function crearCambioHorasVac()
    {
        $post = $this->request->getPost();

        $data = array(
            'vach_EmpleadoID' => session('id'),
            'vach_Fecha' => date('Y-m-d H:i:s'),
            'vach_Dias' => $post['diasVacaciones'],
            'vach_Horas' => $post['horasVacaciones'],
            'vach_Observaciones' => $post['vach_Observaciones']
        );

        $idVacaciones = insert('vacacionhoras', $data);

        $colaborador = $this->IncidenciasModel->getInfoEmpleado(session('id'));
        if ($idVacaciones > 0) {
            if (actualizarVacacion(session('id'), $post['diasRestantes'] - $post['diasVacaciones'])) {
                $builder = db()->table("empleado");
                $empleado = $this->BaseModel->getRH();
                foreach ($empleado as $emp) {
                    $notificacion = array(
                        "not_EmpleadoID" => $emp['emp_EmpleadoID'],
                        "not_Titulo" => 'Nueva solicitud de horas',
                        "not_Descripcion" => 'El colaborador ' . $colaborador['emp_Nombre'] . ' ha solicitado horas.',
                        "not_EmpleadoIDCreo" => (int)session("id"),
                        "not_FechaRegistro" => date('Y-m-d H:i:s'),
                        "not_URL" => 'Incidencias/aplicarCambioHorasVac',
                        'not_Icono' => 'zmdi zmdi-time-countdown',
                        "not_Color" => 'bg-blue',
                    );
                    $builder = db()->table("notificacion");
                    $builder->insert($notificacion);
                    $datos = array(
                        'titulo' => 'Cambio de Vacaciones por Horas',
                        'cuerpo' => 'Mediante el presente se le comunica que el colaborador ' . $colaborador['emp_Nombre'] . ' ha solicitado un cambio de vacaciones a horas.',
                        'nombre' => $emp['emp_Nombre'],
                    );
                    sendMail($emp['emp_Correo'], 'Nueva solicitud de horas', $datos, 'VacacionesHoras');
                }
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se ha registrado la solicitud de  cambio de vacaciones por horas correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'warning', 'txttoastr' => '¡Ha ocurrido un error intente mas tarde!'));
            }
        } else {
            $this->session->setFlashdata(array('response' => 'warning', 'txttoastr' => '¡Ha ocurrido un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end crearVacaciones

    /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */

    //Lia -> Elimina una solicitud de vacaciones
    public function ajax_eliminarVacaciones()
    {
        $idVacacion = encryptDecrypt('decrypt', post('vacacionID'));
        $vacacion = $this->IncidenciasModel->getVacacion($idVacacion);
        $idEmpleado = $vacacion['vac_EmpleadoID'];
        rechazarVacaciones($idEmpleado, $idVacacion);
        $res = update('vacacion', array('vac_Estado' => 0), array("vac_VacacionesID" => $idVacacion));
        $data['code'] = 0;
        if ($res) $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_eliminarVacaciones

    public function ajax_getVacacionesEmpleadosJefe()
    {
        $numJefe = session('numero');
        $vacaciones = $this->IncidenciasModel->getVacacionesEmpleadosJefe($numJefe);

        // Mapeo de estatus a clases CSS
        $estatusClases = [
            'PENDIENTE' => 'bg-info',
            'AUTORIZADO' => 'bg-warning',
            'RECHAZADO' => 'bg-danger',
            'AUTORIZADO_GO' => 'bg-warning',
            'RECHAZADO_GO' => 'bg-danger',
            'AUTORIZADO_RH' => 'bg-success',
            'RECHAZADO_RH' => 'bg-danger',
            'DECLINADO' => 'bg-danger'
        ];

        $data_vacaciones = array_map(function ($vacacion) use ($estatusClases) {
            return [
                "title" => $vacacion['emp_Nombre'],
                "start" => $vacacion['vac_FechaInicio'],
                "end" => $vacacion['vac_FechaFin'] . " 23:59:59",
                'periodo' => 'del ' . longDate($vacacion['vac_FechaInicio'], ' de ') . ' al ' . longDate($vacacion['vac_FechaFin'], ' de '),
                'className' => $estatusClases[$vacacion['vac_Estatus']] ?? ''
            ];
        }, $vacaciones);

        echo json_encode(["events" => $data_vacaciones]);
    }

    //Lia -> Autoriza o rechaza las vacaciones el jefe directo
    public function ajax_cambiarEstatusAutorizarVacaciones()
    {
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $estatus = post('estatus');
        $observaciones = post('observaciones');
        $data['code'] = 0;
        if (autorizarVacaciones((int)$idVacaciones, $estatus, $observaciones)) {

            $empleado = $this->IncidenciasModel->getEmpleadoByVacacionID($idVacaciones);

            $notificacion = array(
                "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                "not_Titulo" => 'Solicitud de vacaciones ' . $estatus,
                "not_Descripcion" => 'La solicitud de vacaciones ha sido revisada.',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => 'Incidencias/misVacaciones',
                "not_Icono" => 'zmdi zmdi-flight-takeoff',
                "not_Color" => str_contains($estatus, 'AUTORIZADO') ? 'bg-success' : 'bg-danger',
            );
            insert('notificacion', $notificacion);
            if ($estatus == 'AUTORIZADO') {
                $ch = $this->BaseModel->getRH();
                foreach ($ch as $c) {
                    $notificacion = array(
                        "not_EmpleadoID" => $c['emp_EmpleadoID'],
                        "not_Titulo" => 'Solicitud de vacaciones por aplicar',
                        "not_Descripcion" => 'Revisar la solicitud de ' . $empleado['emp_Nombre'],
                        "not_EmpleadoIDCreo" => (int)session("id"),
                        "not_FechaRegistro" => date('Y-m-d H:i:s'),
                        "not_URL" => 'Incidencias/listVacaciones',
                        "not_Icono" => 'zmdi zmdi-flight-takeoff',
                        "not_Color" => 'bg-amber',
                    );
                    insert('notificacion', $notificacion);
                    $dataCorreo = array(
                        'titulo' => 'Vacacion Pendiente de Aplicar',
                        'cuerpo' => 'Mediante el presente se le comunica que el colaborador ' . $empleado['emp_Nombre'] . ', ha solicitado vacaciones en la plataforma PEOPLE.',
                        'nombre' => $c['emp_Nombre'],
                    );
                    sendMail($c['emp_Correo'], 'Solicitud de Vacación', $dataCorreo);
                }
            }

            $data['code'] = 1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_cambiarEstatusAutorizarVacaciones

    //Lia -> Aplica o rechaza las vacaciones recursos humanos
    public function ajax_cambiarEstatusVacaciones()
    {
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $estatus = post('estatus');
        $obs = post('observaciones');
        $data['code'] = 0;

        if (autorizarVacaciones((int)$idVacaciones, $estatus, $obs)) {

            $empleado = $this->IncidenciasModel->getEmpleadoByVacacionID($idVacaciones);

            $txt = ($estatus === 'AUTORIZADO_RH') ? 'aplicada' : 'rechazada por Recursos Humanos';

            $notificacion = array(
                "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                "not_Titulo" => 'Solicitud de vacaciones ' . $txt,
                "not_Descripcion" => 'La solicitud de vacaciones ha sido revisada.',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_Icono" => 'zmdi zmdi-flight-takeoff',
                "not_Color" => str_contains($estatus, 'AUTORIZADO') ? 'bg-success' : 'bg-danger',
            );
            insert('notificacion', $notificacion);
            $data['code'] = 1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_cambiarEstatusVacaciones

    //Diego-> declinar vacaciones
    public function ajax_declinarVacaciones()
    {
        $data['code'] = 0;
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $obs = post('obs');
        $vacacionB = $this->IncidenciasModel->getVacacion($idVacaciones);
        $idEmpleado = $vacacionB['vac_EmpleadoID'];
        $idVacacion = $vacacionB['vac_VacacionesID'];
        rechazarVacaciones($idEmpleado, $idVacacion);
        $res = update('vacacion', array("vac_Estatus" => 'DECLINADO', "vac_Justificacion" => $obs), array("vac_VacacionesID" => $idVacaciones));
        if ($res) $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end declinar vacaciones

    //Diego -> Aplica o rechaza la solicitud de vacaciones horas recursos humanos
    public function ajax_cambiarEstatusHorasVacaciones()
    {
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $estatus = post('estatus');
        $obs = post('observaciones');
        $data['code'] = 0;
        $empleado = $this->IncidenciasModel->getEmpleadoByVacacionHorasID($idVacaciones);

        if ($estatus == 'AUTORIZADO_RH') {
            $txt = "Aplicada";
            $res = update('vacacionhoras', ['vach_Estatus' => $estatus,'vach_AutorizaID' => session('id')], ["vach_VacacionHorasID" => $idVacaciones]);

            if ($res) {
                $existe = $this->IncidenciasModel->getAcumuladosByEmpleado($empleado['emp_EmpleadoID']);
                $nuevasHoras = $existe ? $existe['acu_HorasExtra'] + $empleado['vach_Horas'] : $empleado['vach_Horas'];
                $acumuladosData = ['acu_EmpleadoID' => $empleado['emp_EmpleadoID'], 'acu_HorasExtra' => $nuevasHoras ];
                $existe ? update('acumulados', ['acu_HorasExtra' => $nuevasHoras], ["acu_AcumuladosID" => $existe['acu_AcumuladosID']]) : insert('acumulados', $acumuladosData);
                $data['code'] = 1;
            }
        } else {
            $txt = "Rechazada";
            $res = update('vacacionhoras', ['vach_Estatus' => $estatus,'vach_Observaciones' => $obs ], ["vach_VacacionHorasID" => $idVacaciones]);

            if ($res) {
                $vacacionActual = $this->IncidenciasModel->getDiasVacacionByEmpleadoID($empleado['emp_EmpleadoID']);
                update('vacacionempleado', ['vace_Dias' => $vacacionActual + $empleado['vach_Dias'],'vace_FechaActualizacion' => date('Y-m-d H:i:s') ], ["vace_EmpleadoID" => $empleado['emp_EmpleadoID']]);
                $data['code'] = 1;
            }
        }

        $notificacion = [
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Solicitud de vacaciones-horas ' . $txt,
            "not_Descripcion" => 'La solicitud de horas ha sido revisada.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            'not_Icono' => 'zmdi zmdi-time-countdown',
            "not_Color" => $estatus == 'AUTORIZADO_RH' ? 'bg-green' : 'bg-red',
        ];
        insert('notificacion', $notificacion);

        sendMail($empleado['emp_Correo'], 'Solicitud de Horas Revisada', [
            'titulo' => 'Cambio de Vacaciones por Horas',
            'cuerpo' => 'Mediante el presente se le comunica que la solicitud de vacaciones a horas ha sido revisada.',
            'nombre' => $empleado['emp_Nombre']
        ], 'RevisadaVacacionesHoras');

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
    //end ajax_cambiarEstatusVacaciones

}//end controller
