<?php

namespace App\Controllers;

use App\Models\CatalogosModel;

defined('FCPATH') or exit('No direct script access allowed');

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


    //Diego->Catalogo de departamentos
    public function departamentos()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Departamentos';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'),"class"=>""),
            array("titulo" => 'Catálogo de departamentos', "link" => base_url('Catalogos/departamentos'),"class"=>"active"),
        );

        $data['empleados'] = $this->BaseModel->getEmpleados();
        $data['departamentos'] = $this->CatalogosModel->getCatalogoDepartamentos();

        //pluggins
        load_plugins(['select2','datatables','sweetalert2'],$data);
       
        //custom scripts
        $data['scripts'][] = base_url('assets/js/catalogos/departamentos.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/departamentos');
        echo view('htdocs/footer');
    } //end departamentos

    //Lia->Listado de areas
    public function areas()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Areas';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Catálogo de areas', "link" => base_url('Catalogos/areas'), "class" => "active"),
        );

        //pluggins
        load_plugins(['select2','sweetalert2'],$data);

        //custom scripts
        $data['scripts'][] = base_url('assets/js/catalogos/areas.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/areas', $data);
        echo view('htdocs/footer');
    } //araes

    //Lia->Listado de puestos
    public function puestos()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Puestos';

       
        $data['puestos'] = $this->CatalogosModel->getPuestos();

        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Catálogo de puestos', "link" => base_url('Catalogos/puestos'), "class" => "active"),
        );

        //pluggins
        load_plugins(['select2','sweetalert2','footable'],$data);

        //custom scripts
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

      
        $data['puestos'] = $this->CatalogosModel->getPuestosDifByID($pue_PuestoID);
        $infoPuesto = $this->CatalogosModel->getInfoPuestoByID($pue_PuestoID);
        $data['departamentos'] = $this->CatalogosModel->getDepartamentos();
        $perifilPuesto = $this->CatalogosModel->getPerfilPuestoByPuestoId($pue_PuestoID);
        $data['nombrePuesto'] = $infoPuesto['pue_Nombre'];
        $data['PuestoID'] = encryptDecrypt('encrypt', $infoPuesto['pue_PuestoID']);
        $data['competencias'] = $this->CatalogosModel->getCompetencias();

        $data['perfilpuesto'] = $perifilPuesto;
        if($perifilPuesto){
            $data['puestosDep'] = $perifilPuesto['per_DepartamentoID'];
            $data['idiomasR'] = $perifilPuesto['per_Idioma'];
            $data['perfilPuestoID'] = $perifilPuesto['per_PerfilPuestoID'];
            $data['puestosC'] = json_decode($perifilPuesto['per_PuestoCoordina']);
            $data['puestosR'] = json_decode($perifilPuesto['per_PuestoRepota']);
            $data['puestosF'] = json_decode($perifilPuesto['per_Funcion'], true);
        }

        //pluggins
        load_plugins(['select2','footable','footable','load_select','chosen'],$data);

        //custom scripts
        //$data['scripts'][] = base_url('assets/js/catalogos/perfilPuesto.js');

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

    /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */

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
         if ($data) echo json_encode(array("response" => "success", "result" => $data),JSON_UNESCAPED_SLASHES);
         else echo json_encode(array("response" => "error", "msg" => 'Ocurrio un error. Intentelo nuevamente'),JSON_UNESCAPED_SLASHES);
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
        } else echo json_encode(array("response" => "error"),JSON_UNESCAPED_SLASHES);
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


    //Lia->trae las areas
    public function ajaxGetAreas()
    {
        
        $areas = $this->CatalogosModel->getAreas();

        $areasArray = array();

        if (!empty($areas)) {
            foreach ($areas as $area) {
                $style = '';
                $estatus = '';

                if ((int)$area['are_Estatus'] === 0) {
                    $estatus = '<a role="button" class="activarInactivar" data-id="' . $area["are_AreaID"] . '" data-estado="' . $area["are_Estatus"] . '" ><i class="zmdi zmdi-check-circle"></i></a>';
                    $style = 'style="background-color: #e6e6e6"';
                } else $estatus = '<a role="button" class=" activarInactivar" data-id="' . $area["are_AreaID"] . '" data-estado="' . $area["are_Estatus"] . '" ><i class="zmdi zmdi-check-circle"></i></a>';


                $html = '<div class="col-lg-4 col-md-6 col-sm-12 item" >
                            <div class="card project_widget" ' . $style . '>
                                <div class="header">
                                    <p><h2><strong class="find_Nombre">'. strtoupper( $area['are_Nombre']).'</strong> </h2></p>
                                    <ul class="header-dropdown">
                                        <li class="edit">
                                            <a role="button" class="editarArea"  data-id="'.$area["are_AreaID"].'"  title="Da clic para editar"><i class="zmdi zmdi-edit"></i></a>
                                        </li>
                                        <li>' . $estatus . '</li>
                                    </ul>
                                    
                                </div>
                                <div class="pw_img mb-3" style="text-align: center;">
                                    <img class="img-responsive" src="' . base_url("assets/images/monedaAlianza.png") . '" style="max-width: 25%;" >
                                </div>
                            </div>
                        </div>';

                array_push($areasArray, $html);
            }
        }
        echo json_encode(array("areas" => $areasArray), JSON_UNESCAPED_SLASHES);
    }//end ajaxGetAreas

    //Lia - guarda el area
    public function ajaxSaveArea()
    {
        $post = $this->request->getPost();
        $post['are_AreaID'] = encryptDecrypt('decrypt',$post['are_AreaID']);
        $data['code'] = 0;
        $builder = db()->table("area");
        if ((int)$post['are_AreaID'] == 0) {
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
        $areaID = encryptDecrypt('decrypt', post("areaID"));
        $data['result'] = $this->CatalogosModel->getInfoAreaByID($areaID);
        $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }//end ajaxGetInfoArea

    //Lia->cambia el estatus del area
    public function ajaxCambiarEstadoArea()
    {
        $areaID = (int) encryptDecrypt('decrypt', post("areaID"));
        $estado = post("estado");
        $builder = db()->table("area");
        $response = $builder->update(array('are_Estatus' => (int)$estado), array("are_AreaID" => $areaID));
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }//end ajaxCambiarEstadoArea

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
}