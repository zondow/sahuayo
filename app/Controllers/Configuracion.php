<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');
class Configuracion extends BaseController
{


    /*
     __      _______  _____ _______        _____
     \ \    / /_   _|/ ____|__   __|/\    / ____|
      \ \  / /  | | | (___    | |  /  \  | (___
       \ \/ /   | |  \___ \   | | / /\ \  \___ \
        \  /   _| |_ ____) |  | |/ ____ \ ____) |
         \/   |_____|_____/   |_/_/    \_\_____/
    */

    //Diego -> Catalogo de roles donde puede asignar las funciones
    public function roles()
    {
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Roles de usuario';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), 'class' => '');
        $data['breadcrumb'][] = array("titulo" => 'Configuración de roles de usuario', "link" => base_url('Configuracion/roles'), 'class' => 'active');

        //plugins
        load_plugins(['datatables','sweetalert2'],$data);

        //Custom Styles
        //Custom Scripts
        $data['scripts'][] = base_url('assets/js/configuracion/roles.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/roles');
        echo view('configuracion/modalPermisosRol');
        echo view('htdocs/footer');
    } //roles

    public function diasInhabiles()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Días inhabiles';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), 'class' => ''),
            array("titulo" => 'Configuración de días inhabiles', "link" => base_url('Configuracion/diasInhabiles'), 'class' => 'active')
        );

        load_plugins(['moment','jquery_ui','fullcalendar','select','select2'],$data);

        //Custom Styles
        //Custom Scripts
        $data['scripts'][] = base_url('assets/js/configuracion/inhabiles.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/diasInhabiles');
        echo view('htdocs/footer');
    } //diasInhabiles

    //Lia->vista para la configuracion de las prestaciones
    public function prestaciones()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Prestaciones';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), 'class' => ''),
            array("titulo" => 'Configuración de prestaciones', "link" => base_url('Usuario/prestaciones'), 'class' => 'active')
        );

        //Prestaciones actuales
        $configuracionA = $this->ConfiguracionModel->getConfiguracionPrestacionesActuales();
        $data['vacaciones'] = json_decode($configuracionA['vco_DiasVacaciones'], true);
        $data['prima'] = json_decode($configuracionA['vco_Prima'], true);
        $data['aguinaldo'] = json_decode($configuracionA['vco_Aguinaldo'], true);
        $data['rangos'] = getSetting('rangos_vacaciones');
        $data['rangosPrima'] = getSetting('rangos_prima');
        $data['rangosAguinaldo'] = getSetting('rangos_aguinaldo');

        //Prestaciones adicionales
        $prestacionesAdicionales = $this->ConfiguracionModel->getPrestacionAdicional();
        $data['prestamo'] = json_decode($prestacionesAdicionales['pre_Prestamo'], true);

        load_plugins(['datatables4','sweetalert'],$data);
        //Styles custom
        //Scripts custom

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/prestaciones');
        echo view('htdocs/footer');
    } // end prestaciones

    //Diego->Configuracion de dias por tipo de permiso
    public function configuracionPermisos()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Permisos';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), 'class' => '');
        $data['breadcrumb'][] = array("titulo" => 'Configuración de permisos', "link" => base_url('Configuracion/configuracionPermisos'), 'class' => 'active');

        load_plugins(['datatable','datatables_buttons','sweetalert2','moment_locales','datetimepicker'],$data);
        //Styles
        //Scripts        
        $data['scripts'][] = base_url('assets/js/configuracion/configuracionPermisos.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/configPermisos');
        echo view('configuracion/modalEditConfigPermisos');
        echo view('htdocs/footer');
    } //configuracionPermisos

    //Diego -> Configuracion de Expediente
    public function configuracionExpediente()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Configuración del expediente';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Configuración del expediente', "link" => base_url('Configuracion/configuracionExpediente'), "class" => "active");

        $data['expedientes'] = $this->ConfiguracionModel->getExpedientes();

        load_plugins(array('datatables_buttons'),$data);

        //Styles
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        //Scripts
        $data['scripts'][] = 'https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js';
        $data['scripts'][] = base_url('assets/js/configuracion/expedientes.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/expedientes', $data);
        echo view('htdocs/footer', $data);
    } //configuracionExpediente

    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */

    //Lia -> Guarda los nuevos roles o las actualizaciones
    public function saveRol()
    {
        $post = $this->request->getPost();
        $rolID = (int)encryptDecrypt('decrypt', $post['rol_RolID']);
        unset($post['rol_RolID']);
        if ($rolID > 0) {
            $res = update('rol', $post, array('rol_RolID' => $rolID));
            if ($res > 0) {
                insertLog($this, session('id'), 'Actualizar', 'rol', $rolID);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Datos actualizados correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'danger', 'txttoastr' => 'Los datos no cambiarón. Intente nuevamente.'));
            }
        } else {
            $res = insert('rol', $post);
            if ($res > 0) {
                insertLog($this, session('id'), 'Insertar', 'rol', $this->db->insertID());
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Registro creado correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'danger', 'txttoastr' => 'Ha ocurrido un error al intentar registrar los datos. Intente nuevamente.'));
            }
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //saveRol

    //Lia -> Guarda la configuracion de las prestaciones actuales
    public function guardarPrestacionesActuales()
    {
        $post = $this->request->getPost();

        //Preparando el json de la configuracion de los dias de vacaciones
        $diasVacaciones = array();
        for ($i = 0; $i < count($post['dias']); $i++) {
            $row = array("periodo" => $post['periodo'][$i], "dias" => $post['dias'][$i]);
            array_push($diasVacaciones, $row);
        }
        //Preparando el json de la configuracion de la prima
        $primas = array();
        for ($i = 0; $i < count($post['prima']); $i++) {
            $row = array("periodoP" => $post['periodoP'][$i], "prima" => $post['prima'][$i]);
            array_push($primas, $row);
        }
        //Preparando el json de la configuracion del aguinaldo
        $aguinaldos = array();
        for ($i = 0; $i < count($post['aguinaldo']); $i++) {
            $row = array("periodoA" => $post['periodoA'][$i], "aguinaldo" => $post['aguinaldo'][$i]);
            array_push($aguinaldos, $row);
        }

        //Preparando el array de los datos de la tabla
        $data = array(
            "vco_DiasVacaciones" => json_encode($diasVacaciones),
            "vco_Prima" => json_encode($primas),
            "vco_Aguinaldo" => json_encode($aguinaldos),
            "vco_Tipo" => $post['tipo'],
        );

        //Saber is ya se guardo alguna configuracion de la empresa
        $config = db()->table('vacacionconfig')->getWhere(array("vco_Tipo" => 'Actual'))->getRowArray();
        if ($config) {
            $res = update('vacacionconfig', $data, array("vco_Tipo" => 'Actual'));
            insertLog($this, session('id'), 'Actualizar', 'vacacionconfig', 1);
        } else {
            $res = insert('vacacionconfig', $data);
            insertLog($this, session('id'), 'Insertar', 'vacacionconfig', 1);
        }

        if ($res) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Datos guardados correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Intente nuevamente!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end guardarPrestacionesActuales

    //Lia -> Guarda la configuracion de las prestaciones adicionales
    public function guardarPrestacionesAadicionales()
    {
        $post = $this->request->getPost();
        //Preparando el json de la configuracion prestamos
        $prestamos = array();
        for ($i = 0; $i < count($post['diasPrestamo']); $i++) {
            $row = array("periodo" => $post['periodoPrestamos'][$i], "dias" => $post['diasPrestamo'][$i], "plazo" => $post['plazo'][$i]);
            array_push($prestamos, $row);
        }

        //Preparando el array de los datos de la tabla
        $data = array(
            "pre_Prestamo" => json_encode($prestamos),
        );

        //Saber is ya se guardo alguna configuracion de la empresa
        $config = $this->db->query("SELECT * FROM prestacion")->getRowArray();
        if ($config) {
            $res = update('prestacion', $data);
            insertLog($this, session('id'), 'Actualizar', 'prestacion', 1);
        } else {
            $res = insert('prestacion', $data);
            insertLog($this, session('id'), 'Insertar', 'prestacion', 1);
        }

        if ($res) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡La configuración de las prestaciones adicionales se ha guardado correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Intente nuevamente!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end guardarPrestacionesActuales

    //Diego->estatus expediente
    function estatusExpediente($estatus, $idExpediente)
    {
        $idExpediente = encryptDecrypt('decrypt', $idExpediente);
        $result = update('expediente', array('exp_Estatus' => (int)$estatus), array('exp_ExpedienteID' => (int)$idExpediente));
        if ($result) {
            insertLog($this, session('id'), 'Cambio Estatus', 'expediente', $idExpediente);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el expediente correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end estatusExpediente

    /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */

    //Lia->Tre los roles
    public function ajaxGetRoles()
    {
        $roles = $this->ConfiguracionModel->getRoles();
        $cont = 1;
        foreach ($roles as &$rol) {
            $rol['rol_RolID'] = encryptDecrypt('encrypt', $rol['rol_RolID']);
            $rol['cont'] = $cont;
            $cont++;
        }

        $data['data'] = $roles;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajaxGetRoles

    //Lia -> Obtiene la informacion de un rol segun su id
    public function ajaxGetRolByID()
    {
        $datos = $this->ConfiguracionModel->getRolByID(post('rolID'));
        echo json_encode(array('code' => is_null($datos) ? 0 : 1, 'info' => $datos));
    } //ajaxGetRolByID

    //Lia -> Cambia el estatus del rol a 0
    public function ajaxDeleteRol()
    {
        $data['code'] = 1;
        $rolID = (int)encryptDecrypt('decrypt', post("rolID"));
        update("rol", array('rol_Estatus' => 0), array('rol_RolID' => $rolID));
        if ($this->db->affectedRows() > 0) {
            insertLog($this, session('id'), 'Cambio Estatus', 'rol', $rolID);
        } else $data['code'] = 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //deleteRol

    //Lia -> Obtiene la informacion de los permisos de un rol segun su id
    public function ajaxGetPermisosByRol()
    {
        $rolID = post('rolID');
        $datos = $this->ConfiguracionModel->getPermisosByRol($rolID);
        echo json_encode(array('code' => is_null($datos) ? 0 : 1, 'funciones' => $datos['funciones'], 'permisos' => $datos['permisos']));
    } //ajaxGetPermisosByRol

    //Diego->Trae todos los dias inhabiles
    public function ajax_getDiasInhabiles()
    {
        $dias = $this->BaseModel->getDiasInhabiles();
        $data_events = array();

        foreach ($dias as $d) {
            $data_events[] = array(
                "ID" => encryptDecrypt('encrypt', $d['dia_DiaInhabilID']),
                "title" => $d['dia_Motivo'],
                "start" => $d['dia_Fecha'],
                'bd' => 'diainhabil',
                "end" => $d['dia_Fecha'],
                'eliminar' => 'si',
                "backgroundColor" => "#2a7c7d",
            );
        }
        echo json_encode(array("events" => $data_events));
    } //end ajax_getDiasInhabiles

    //Diego->Trae todos los dias inhabiles ley
    public function ajax_getDiasInhabilesLey()
    {
        $dias = $this->BaseModel->getDiasInhabilesLey();
        $data_events = array();

        foreach ($dias as $d) {
            $data_events[] = array(
                "ID" => encryptDecrypt('encrypt', $d['dial_DiaInhabilLeyID']),
                "title" => $d['dial_Motivo'],
                "start" => $d['dial_Fecha'],
                "end" => $d['dial_Fecha'],
                'bd' => 'diainhabilley',
                'eliminar' => 'no',
                "backgroundColor" => "#f1556c",
            );
        }
        echo json_encode(array("events" => $data_events));
    } //end ajax_getDiasInhabilesLey

    //Diego->Informacion del dia inhabil
    public function ajax_getDiaInhabil($idDiaInhabil, $bd)
    {
        $idDiaInhabil = encryptDecrypt('decrypt', $idDiaInhabil);
        if ($bd === 'diainhabil') {
            $dias = $this->db->query("SELECT DI.* FROM diainhabil DI WHERE DI.dia_DiaInhabilID=" . $idDiaInhabil)->getRowArray();

            $sucursales = json_decode($dias['dia_SucursalID']);
            $txt = "";
            foreach ($sucursales as $sucursal) {
                if ($sucursal == 0) {
                    $txt = "<span class='badge badge-purple'>Todos</span> ";
                } else {
                    $sql = "SELECT suc_Sucursal FROM sucursal WHERE suc_SucursalID= ?";
                    $nomSuc = $this->db->query($sql, array($sucursal))->getRowArray();
                    $txt .= "<span class='badge badge-purple'>" . $nomSuc['suc_Sucursal'] . "</span> ";
                }
            }

            $dia = array(
                'dia_Motivo' => $dias['dia_Motivo'],
                'dia_DiaInhabilID' => $dias['dia_DiaInhabilID'],
                'dia_Fecha' => $dias['dia_Fecha'],
                'sucursal' => $txt,
            );
        } else {
            $dias = $this->db->query("SELECT DI.*, DI.dial_Motivo as 'dia_Motivo' FROM diainhabilley DI WHERE DI.dial_DiaInhabilLeyID=" . $idDiaInhabil)->getRowArray();
            $dia = array(
                'dia_Motivo' => $dias['dia_Motivo'],
                'sucursal' => "<span class='badge badge-purple'>Todas</span>",
            );
        }
        echo json_encode(array("response" => "success", "dia" => $dia));
    } //end ajax_getDiaInhabil

    //Diego->Añadir dia inhabil
    public function ajax_addDiaInhabil()
    {
        $post = $this->request->getPost();
        $sucursal = json_encode($post['sucursales']);
        if ($post['dia_MedioDia'] == 1) {
            $post['dia_Motivo'] = $post['dia_Motivo'] . '(Media Jornada)';
        }
        $data = array(
            "dia_Fecha" => $post['dia_Fecha'],
            "dia_Motivo" => $post['dia_Motivo'],
            "dia_SucursalID" => $sucursal,
            "dia_EmpleadoID" => session('id'),
            "dia_MedioDia" => $post['dia_MedioDia'],
        );

        $result = insert('diainhabil', $data);
        insertLog($this, session('id'), 'Insertar', 'diainhabil', $result);
        echo json_encode(array("response" => "success", "fecha" => $post['dia_Fecha']));
    } //end ajax_addDiaInhabil

    //Diego->Eliminar un dia inhabil
    public function ajax_eliminarDiaInhabil($idDiaInhabil)
    {
        $idDiaInhabil = encryptDecrypt('decrypt', $idDiaInhabil);
        delete('diainhabil', array('dia_DiaInhabilID' => $idDiaInhabil));
        insertLog($this, session('id'), 'Eliminar', 'diainhabil', $idDiaInhabil);
        echo json_encode(array("response" => "success"));
    } //end ajax_eliminarDiaInhabil

    //Lia->trae los puestos
    public function ajax_getSucursales()
    {
        $roles = $this->BaseModel->getSucursales(); // Ejemplo de uso del modelo
        echo json_encode(array("info" => $roles));
    } //end ajax_getSucursales

    //Diego->Get configuracion de permisos
    public function ajax_getConfiguracionPermisos()
    {
        $permisos = $this->ConfiguracionModel->getConfiguracionPermisos();
        foreach ($permisos as &$permiso) {
            $permiso['cat_CatalogoPermisoID'] = encryptDecrypt('encrypt', $permiso['cat_CatalogoPermisoID']);
            $permiso['cat_Dias'] = ($permiso['cat_Dias'] == 0) ? 'Sin limite' : $permiso['cat_Dias'];
        }

        $data['data'] = $permisos;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getConfiguracionPermisos
    
    //Diego-> cambiar estdo del permiso
    public function ajaxCambiarEstadoPermiso()
    {
        $response = update('catalogopermiso',array('cat_Estatus' => post("estado")), array("cat_CatalogoPermisoID" => (int)encryptDecrypt('decrypt', post("permisoID")))); 
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajaxCambiarEstadoPermiso

    //Diego->Get calatogo permisos by id
    public function ajax_getCatalogoPermisoById()
    {
        $data['catalogo'] = $this->ConfiguracionModel->getConfiguracionPermisosById(post("catalogoID"));
        $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getCatalogoPermisoById
    
    //Diego->Actualizar catalogo permisos
    public function  ajax_updateCatalogoPermisos()
    {
        $response = update('catalogopermiso', array("cat_Dias" => (int)post("dias")), array('cat_CatalogoPermisoID' => (int)encryptDecrypt('decrypt', post("id"))));
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_updateCatalogoPermisos
}
