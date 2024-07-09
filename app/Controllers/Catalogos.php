<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\CatalogosModel;
use App\Models\ConfiguracionModel;

class Catalogos extends BaseController
{

    const LOGIN_TYPE = 'usuario';

    /*
     __      _______  _____ _______        _____
     \ \    / /_   _|/ ____|__   __|/\    / ____|
      \ \  / /  | | | (___    | |  /  \  | (___
       \ \/ /   | |  \___ \   | | / /\ \  \___ \
        \  /   _| |_ ____) |  | |/ ____ \ ____) |
         \/   |_____|_____/   |_/_/    \_\_____/
    */

    //Lia->Listado de areas
    public function areas()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Areas';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Catálogo de areas', "link" => base_url('Catalogos/areas'), "class" => "active"),
        );

        //scripts
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');

        //styles
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url("assets/libs/select2/select2.min.js");
        $data['scripts'][] = base_url('assets/js/catalogos/areas.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/areas', $data);
        echo view('htdocs/footer');
    } //araes

    //Diego->Catalogo de departamentos
    public function departamentos()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Departamentos';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Catálogo de departamentos', "link" => base_url('Catalogos/departamentos')),
        );

        $model = new CatalogosModel();
        $data['empleados'] = $model->getEmpleados();
        $data['departamentos'] = $model->getCatalogoDepartamentos();

        //Styles
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        //Scripts
        $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/js/catalogos/departamentos.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/departamentos');
        echo view('htdocs/footer');
    } //end departamentos
    //Diego -> Catalogo de sucursales
    public function sucursales(){
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Sucursales';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link"=>base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Catálogo de sucursales', "link" => base_url('Catalogos/sucursales'), "class" => "active");

        $model = new CatalogosModel();
        $data['sucursales']=$model->getSucursales();

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = 'https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js';
        $data['scripts'][] = base_url('assets/js/catalogos/sucursales.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/sucursales', $data);
        echo view('htdocs/footer', $data);
    }//catalogoExpediente

    //Lia->Listado de puestos
    public function puestos()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Puestos';

        $model = new CatalogosModel();
        $data['puestos'] = $model->getPuestos();

        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Catálogo de puestos', "link" => base_url('Catalogos/puestos'), "class" => "active"),
        );

        //Styles
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url("assets/libs/footable/footable.core.min.css");
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');

        //Scripts
        $data['scripts'][] = base_url("assets/libs/select2/select2.min.js");
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url("assets/libs/footable/footable.all.min.js");
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url("assets/js/catalogos/puestos.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/puesto', $data);
        echo view('htdocs/footer');
    } //puestos

    //Lia->Vista Crear Perfil de Puestos
    public function crearPerfilPuesto($pue_PuestoID)
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Perfil del Puesto';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
            array("titulo" => 'Catálogo de puestos', "link" => base_url('Catalogos/puestos'), "class" => "active"),
            array("titulo" => 'Perfil del puesto', "link" => base_url('Catalogos/CrearPerfilPuesto/' . $pue_PuestoID), "class" => "active"),
        );

        $model = new CatalogosModel();
        $data['puestos'] = $model->getPuestosDifByID($pue_PuestoID);
        $infoPuesto = $this->db->query("Select * from puesto where pue_Estatus=1 and pue_PuestoID=?", array(encryptDecrypt('decrypt', $pue_PuestoID)))->getRowArray();
        $data['departamentos'] = $model->getDepartamentos();
        $perifilPuesto = $this->db->query("select * from perfilpuesto where per_PuestoID=" . (int)encryptDecrypt('decrypt', $pue_PuestoID))->getRowArray();
        $data['nombrePuesto'] = $infoPuesto['pue_Nombre'];
        $data['PuestoID'] = encryptDecrypt('encrypt', $infoPuesto['pue_PuestoID']);
        $data['competencias'] = $model->getCompetencias();

        $data['perfilpuesto'] = $perifilPuesto;
        if($perifilPuesto){
            $data['puestosDep'] = $perifilPuesto['per_DepartamentoID'];
            $data['idiomasR'] = $perifilPuesto['per_Idioma'];
            $data['perfilPuestoID'] = $perifilPuesto['per_PerfilPuestoID'];
            $data['puestosC'] = json_decode($perifilPuesto['per_PuestoCoordina']);
            $data['puestosR'] = json_decode($perifilPuesto['per_PuestoRepota']);
            $data['puestosF'] = json_decode($perifilPuesto['per_Funcion'], true);
        }

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url("assets/libs/footable/footable.core.min.css");

        //Scripts
        $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] = base_url('assets/libs/jquery-toast/jquery.toast.min.js');
        $data['scripts'][] = base_url('assets/js/pages/toastr.init.js');
        $data['scripts'][] = base_url("assets/libs/footable/footable.all.min.js");
        $data['scripts'][] = base_url('assets/js/catalogos/perfilPuesto.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/perfilPuestos');
        echo view('htdocs/footer');
    } //end crearPerfilPuesto


    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */

    //Diego->Catalogo de departamentos
    function addDepartamento()
    {
        $post = $this->request->getPost();
        $data = array(
            'dep_Nombre' =>  $post['nombre'],
            'dep_JefeID' =>  $post['dep_JefeID'],
            'dep_EmpleadoID' =>  session('id'),
        );
        $builder = db()->table('departamento');
        $builder->insert($data);
        $result = $this->db->insertID();
        if ($result) {
            insertLog($this, session('id'), 'Insertar', 'departamento', $result);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Departamento guardado correctamente!'));
        } else $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end addDepartamento
    //Lia->Agrega un nuevo puesto
    function addPuesto()
    {
        $post = $this->request->getPost();
        $data = array(
            'pue_Nombre' =>  $post['nombre'],
        );
        $builder = db()->table('puesto');
        $builder->insert($data);
        $result = $this->db->insertID();

        if ($result) {
            insertLog($this, session('id'), 'Insertar', 'puesto', $result);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Puesto guardado correctamente!'));
        } else $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end addPuesto

    //Lia->Edita el nombre del puesto
    function updateNombrePuesto()
    {
        $post = $this->request->getPost();
        $builder = db()->table('puesto');
        $res = $builder->update(array('pue_Nombre' => $post['nombre']), array('pue_PuestoID' => (int)encryptDecrypt('decrypt', $post['cminpuestoid'])));
        if ($res) {
            insertLog($this, session('id'), 'Actualizar', 'puesto', (int)encryptDecrypt('decrypt', $post['cminpuestoid']));
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Nombre de puesto cambiado correctamente!'));
        } else $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end updateNombrePuesto

    //Lia->Actualiza el estado de puesto
    function updatePuestoEstatus()
    {
        $post = $this->request->getPost();
        $puestoID = encryptDecrypt('decrypt', post('puestoID'));
        $estatus = 0;
        $builder = db()->table('puesto');
        $result = $builder->update(array('pue_Estatus' => $estatus), array('pue_PuestoID' => (int)$puestoID));
        $builder2 = db()->table('empleado');
        $builder2->update(array('emp_PuestoID' => null), array('emp_PuestoID' => (int)$puestoID));
        if ($result) {
            insertLog($this, session('id'), 'Cambio Estatus', 'puesto', $puestoID);
            $data['code'] = 1;
        } else $data['code'] = 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end updatePuestoEstatus

    //Lia->Agregar perfil de puesto
    public function updatePerfilPuesto()
    {
        $post = $this->request->getPost();
        $funciones = array();
        $puestoID = (int)encryptDecrypt('decrypt', $post['PuestoID']);
        $i = 1;
        foreach ($post['Funciones'] as $funcion) {
            $funciones['F' . $i] = $funcion;
            $i++;
        }
        $fjsom = json_encode($funciones);

        $resultado = $this->db->query("select COUNT(per_PuestoID) as contador from perfilpuesto where per_PuestoID=" . $puestoID)->getRowArray();
        $contador = $resultado['contador'];
        $data = array(
            "per_PuestoID" => $puestoID,
            "per_PuestoRepota" => json_encode($post['selectReporta']),
            "per_PuestoCoordina" => json_encode($post['selectCoordina']),
            "per_Horario" => $post['selectHorario'],
            "per_TipoContrato" => $post['selectContrato'],
            "per_Genero" => $post['selectGenero'],
            "per_Edad" => $post['inputEdad'],
            "per_EstadoCivil" => $post['selectEC'],
            //"per_Idioma" => $post['inputIdioma'],
            //"per_IdiomaNivel" => $post['inputIdiomaNivel'],
            "per_Escolaridad" => $post['inputEscolaridad'],
            "per_AnosExperiencia" => $post['inputAnosEx'],
            "per_DepartamentoID" => $post['selectDepartamento'],
            "per_Objetivo" => $post['inputObjetivo'],
            "per_Funcion" => $fjsom,
            "per_FechaCreacion" => date("Y-m-d h:i:sa"),
            "per_Conocimientos" =>  $post['inputConocimiento'],
        );

        $builder = db()->table('perfilpuesto');
        if ($contador == 0) {
            $result = $builder->insert($data);
            if ($result) $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se guardo el perfil del puesto correctamente!'));
            else $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al actualizar intente mas tarde!'));
        } else {
            $result = $builder->update($data, array("per_PuestoID" => "$puestoID"));
            if ($result) $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizo el perfil del puesto correctamente!'));
            else $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al actualizar intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end updatePerfilPuesto

    //Diego->añadir editar sucursal
    function addSucursal(){
        $post = $this->request->getPost();
        $builder = db()->table('sucursal');
        if(empty($post['suc_SucursalID'])){
            unset($post['suc_SucursalID']);
            $post['suc_EmpleadoID']=session('id');
            $builder->insert($post);
            $result=$this->db->insertID();
            if($result) {
                insertLog($this,session('id'),'Insertar','sucursal',$result);
                $this->session->setFlashdata(array('response'=>'success','txttoastr'=>'¡Se registro la sucursal correctamente!'));
            }else {
                $this->session->setFlashdata(array('response'=>'error','txttoastr'=>'¡Ocurrio un error al registro intente mas tarde!'));
            }
        }else{
            $result=$builder->update(array('suc_Sucursal'=>$post['suc_Sucursal']),array('suc_SucursalID'=>(int)encryptDecrypt('decrypt',$post['suc_SucursalID'])));
            if($result) {
                insertLog($this,session('id'),'Actualizar','sucursal',encryptDecrypt('decrypt',$post['suc_SucursalID']));
                $this->session->setFlashdata(array('response'=>'success','txttoastr'=>'¡Se actualizó la sucursal correctamente!'));
            }else {
                $this->session->setFlashdata(array('response'=>'error','txttoastr'=>'¡Ocurrio un error al actualizar intente mas tarde!'));
            }
        }

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }//end addSucursal

    //Diego->estatus sucursale
    function estatusSucursal($estatus,$idSucursal){
        $builder = db()->table('sucursal');
        $result=$builder->update(array('suc_Estatus'=>(int)$estatus),array('suc_SucursalID'=>(int)encryptDecrypt('decrypt',$idSucursal)));
        if($result) {
            insertLog($this,session('id'),'Cambio Estatus','sucursal',encryptDecrypt('decrypt',$idSucursal));
            $this->session->setFlashdata(array('response'=>'success','txttoastr'=>'¡Se actualizó la sucursal correctamente!'));
        }else {
            $this->session->setFlashdata(array('response'=>'error','txttoastr'=>'¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }//end estatusSucursal

    /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */

    //Lia->trae las areas
    public function ajaxGetAreas()
    {
        $model = new CatalogosModel();
        $areas = $model->getAreas();
        $areasArray = array();

        if (!empty($areas)) {
            foreach ($areas as $area) {
                $style = '';
                $estatus = '';

                if ((int)$area['are_Estatus'] === 0) {
                    $estatus = '<a class="dropdown-item activarInactivar" data-id="' . $area["are_AreaID"] . '" data-estado="' . $area["are_Estatus"] . '" href="#" >Activar</a>';
                    $style = 'style="background-color: #e6e6e6"';
                } else $estatus = '<a class="dropdown-item activarInactivar" data-id="' . $area["are_AreaID"] . '" data-estado="' . $area["are_Estatus"] . '" href="#" >Inactivar</a>';


                $html = '<div class="col-md-9 col-xl-4 item" >
                            <div class="company-card card-box" ' . $style . '>
                                    <div class="dropdown float-right">
                                        <a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">
                                            <h3 class="m-0 text-muted"><i class="mdi mdi-dots-horizontal"></i></h3>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                                            <a class="dropdown-item editarArea" data-id="' . $area["are_AreaID"] . '" href="#">Editar</a>
                                            ' . $estatus . '
                                        </div>
                                    </div>
                                <div class="float-left mr-3">
                                    <img src="' . base_url("assets/images/thigo/2.png") . '" alt="logo" class="company-logo avatar-md rounded">
                                </div>
                                <div class="company-detail mb-4">
                                    <h3 class="mb-1 nombre">' . $area["are_Nombre"] . '</h4>
                                </div>
                            </div>
                        </div>';

                array_push($areasArray, $html);
            }
        }
        echo json_encode(array("areas" => $areasArray), JSON_UNESCAPED_SLASHES);
    }

    //Lia - guarda el area
    public function ajaxSaveArea()
    {
        $post = $this->request->getPost();
        $post['are_AreaID'] = encryptDecrypt('decrypt', $post['are_AreaID']);
        $data['code'] = 0;
        $builder = db()->table("area");
        if ((int)$post['are_AreaID'] <= 0) {
            unset($post['are_AreaID']);
            $builder->insert($post);
            $result = $this->db->insertID();
            if ($result) $data['code'] = 1;
        } else {
            $result = $builder->update($post, array('are_AreaID' => (int)$post['are_AreaID']));
            if ($result) $data['code'] = 2;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia- trae la info del area
    public function ajaxGetInfoArea()
    {
        $areaID = post("areaID");
        $model = new CatalogosModel();
        $data['result'] = $model->getInfoAreaByID($areaID);
        $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->cambia el estatus del area
    public function ajaxCambiarEstadoArea()
    {
        $areaID = (int) encryptDecrypt('decrypt', post("areaID"));
        $estado = post("estado");
        $builder = db()->table("area");
        $response = $builder->update(array('are_Estatus' => (int)$estado), array("are_AreaID" => $areaID));
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Diego -> obtener informacion del departamento
    function ajax_getInfoDepartamento($departamentoID)
    {
        $departamentoID = encryptDecrypt('decrypt', $departamentoID);
        $result = $this->db->query("SELECT * FROM departamento WHERE dep_DepartamentoID = " . (int)$departamentoID)->getRowArray();
        $data = array(
            "dep_DepartamentoID" => encryptDecrypt('encrypt', $result['dep_DepartamentoID']),
            "dep_Nombre" => $result['dep_Nombre'],
            "dep_JefeID" => $result['dep_JefeID'],
        );
        if ($data) echo json_encode(array("response" => "success", "result" => $data));
        else echo json_encode(array("response" => "error", "msg" => 'Ocurrio un error. Intentelo nuevamente'));
    } //end ajax_getInfoDepartamento

    //Diego-> edita departamento
    function ajax_editarDepartamento()
    {
        $post = $this->request->getPost();
        $departamentoData = array(
            'dep_Nombre' =>  $post['nombre'],
            'dep_JefeID' => $post['dep_JefeID'],
        );
        $builder = db()->table('departamento');
        $builder->update($departamentoData, array('dep_DepartamentoID' => encryptDecrypt('decrypt', $post['id'])));
        if ($this->db->affectedRows() > 0) {
            insertLog($this, session('id'), 'Actualizar', 'departamento', encryptDecrypt('decrypt', $post['id']));
            echo json_encode(array("response" => "success"));
        } else echo json_encode(array("response" => "error"));
    } //end ajax_editarDepartamento

    //Diego->Cambia el estaus del departamento
    function ajaxUpdateDepEstatus()
    {
        $departamentoID = (int)encryptDecrypt('decrypt', post("departamentoID"));
        $estado = post("estado");
        $builder = db()->table('departamento');
        $result = $builder->update(array('dep_Estatus' => $estado), array('dep_DepartamentoID' => $departamentoID));
        if ($result) {
            insertLog($this, session('id'), 'Cambiar Estatus', 'departamento', $departamentoID);
            $data['code'] = 1;
        } else $data['code'] = 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end updateDepEstatus
    /*
    //HUGO->Get checklist egreso
    public function ajax_GetChecklistEgreso()
    {
        $puestoID = (int)encryptDecrypt('decrypt', post("puestoID"));
        $model = new CatalogosModel();
        $data = $model->getCatalogoChecklistSalida($puestoID);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_GetChecklistEgreso

    //HUGO->Guardar checklist de egreso
    public function ajax_guardarChecklistEgreso()
    {
        $puestoID = (int)encryptDecrypt('decrypt', post("puesto"));
        $datos = post("data");
        $builder = db()->table('checklistpuesto');
        $insert = array("che_PuestoID" => $puestoID, "che_Data" => $datos, "che_Tipo" => "Egreso");
        $response = $builder->insert($insert);
        $data['code'] = $response ? 1 : 0;
        echo  json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_guardarChecklistEgreso
    */

    //Lia->Get competencia - puesto
    public function ajax_getCompetenciaPuesto()
    {
        $puestoID = post("puestoID");
        $data['code'] = 1;
        $model = new CatalogosModel();
        $data['competencias'] = $model->getCompetenciasPuesto($puestoID);
        $data['puesto'] = encryptDecrypt('encrypt', $puestoID);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getCompetenciaPuesto

    //Lia->Asignar competencia a puesto
    public function ajax_asignarCompetencia()
    {
        $puestoID = post("puestoID");
        $competenciaID = (int)post("competenciaID");
        $nivel = (int)post("nivel");
        $data['code'] = 0;
        $model = new CatalogosModel();
        if ($model->competenciaAsignada($puestoID, $competenciaID)) {
            $data['code'] = 2;
        } elseif ($model->asignarCompetenciaPuesto($puestoID, $competenciaID, $nivel)) {
            $data['code'] = 1;
            $data['competencias'] = $model->getCompetenciasPuesto($puestoID);
            $data['puesto'] = encryptDecrypt('encrypt', $puestoID);
        } //if

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_asignarCompetencia

    //Lia->Eliminar competencia del puesto
    public function ajax_eliminarCompetenciaPuesto()
    {
        $id = (int)post("id");
        $puestoID = encryptDecrypt('decrypt', post("puesto"));
        $data['code'] = 0;
        $model = new CatalogosModel();
        if ($model->eliminarCompetenciasPuesto($id)) {
            $data['competencias'] = $model->getCompetenciasPuesto($puestoID);
            $data['puesto'] = $puestoID;
            $data['code'] = 1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_eliminarCompetenciaPuesto

    //Diego -> obtener informacion del sucursal
    function ajax_getInfoSucursal($sucursalID){
        $result= $this->db->query("SELECT * FROM sucursal WHERE suc_SucursalID = ".(int)encryptDecrypt('decrypt',$sucursalID))->getRowArray();
        if($result){
            $result['suc_SucursalID']=encryptDecrypt('encrypt',$result['suc_SucursalID']);
            unset($result['suc_EmpleadoID'],$result['suc_Estatus']);
            echo json_encode(array("response"=>"success","result"=>$result));
        }else{
            echo json_encode(array("response"=>"error","msg"=>'Ocurrio un error. Intentelo nuevamente'));
        }
    }//end ajax_getInfoSucursal
}
