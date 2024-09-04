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
        $data['horasAdministrativas'] = $this->BaseModel->getHorasAdministrativas(session('id'));

        load_plugins(['datatables_buttons', 'sweetalert2', 'chosen', 'daterangepicker',], $data);

        $data['scripts'][] = base_url("assets/js/incidencias/permisos.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/formPermiso', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('htdocs/footer', $data);
    } //misPermisos


    //Diego-> Lista de solicitues de permisos de sus empleados
    public function permisosMisEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Autorizar permisos';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Autorizar permisos', "link" => base_url('Permiso/permisosMisEmpleados'), "class" => "active");

        load_plugins(['chosen', 'daterangepicker', 'datatables_buttons', 'sweetalert2'], $data);

        //Custom Styles
        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        $data['scripts'][] = base_url("assets/js/incidencias/autorizarPermisos.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/autorizarPermisos', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('incidencias/modalesPermiso', $data);
        echo view('htdocs/footer', $data);
    } //end permisosMisEmpleados

    //Diego-> Generar Permisos
    public function aplicarPermisos()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Aplicar permisos';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Aplicar permisos', "link" => base_url('Permiso/aplicarPermisos'), "class" => "active");

        load_plugins(['chosen', 'datatables_buttons', 'sweetalert2'], $data);

        //Custom Styles
        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/aplicarPermisos.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/aplicarPermisos', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('htdocs/footer', $data);
    } //aplicarPermisos

    //Lia->reporte de asistencias
    public function reporteAsistencia()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Reporte de asistencia';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Reporte de asistencia', "link" => base_url('Incidencias/reporteAsistencia'), "class" => "active");

        load_plugins(['daterangepicker', 'jstree'], $data);

        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/incidencias/reporteAsistencia.js");

        //Vistas
        echo view('htdocs/header.php', $data);
        echo view('incidencias/formReporteAsistencia', $data);
        echo view('htdocs/footer.php', $data);
    }


    //Diego ->El empleado registra sus horas extra
    public function controlHorasExtra()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Control de horas extra';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Control de horas extra', "link" => base_url('Incidencias/controlHorasExtra'), "class" => "active");

        $data['empleado'] = $this->BaseModel->getEmpleadoByID(session('id'));

        load_plugins(['moment', 'moment_locales', 'chosen', 'daterangepicker', 'datatables_buttons', 'sweetalert2', 'bootstrapdatetimepicker'], $data);

        //Custom Styles
        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/incidencias/controlHorasExtra.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/formCHorasExtra', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('htdocs/footer', $data);
    } //end controlHorasExtra

    //Lia->informe de horas extra de los empleados a cargo
    public function horasExtraMisEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Revisar reporte de horas extra';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Revisar reporte de horas extra', "link" => base_url('Incidencias/horasExtraMisEmpleados'), "class" => "active");

        load_plugins(['datatables_buttons', 'sweetalert2'], $data);

        //Custom Scripts
        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/incidencias/reporteHorasMisEmpleados.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/reporteHorasMisEmpleados', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    } //end horasExtraMisEmpleados

    //Lia->informe de horas extra a aplicar
    public function aplicarReporteHoras()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Aplicar reporte de horas extra';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Aplicar reporte de horas extra', "link" => base_url('Incidencias/aplicarReporteHoras'), "class" => "active");

        load_plugins(['datatables_buttons', 'sweetalert2'], $data);

        //Custom Scripts
        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/incidencias/aplicarReporteHoras.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/aplicarReporteHoras', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    } //end aplicarReporteHoras

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
            $res = update('vacacionhoras', ['vach_Estatus' => $estatus, 'vach_AutorizaID' => session('id')], ["vach_VacacionHorasID" => $idVacaciones]);

            if ($res) {
                $existe = $this->IncidenciasModel->getAcumuladosByEmpleado($empleado['emp_EmpleadoID']);
                $nuevasHoras = $existe ? $existe['acu_HorasExtra'] + $empleado['vach_Horas'] : $empleado['vach_Horas'];
                $acumuladosData = ['acu_EmpleadoID' => $empleado['emp_EmpleadoID'], 'acu_HorasExtra' => $nuevasHoras];
                $existe ? update('acumulados', ['acu_HorasExtra' => $nuevasHoras], ["acu_AcumuladosID" => $existe['acu_AcumuladosID']]) : insert('acumulados', $acumuladosData);
                $data['code'] = 1;
            }
        } else {
            $txt = "Rechazada";
            $res = update('vacacionhoras', ['vach_Estatus' => $estatus, 'vach_Observaciones' => $obs], ["vach_VacacionHorasID" => $idVacaciones]);

            if ($res) {
                $vacacionActual = $this->IncidenciasModel->getDiasVacacionByEmpleadoID($empleado['emp_EmpleadoID']);
                update('vacacionempleado', ['vace_Dias' => $vacacionActual + $empleado['vach_Dias'], 'vace_FechaActualizacion' => date('Y-m-d H:i:s')], ["vace_EmpleadoID" => $empleado['emp_EmpleadoID']]);
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

    //Diego->Ver lista de permisos del empleado
    public function ajax_getPermisosByEmpleadoID()
    {
        $permisos = $this->IncidenciasModel->getPermisosByEmpleado((int)session("id"));

        $num = 1;
        foreach ($permisos as &$permiso) {
            $permiso['num'] = $num++;
            $permiso['per_PermisoID'] = encryptDecrypt('encrypt', $permiso['per_PermisoID']);
            $permiso['per_FechaInicio'] = shortDate($permiso['per_FechaInicio'], ' de ');
            $permiso['per_FechaFin'] = shortDate($permiso['per_FechaFin'], ' de ');
            $permiso['tipoPermiso'] = $permiso['tipoPermiso'];
            if ($permiso['per_Horas'] > 0 || $permiso['per_Horas'] != null) {
                $permiso['per_Motivos'] = '(De ' . shortTime($permiso['per_HoraInicio']) . ' a ' . shortTime($permiso['per_HoraFin']) . ') ' . $permiso['per_Motivos'];
            }
        }

        $data['data'] = $permisos;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getPermisosByEmpleadoID

    public function ajax_fechaColaborador($tipo, $fechaC)
    {
        //aniversario de boda
        $anioPermiso = explode('-', $fechaC);
        if ((int)$tipo === 1) {
            $fecha = $this->db->query("SELECT DATE_SUB(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaMatrimonio),DAY(emp_FechaMatrimonio)), INTERVAL 15 DAY) as 'fechaInicio', DATE_ADD(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaMatrimonio),DAY(emp_FechaMatrimonio)), INTERVAL 15 DAY) as 'fechaLimite',MONTH(emp_FechaMatrimonio) as 'mes' FROM empleado WHERE emp_EmpleadoID=" . session('id'))->getRowArray();
        } else {
            //cumpleaños
            $fecha = $this->db->query("SELECT DATE_SUB(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaNacimiento),DAY(emp_FechaNacimiento)), INTERVAL 15 DAY) as 'fechaInicio',DATE_ADD(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaNacimiento),DAY(emp_FechaNacimiento)), INTERVAL 15 DAY) as 'fechaLimite',MONTH(emp_FechaNacimiento) as 'mes' FROM empleado WHERE emp_EmpleadoID=" . session(('id')))->getRowArray();
        }
        if ($fecha['mes'] == 12 && $anioPermiso[1] == 1) {
            $fecha['fechaInicio'] = date('Y-m-d', strtotime($fecha['fechaInicio'] . ' -1 year'));
            $fecha['fechaLimite'] = date('Y-m-d', strtotime($fecha['fechaLimite'] . ' -1 year'));
        }
        if ($fecha) {
            if (($fechaC >= date('Y-m-d', strtotime($fecha['fechaInicio']))) && ($fechaC <= date('Y-m-d', strtotime($fecha['fechaLimite'])))) echo json_encode(array("code" => "1"));
            else echo json_encode(array("code" => "2"));
        } else echo json_encode(array("code" => "0"));
    }

    //Lia->Crear permiso
    public function ajax_crearPermiso()
    {
        $data['code'] = 0;
        $tipoID = (int)post('txtTipoPermiso');
        $tipoPermiso = $this->IncidenciasModel->getCatalogoPermisosById($tipoID);
        $diasPermitidos = (int)$tipoPermiso['cat_Dias'];
        $diasSolicitados = calcularDiasPermiso(post('txtFechaInicio'), post('txtFechaFin'));
        if ($diasPermitidos > 0) {
            $diasTomados = $this->IncidenciasModel->getDiasTomadosByTipoPermiso($tipoID);
            $diasRestantes = $diasTomados < $diasPermitidos ? $diasPermitidos - $diasTomados : 0;
            if ($tipoPermiso == 2) $diasRestantes = 3;
            if ($diasSolicitados > $diasPermitidos) {
                $data['code'] = 2;
                $data['msg'] = "Solo se permite solicitar $diasPermitidos días";
            } elseif ($diasSolicitados > $diasRestantes) {
                $data['code'] = 2;
                $data['msg'] = "Tienes $diasRestantes días restantes";
            }
        }
        if ($tipoID == 9) {
            $horasTomadas = $this->IncidenciasModel->getHorasTomadasByPermisoLactancia(post('txtFechaInicio'), post('txtFechaFin'));
            if ($horasTomadas >= 1) {
                $data['code'] = 2;
                $data['msg'] = "Solo se permite solicitar 1 hora en total al día durante el periodo de lactancia";
            }
        }
        $empleado = $this->BaseModel->getEmpleadoByID(session('id'));
        if ($data['code'] != 2) {
            $jefe = session('id') == 7 ? $this->BaseModel->getEmpleadoByID(19) : $this->BaseModel->getEmpleadoByNumero($empleado['emp_Jefe']);

            //Arreglo de permiso
            $permiso = array(
                'per_Fecha' => date('Y-m-d'),
                'per_FechaInicio' => post('txtFechaInicio'),
                'per_FechaFin' => post('txtFechaFin'),
                'per_HoraCreado' => date('H:i:s'),
                'per_Motivos' => post('txtMotivos'),
                'per_EmpleadoID' => (int)session('id'),
                'per_Estado' => 'PENDIENTE',
                'per_TipoID' => $tipoID,
                'per_DiasSolicitados' => $diasSolicitados,
            );
            //Si es tiempo x tiempo agrega las horas al arreglo
            if (in_array($tipoID, [7, 8])) {
                $ts1 = strtotime(str_replace('/', '-', post('txtFechaInicio') . ' ' . post('txtHoraI')));
                $ts2 = strtotime(str_replace('/', '-', post('txtFechaFin') . ' ' . post('txtHoraF')));
                $diff = abs($ts1 - $ts2) / 3600;
                $permiso['per_Horas'] = $diff;
                $permiso['per_HoraInicio'] = post('txtHoraI');
                $permiso['per_HoraFin'] = post('txtHoraF');
            } elseif (in_array($tipoID, [9])) {
                $ts1 = strtotime(str_replace('/', '-', post('txtFechaInicio') . ' ' . post('txtHoraI')));
                $ts2 = strtotime(str_replace('/', '-', post('txtFechaFin') . ' ' . post('txtHoraI')));
                $diff = abs($ts1 - $ts2) / 3600;
                $permiso['per_Horas'] = $diff;
                $permiso['per_HoraInicio'] = post('txtHoraI');
                $permiso['per_HoraFin'] = post('txtHoraF');
            }
            //guarda el arreglo
            $response = insert('permiso', $permiso);

            if ($response) {
                $datos = array(
                    'titulo' => 'Solicitud de Permiso',
                    'nombre' =>  $jefe['emp_Nombre'],
                    'cuerpo' => 'Mediante el presente se le comunica que el colaborador a su cargo ' . $empleado['emp_Nombre'] . ', ha registrado una nueva solicitud de permiso en PEOPLE.<br>Para mayor información, revise la solicitud de permiso en la plataforma.',
                );
                //Enviar correo y notificacion
                sendMail($jefe['emp_Correo'], 'Nueva solicitud de permiso', $datos, 'PermisoS');
                $notificacion = array(
                    "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
                    "not_Titulo" => 'Nueva solicitud de permiso',
                    "not_Descripcion" => 'El colaborador ' . $empleado['emp_Nombre'] . ' ha solicitado permiso.',
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/permisosMisEmpleados',
                    "not_Color" => 'bg-blue',
                    "not_Icono" => 'zmdi zmdi-calendar',
                );
                $response = insert('notificacion', $notificacion);
                $data['code'] = 1;
            }
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_crearPermiso


    //Diego->ELiminar permiso
    public function ajax_deletePermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post("permisoID"));
        $response = update('permiso', array("per_Estatus" => 0), array("per_PermisoID" => $permisoID));
        $data['code'] = $response ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_deletePermiso

    //Diego->Lista de permisos para autorizar por jefe inmediato
    public function ajax_getPermisosAutorizar()
    {
        $permisos = $this->IncidenciasModel->getPermisosPendientesMisSubordinados(session('numero'));
        $num = 1;
        foreach ($permisos as &$permiso) {
            $permiso['num'] = $num++;
            $permiso['per_PermisoID'] = encryptDecrypt('encrypt', $permiso['per_PermisoID']);
            if ($permiso['per_Horas'] > 0 || $permiso['per_Horas'] != null) {
                $permiso['per_Motivos'] = '(De ' . shortTime($permiso['per_HoraInicio']) . ' a ' . shortTime($permiso['per_HoraFin']) . ') ' . $permiso['per_Motivos'];
            }
            $permiso['per_FechaInicio'] = shortDate($permiso['per_FechaInicio'], ' de ');
            $permiso['per_FechaFin'] = shortDate($permiso['per_FechaFin'], ' de ');
            $permiso['autoriza'] = session('puesto');
            $permiso['numero'] = session('numero');
        }
        $data['data'] = $permisos;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getPermisosAutorizar

    public function ajax_rechazarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post("permisoID"));
        $this->db->transStart();

        $permiso = $this->IncidenciasModel->getInfoByPermiso($permisoID);
        $data = ['per_Justificacion' => post('obs')];

        $estados = [
            'PENDIENTE' => ['per_JefeID' => session('id'), 'per_Estado' => 'RECHAZADO_JEFE'],
            'AUTORIZADO_JEFE' => ['per_ChID' => session('id'), 'per_Estado' => 'RECHAZADO_RH']
        ];

        $data = isset($estados[$permiso['per_Estado']])
            ? array_merge($data, $estados[$permiso['per_Estado']])
            : $data;

        update('permiso', $data, ['per_PermisoID' => $permisoID]);

        $datos = [
            'titulo' => 'Solicitud de Permiso',
            'nombre' => $permiso['emp_Nombre'],
            'cuerpo' => 'Mediante el presente se le comunica que su solicitud de permiso ha sido rechazada en la plataforma PEOPLE.<br>Para mayor información, revise la solicitud de permiso en la plataforma.'
        ];

        sendMail($permiso['emp_Correo'], 'Permiso Rechazado', $datos, 'PermisoRechazado');

        insert('notificacion', [
            "not_EmpleadoID" => $permiso['emp_EmpleadoID'],
            "not_Titulo" => 'Solicitud de permiso RECHAZADO',
            "not_Descripcion" => 'La solicitud de permiso ha sido revisada.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/misPermisos',
            "not_Color" => 'bg-red',
            "not_Icono" => 'zmdi zmdi-calendar'
        ]);

        $data['code'] = $this->db->transStatus() === false ? 0 : 1;
        $this->db->transComplete();

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Diego->Jefe inmediato autoriza permiso
    public function ajax_autorizarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post("permisoID"));
        $permiso = $this->IncidenciasModel->getInfoByPermiso($permisoID);
        $data['code'] = 0;

        $data = [
            'per_TipoPermiso' => post('tipo') ?? '',
            'per_Justificacion' => post('obs') ?? ''
        ];

        if ($permiso['per_Estado'] == 'PENDIENTE') {
            $data['per_JefeID'] = session('id');
            $data['per_Estado'] = 'AUTORIZADO_JEFE';
        }

        $response = update('permiso', $data, ['per_PermisoID' => $permisoID]);

        if ($response && $permiso['per_Estado'] == 'PENDIENTE') {
            $notificado = $this->BaseModel->getRH();
            $datos_correo = [
                'titulo' => 'Solicitud de permiso por aplicar',
                'cuerpo' => 'El colaborador ' . $permiso['emp_Nombre'] . ' ha solicitado permiso.',
            ];

            foreach ($notificado as $not) {
                insert('notificacion', [
                    "not_EmpleadoID" => $not['emp_EmpleadoID'],
                    "not_Titulo" => 'Solicitud de permiso por APLICAR',
                    "not_Descripcion" => 'El colaborador ' . $permiso['emp_Nombre'] . ' ha solicitado permiso.',
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/aplicarPermisos',
                    "not_Color" => 'bg-amber',
                    "not_Icono" => 'zmdi zmdi-calendar'
                ]);

                $datos_correo['nombre'] = $not['emp_Nombre'];
                sendMail($not['emp_Correo'], 'Solicitud de permiso por aplicar', $datos_correo, 'PermisoRH');
            }
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
    //ajax_autorizarPermiso

    //Diego -> Aplicar permiso
    public function ajax_getPermisosAplicar()
    {
        $permisos = $this->IncidenciasModel->getPermisosAutorizados();
        $num = 1;
        foreach ($permisos as &$permiso) {
            $permiso['num'] = $num++;
            $permiso['per_FechaInicio'] = shortDate($permiso['per_FechaInicio'], ' de ');
            $permiso['per_FechaFin'] = shortDate($permiso['per_FechaFin'], ' de ');
            $permiso['per_Fecha'] = shortDate($permiso['per_Fecha'], ' de ');
            $permiso['per_PermisoID'] = encryptDecrypt('encrypt', $permiso['per_PermisoID']);
            if ($permiso['per_HoraCreado'] !== '00:00:00') {
                $permiso['per_Fecha'] = $permiso['per_Fecha'] . ' ' . shortTime($permiso['per_HoraCreado']);
            }
            if ($permiso['per_Horas'] > 0 || $permiso['per_Horas'] != null) {
                $permiso['per_TipoPermiso'] = '(De ' . shortTime($permiso['per_HoraInicio']) . ' a ' . shortTime($permiso['per_HoraFin']) . ')';
            }
        }
        $data['data'] = $permisos;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getPermisosAplicar

    //Diego->Aplicar permisos
    public function ajax_aplicarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post('permisoID'));

        $this->db->transStart();

        $data = [
            'per_ChID' => session('id'),
            "per_Estado" => "AUTORIZADO_RH"
        ];
        update('permiso', $data, ["per_PermisoID" => $permisoID]);

        $datosEmpleado = $this->IncidenciasModel->getInfoByPermiso($permisoID);

        $datos = [
            'titulo' => 'Solicitud de Permiso',
            'nombre' => $datosEmpleado['emp_Nombre'],
            'cuerpo' => 'Mediante el presente se le comunica a usted que su solicitud de permiso ha sido APLICADO por el área de RECURSOS HUMANOS del día ' . longDate($datosEmpleado['per_FechaInicio'], " de ") . '  al ' . longDate($datosEmpleado['per_FechaFin'], " de ") . '.'
        ];
        if (sendMail($datosEmpleado['emp_Correo'], 'Permiso aplicado', $datos, 'Permiso')) {
            insert('notificacion', [
                "not_EmpleadoID" => $datosEmpleado['emp_EmpleadoID'],
                "not_Titulo" => 'Solicitud de permiso APLICADO',
                "not_Descripcion" => 'La solicitud de permiso ha sido revisada.',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => 'Incidencias/misPermisos',
                "not_Color" => 'bg-success',
                "not_Icono" => 'zmdi zmdi-calendar'
            ]);
        }

        $data['code'] = $this->db->transComplete() ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
    //ajax_aplicarPermiso

    //Declinar permiso
    public function ajax_declinarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post('permisoID'));

        $data = [
            'per_ChID' => session('id'),
            'per_Estado' => 'DECLINADO',
            'per_Justificacion' => post('obs')
        ];

        $data['code'] = update('permiso', $data, ['per_PermisoID' => $permisoID]) ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_noAplicarPermiso

    public function ajax_GetReportesAsistencia()
    {
        $url = FCPATH . "/assets/uploads/reporteAsistencia/";
        if (!file_exists($url)) mkdir($url, 0777, true);

        $tree = array_map(function ($anio) use ($url) {
            $meses = preg_grep('/^([^.])/', scandir($url . $anio));

            $children = array_map(function ($mes) use ($anio) {
                return [
                    "id" => $anio . $mes,
                    "text" => numMeses($mes),
                    "icon" => "mdi mdi-zip-box ",
                    "state" => ["opened" => false, "disabled" => false],
                    "a_attr" => ["href" => base_url("/assets/uploads/reporteAsistencia/$anio/$mes/reporteAsistencia.xlsx")],
                    "li_attr" => ["tipo" => "periodo"],
                ];
            }, $meses);

            return [
                "text" => $anio,
                "state" => ["opened" => true, "disabled" => false, "selected" => false],
                "children" => $children,
                "li_attr" => ["tipo" => "year"]
            ];
        }, preg_grep('/^([^.])/', scandir($url)));

        echo json_encode($tree);
    }

    public function ajax_getMisHorasExtra()
    {
        $horas = $this->IncidenciasModel->getHorasExtraByEmpleado(session("id"));
        array_walk($horas, function (&$hora, $index) {
            $hora['rep_ReporteHoraExtraID'] = encryptDecrypt('encrypt', $hora['rep_ReporteHoraExtraID']);
            $hora['count'] = $index + 1;
            $hora['rep_Fecha'] = shortDate($hora['rep_Fecha'], ' de ');
        });
        echo json_encode(['data' => $horas], JSON_UNESCAPED_SLASHES);
    }

    public function ajaxAddReporteHorasExtras()
    {
        $post = $this->request->getPost();
        $empleadoID = (int)session('id');

        $reporte = [
            'rep_FechaRegistro' => date('Y-m-d'),
            'rep_EmpleadoID' => $empleadoID,
            'rep_Fecha' => $post['fecha'],
            'rep_HoraInicio' => $post['horaInicio'],
            'rep_HoraFin' => $post['horaFin'],
            'rep_Horas' => (int)calculoHorasExtra($post['horaInicio'], $post['horaFin']),
            'rep_Motivos' => $post['motivos'],
        ];

        echo json_encode(['code' => insert('reportehoraextra', $reporte) ? 1 : 0], JSON_UNESCAPED_SLASHES);
    }
}//end controller
