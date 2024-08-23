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
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Departamentos';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'),"class"=>""),
            array("titulo" => 'Catálogo de departamentos', "link" => base_url('Catalogos/departamentos'),"class"=>"active"),
        );

        $data['empleados'] = $this->BaseModel->getEmpleados();
        $data['departamentos'] = $this->CatalogosModel->getCatalogoDepartamentos();

        //pluggins
        load_plugins(['datatables_buttons','sweetalert2','chosen'],$data);
       
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

        $data['areas'] = $this->CatalogosModel->getAreas();

        //pluggins
        load_plugins(['datatables_buttons','sweetalert2'],$data);

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
        load_plugins(['datatables_buttons','sweetalert2'],$data);

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
        load_plugins(['footable','chosen'],$data);

        //custom scripts
        $data['scripts'][] = base_url('assets/js/catalogos/perfilPuesto.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/perfilPuestos');
        echo view('htdocs/footer');
    } //end crearPerfilPuesto

    //Diego -> Catalogo de sucursales
    public function sucursales(){
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Sucursales';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link"=>base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Catálogo de sucursales', "link" => base_url('Catalogos/sucursales'), "class" => "active");

        $data['sucursales']=$this->CatalogosModel->getSucursales();

        //pluggins
        load_plugins(['datatables_buttons','sweetalert2'],$data);

        //custom scripts
        $data['scripts'][] = base_url('assets/js/catalogos/sucursales.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/sucursales', $data);
        echo view('htdocs/footer', $data);
    }//end sucursales

    //Lia -> Catalogo de competencias
    function competencias()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Competencias';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Catálogo de competencias', "link" => base_url('Catalogos/competencias'), "class" => "active"),
        );
        
        $data['competenciasLocales'] = $this->CatalogosModel->getCompetencias(1);

        //pluggins
        load_plugins(['datatables_buttons','chosen'],$data);
        
        //custom scripts
        $data['scripts'][] = base_url('assets/js/catalogos/competencias.js');
        $data['scripts'][] = base_url('assets/js/catalogos/modalCompetencias.js');


        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/competencias', $data);
        echo view('catalogos/modalCompetencias', $data);
        //echo view('formacion/modalVerPreguntas', $data);
        //echo view('formacion/modalClave', $data);
        echo view('htdocs/footer', $data);
    } //end competencias

    //DiegoV->Vista para agregar editar y dar de baja proveedores
    public function proveedores()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Proveedores';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Catálogo de proveedores', "link" => base_url('Catalogos/proveedores'), "class" => "")
        );

        $data['proveedores'] = $this->CatalogosModel->getDatosProveedores();

        //pluggins
        load_plugins(['datatables_buttons'],$data);

        //custom scripts
        $data['scripts'][] = base_url('assets/js/catalogos/proveedores.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/proveedores');
        echo view('htdocs/footer');
    } //end proveedores

    //DiegoV->Vista para agregar editar y dar de baja instructores
    public function instructores()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Instructores';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'),"class" => ""),
            array("titulo" => 'Catálogo de Instructores', "link" => base_url('Catalogos/instructores'),"class" => "")
        );

        $data['empleados'] = $this->BaseModel->getEmpleados();
        $data['instructores'] = $this->CatalogosModel->getInstructores();

        //pluggins
        load_plugins(['datatables_buttons' , 'chosen'],$data);

        //custom scripts
        $data['scripts'][] = base_url("assets/js/catalogos/instructores.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/instructores');
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    } //end instructores

    //Diego->Vista para agregar editar y dar de baja cursos
    public function cursos()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Cursos';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'),"class" => ""),
            array("titulo" => 'Catálogo de cursos', "link" => base_url('Catalogos/cursos'),"class" => "")
        );

        $data['cursos'] = $this->CatalogosModel->getCursos();

        //pluggins
        load_plugins(['datatables_buttons' , 'chosen','lightbox','ckeditor','filestyle','modalPdf'],$data);

        //custom scripts
        $data['scripts'][] = base_url("assets/js/catalogos/cursos.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('catalogos/cursos');
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    } //end cursos


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

    //Lia->Update estatus competencia
    function updateCompetenciaEstatus($competenciaID, $estatus)
    {
        $competenciaID = encryptDecrypt('decrypt', $competenciaID);
        $estatus = encryptDecrypt('decrypt', $estatus);
     
        $builder = db()->table('competencia');
        $result = $builder->update(array('com_Estatus' => (int)$estatus), array('com_CompetenciaID' => (int)$competenciaID));
        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el estatus correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }//end updateCompetenciaEstatus

    //Diego -> agregar/actualizar proveedores
    public function addProveedor()
    {
        $post = $this->request->getPost();
        if ($post['pro_ProveedorID'] <= 0) {
            unset($post['pro_ProveedorID']);
            $post['pro_EmpleadoID'] = session('id');
            $builder = $this->db->table('proveedor');
            $builder->insert($post);
            $result = $this->db->insertID();
            if ($result) {
                insertLog($this, session('id'), 'Insertar', 'proveedor', $result);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se registro el proveedor correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registro intente mas tarde!'));
            }
        } else {
            $builder = $this->db->table('proveedor');
            $result = $builder->update($post, array('pro_ProveedorID' => (int)$post['pro_ProveedorID']));
            if ($result) {
                insertLog($this, session('id'), 'Actualizar', 'proveedor', $post['pro_ProveedorID']);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el proveedor correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al actualizar intente mas tarde!'));
            }
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }//end addProveedor

    //Diego->estatus proveedor
    function estatusProveedor($estatus, $idProveedor)
    {
        $idProveedor = encryptDecrypt('decrypt', $idProveedor);
        $builder = $this->db->table('proveedor');
        $result = $builder->update(array('pro_Estatus' => (int)$estatus), array('pro_ProveedorID' => (int)$idProveedor));
        if ($result) {
            insertLog($this, session('id'), 'Cambiar Estatus', 'proveedor', (int)$idProveedor);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el estatus del proveedor correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end estatusProveedor


    //Diego -> agregar/actualizar instructor
    public function addInstructor()
    {
        $post = $this->request->getPost();
        if ($post['ins_InstructorID'] <= 0) {
            unset($post['ins_InstructorID']);
            $post['ins_EmpleadoIDReg'] = session('id');
            $builder = $this->db->table('instructor');
            $builder->insert($post);
            $result = $this->db->insertID();
            if ($result) {
                insertLog($this, session('id'), 'Insertar', 'instructor', $result);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se registro el instructor correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registro intente mas tarde!'));
            }
        } else {
            $builder = $this->db->table('instructor');
            $result = $builder->update($post, array('ins_InstructorID' => (int)$post['ins_InstructorID']));
            if ($result) {
                insertLog($this, session('id'), 'Actualizar', 'instructor', $post['ins_InstructorID']);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el instructor correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al actualizar intente mas tarde!'));
            }
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
 
    //Diego->estatus instructor
    function estatusInstructor($estatus, $idInstructor)
    {
        $idInstructor = encryptDecrypt('decrypt', $idInstructor);
        $builder = $this->db->table('instructor');
        $result = $builder->update(array('ins_Estatus' => (int)$estatus), array('ins_InstructorID' => (int)$idInstructor));
        if ($result) {
            insertLog($this, session('id'), 'Cambiar Estatus', 'instructor', (int)$idInstructor);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el estatus del instructor correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end estatusInstructor

    //Diego -> agregar/actualizar curso
    public function addCurso()
    {
        $post = $this->request->getPost();
        if ($post['cur_CursoID'] <= 0) {
            $data = array(
                "cur_Nombre" => $post['cur_Nombre'],
                "cur_Objetivo" => $post['cur_Objetivo'],
                "cur_Modalidad" => $post['cur_Modalidad'],
                "cur_Horas" => $post['cur_Horas'],
                "cur_Temario" => $post['cur_Temario'],
                "cur_EmpleadoID" => session('id'),
            );
            $builder = $this->db->table('curso');
            $builder->insert($data);
            $result = $this->db->insertID();

            if ($result) {
                insertLog($this, session('id'), 'Insertar', 'curso', $result);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se registro el curso correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registro intente mas tarde!'));
            }
        } else {
            $builder = $this->db->table('curso');
            $result = $builder->update($post, array('cur_CursoID' => (int)$post['cur_CursoID']));
            if ($result) {
                insertLog($this, session('id'), 'Actualizar', 'curso', $post['cur_CursoID']);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el curso correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al actualizar intente mas tarde!'));
            }
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end addCurso

    //Diego->estatus curso
    function estatusCurso($estatus, $idCurso)
    {
        $idCurso = encryptDecrypt('decrypt', $idCurso);
        $builder = $this->db->table('curso');
        $result = $builder->update(array('cur_Estatus' => (int)$estatus), array('cur_CursoID' => (int)$idCurso));
        if ($result) {
            insertLog($this, session('id'), 'Cambiar Estatus', 'curso', (int)$idCurso);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el estatus del curso correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end estatusCurso

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


    //Lia->cambia el estatus del area
    public function ajaxCambiarEstadoSucursal()
    {
        $sucursalID = (int) encryptDecrypt('decrypt', post("sucursalID"));
        $estado = post("estado");
        $builder = db()->table("sucursal");
        $response = $builder->update(array('suc_Estatus' => (int)$estado), array("suc_SucursalID" => $sucursalID));
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

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

    //Lia -> inserta o actualiza una competencia
    function ajax_operacionesCompetencias()
    {
        $post = $this->request->getPost();

        $data = array('response' => 'error');

        $competenciaData = array(
            'com_Nombre' => $post['com_Nombre'],
            'com_Descripcion' => $post['com_Descripcion'],
            'com_Tipo' => $post['com_Tipo'],
        );
        $builder = $this->db->table('competencia');
        if (empty($post['competenciaID'])) {
            //Inserta
            $builder->insert($competenciaData);
            $result = $this->db->insertID();
        } else {
            //Actualiza
            $result = $builder->update($competenciaData, array('com_CompetenciaID' => (int)$post['competenciaID']));
        }

        if ($result) {
            $data['response'] = 'success';
            $data['msg'] = 'Datos guardados correctamente';
        } else {
            $data['msg'] = 'Ocurrio un error. Intentelo nuevamente';
        }

        echo json_encode($data);
    } //end ajax_operacionesCompetencias

    //Lia -> Obtiene la informacion de una competencia
    function ajax_getCompetenciaInfo()
    {
        $competenciaID = (int)post('competenciaID');
        $data = array('response' => 'error');
        $sql = "SELECT * FROM competencia WHERE com_CompetenciaID=?";
        $competenciaInfo = $this->db->query($sql, array($competenciaID))->getRowArray();
        if (!is_null($competenciaInfo)) {
            $data['response'] = 'success';
            $data['info'] = $competenciaInfo;
        }
        echo json_encode($data);
    } //end ajax_getCompetenciaInfo

    //Diego -> traer info curso
    public function ajax_getInfoCurso($cursoID)
    {
        $cursoID = encryptDecrypt('decrypt', $cursoID);
        $result = $this->db->query("SELECT * FROM curso WHERE cur_CursoID = " . (int)$cursoID)->getRowArray();
        if ($result) {
            echo json_encode(array("response" => "success", "result" => $result));
        } else {
            echo json_encode(array("response" => "error", "msg" => 'Ocurrio un error. Intentelo nuevamente'));
        }
    } //end ajax_getInfoCurso


}