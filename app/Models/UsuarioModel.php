<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{

    //Lia-> colaboradores a cargo
    public function getColaboradoresJefe(){
        return $this->db->query("SELECT E.emp_Nombre,E.emp_EmpleadoID FROM empleado E LEFT JOIN departamento D ON D.dep_DepartamentoID=E.emp_DepartamentoID LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID WHERE E.emp_Estatus=1 AND E.emp_Jefe='".session('numero')."'")->getResultArray();
    }

    //Lia->Get informacion cumpleaños
    function getInformacionCumpleaños(){
        return $this->db->query("SELECT emp_EmpleadoID,emp_Nombre, emp_FechaNacimiento FROM empleado WHERE emp_Estatus=1")->getResultArray();
    }//getInformacionCumpleaños

    //Diego-> get informacion de guardia
    function getInformacionGuardia(){
        return $this->db->query("SELECT gua_FechaFin FROM guardia WHERE gua_EmpleadoID=?",[session('id')])->getResultArray();
    }//getInformacionGuardia

    //Lia->Dias Inhabiles ley
    public function getDiasInhabilesLey(){
        return $this->db->query("SELECT * FROM diainhabilley")->getResultArray();
    }// end getDiasInhabilesLey

    //Lia->Dias Inhabiles
    public function getDiasInhabiles(){
        $sucursalEmpleado = db()->query("SELECT emp_SucursalID FROM empleado WHERE emp_EmpleadoID=".session('id'))->getRowArray();
        $sucursal = '["'.$sucursalEmpleado['emp_SucursalID'].'"]';
        $todos = '["0"]';
        return $this->db->query("SELECT * FROM diainhabil WHERE JSON_CONTAINS(dia_SucursalID,'".$sucursal."') OR JSON_CONTAINS(dia_SucursalID,'".$todos."')")->getResultArray();
    }// end getDiasInhabiles

    //Diego->aniversarios empleadp
    public function getAniversarios(){
        return $this->db->query("SELECT emp_EmpleadoID, emp_Nombre,DAY(emp_FechaIngreso) as 'dia',MONTH(emp_FechaIngreso) as 'mes',YEAR(emp_FechaIngreso) as 'year',emp_FechaIngreso FROM empleado WHERE emp_Estatus=1 AND emp_Estado='Activo'")->getResultArray();
    }// end getAniversarios

    //Lia->Get informacion evaluaciones
    function getPeriodosEvaluaciones(){
        return $this->db->query("SELECT *,DATE_ADD(eva_FechaFin, Interval 1 day) as 'eva_FechaFin' FROM evaluacion WHERE eva_Estatus=1")->getResultArray();
    }

    public function getCursosByEmpleado($idEmpleado){
        $sql = "SELECT CU.cur_Nombre,C.*
                FROM capacitacionempleado CE
                  LEFT JOIN capacitacion C ON C.cap_CapacitacionID=CE.cape_CapacitacionID
                  LEFT JOIN curso CU ON CU.cur_CursoID=cap_CursoID
                  LEFT JOIN empleado E ON E.emp_EmpleadoID=CE.cape_EmpleadoID
                WHERE CE.cape_EmpleadoID=?";
        return  $this->db->query($sql,array($idEmpleado))->getResultArray();
    }

    //Diego->vacaciones del empleado
    public function getVacaciones(){
        return $this->db->query("SELECT emp_Nombre,vac_FechaInicio,DATE_ADD(vac_FechaFin, Interval 1 day) as 'vac_FechaFin' FROM vacacion JOIN empleado ON emp_EmpleadoID=vac_EmpleadoID WHERE vac_Estado=1 AND vac_Estatus='AUTORIZADO_RH' AND emp_EmpleadoID=".session('id'))->getResultArray();
    }// end getVacaciones

    //Lia-> Mi informacion
    function miInformacion(){
        $sql = "select
                    E.emp_Nombre as 'nombre',
                    E.emp_Username as 'username',
                    E.emp_Numero as 'noEmpleado',
                    E.emp_Correo as 'correo',
                    E.emp_Direccion as 'direccion',
                    E.emp_FechaIngreso as 'ingreso',
                    E.emp_FechaNacimiento as 'nacimiento',
                    E.emp_Curp as 'curp',
                    E.emp_Rfc as 'rfc',
                    E.emp_Nss as 'nss',
                    E.emp_Telefono as 'telefono',
                    D.dep_Nombre as 'departamento',
                    PU.pue_Nombre as 'puesto',
                    JEFE.emp_Nombre as 'jefe',
                    E.emp_FechaMatrimonio as 'fechaMatrimonio',
                    E.emp_EstadoCivil as 'estadoCivil'
                from empleado E
                    left join departamento D on D.dep_DepartamentoID = E.emp_DepartamentoID
                    left join puesto PU on PU.pue_PuestoID = E.emp_PuestoID
                    left join empleado JEFE on JEFE.emp_Numero = E.emp_Jefe
                where E.emp_EmpleadoID = ?";
        return $this->db->query($sql,[(int)session("id")])->getRowArray();
    }//miInformacion

    //Lia-> Get colaboradores por departamento
    function getColaboradores(){
        $empleadoID = (int)session("id");
        $dptoID = (int)session("departamento");

        $sql = "select emp_EmpleadoID, emp_Nombre, emp_Correo
                from empleado
                where emp_Estatus=1 AND emp_DepartamentoID = ? and emp_EmpleadoID != ?  ";
        $where = array($dptoID,$empleadoID);

        return $this->db->query($sql,$where)->getResultArray();
    }//getColaboradores

    //Lia-> Perfil de puesto
    function getPerfilPuesto(){
        $perfilID = (int)session("puesto");
        $sql = "select
                  P.per_PerfilPuestoID as 'id',
                  PU.pue_Nombre as 'puesto',
                  P.per_PuestoCoordina as 'puestosCoordina',
                  P.per_Horario as 'horario',
                  P.per_PuestoRepota as 'puestosReporta',
                  P.per_Objetivo as 'objetivo',
                  P.per_Genero as 'genero',
                  P.per_Edad as 'edad',
                  P.per_EstadoCivil as 'estadoCivil',
                  P.per_Idioma as 'idioma',
                  P.per_IdiomaNivel as 'idiomaNivel',
                  P.per_AnosExperiencia as 'aniosExperiencia',
                  P.per_Escolaridad as 'escolaridad',
                  D.dep_Nombre as 'departamento',
                  P.per_Funcion as 'funciones',
                  P.per_TipoContrato as 'tipoContrato',
                  P.per_Conocimientos as 'conocimientos'
                from perfilpuesto P
                  left join puesto PU on PU.pue_PuestoID =  P.per_PuestoID
                  left join departamento D on D.dep_DepartamentoID =  P.per_DepartamentoID
                where P.per_Estatus = 1 and  P.per_PuestoID = ?";

        return $this->db->query($sql,array($perfilID))->getRowArray();
    }//getPerfilPuesto

    //Lia -> obtiene el total de incidencias de un empleado
    public function getIncidenciasByEmpleado($empleadoID){
        $empleadoID = (int)$empleadoID;

        $sql = "SELECT COUNT(*) AS 'contador'
                FROM permiso P
                WHERE P.per_EmpleadoID=? AND P.per_Estado='AUTORIZADO_RH'";
        $permisos = $this->db->query($sql,array($empleadoID))->getRowArray();

        $sql = "SELECT COUNT(*) AS 'contador'
                FROM vacacion V
                WHERE V.vac_EmpleadoID=? AND V.vac_Estatus='AUTORIZADO_RH'";
        $vacaciones = $this->db->query($sql,array($empleadoID))->getRowArray();

        $sql = "SELECT COUNT(*) AS 'contador'
                FROM incapacidad I
                WHERE I.inc_EmpleadoID=? AND I.inc_Estatus='Autorizada'";
        $incapacidades = $this->db->query($sql,array($empleadoID))->getRowArray();

        $incidencias = array(
            'permisos'      => $permisos['contador'],
            'vacaciones'    => $vacaciones['contador'],
            'incapacidades' => $incapacidades['contador'],
        );

        return $incidencias;
    }

    //Lia->Get puestos a coordinar y/o reportar (perfil de puesto)
    function getPuestosCoordinaReporta($puestos){
        $sql = "select P.pue_Nombre as 'puesto' from puesto P where P.pue_Estatus = 1 and P.pue_PuestoID in (".$puestos.")";
        return $this->db->query($sql)->getResultArray();
    }//getPuestosCoordina

    //Lia->Get competencias puesto
    function getCompetenciasPuesto($puestoID){
        $sql = 'select CP.*, C.com_Nombre, C.com_Tipo,C.com_CompetenciaID
                from competenciapuesto CP
                left join competencia C on C.com_CompetenciaID = CP.cmp_CompetenciaID
                where CP.cmp_PuestoID = ? ORDER BY CP.cmp_CompetenciaPuestoID DESC ';
        return $this->db->query($sql,array((int)$puestoID))->getResultArray();
    }//getCompetenciasPuesto

    public function getHorasExtra(){
        $horasExtra= db()->query("SELECT SUM(rep_Horas) as 'horas' FROM reportehoraextra WHERE rep_Estado='PAGADO' AND rep_TipoPago='Tiempo por tiempo' AND rep_EmpleadoID=?",array(session('id')))->getRowArray()['horas']??0;
        //$horasExtraVacaciones= db()->query("SELECT SUM(vach_Horas) as 'horas' FROM vacacionhoras WHERE vach_Estado=1 AND vach_Estatus='AUTORIZADO_RH' AND vach_EmpleadoID=".session('id'))->getRowArray()['horas']??0;
        $horasAcumuladas=$this->db->query("SELECT acu_HorasExtra as 'horas' FROM acumulados WHERE acu_EmpleadoID=?",[session('id')])->getRowArray()['horas']??0;
        $horasConsumidas = db()->query("SELECT SUM(per_Horas) AS 'horas' FROM permiso WHERE per_Estado IN ('PENDIENTE','AUTORIZADO_GG','AUTORIZADO_GO','AUTORIZADO_RH') AND per_Estatus=1 AND per_EmpleadoID=".session('id'))->getRowArray()['horas']??0;
        return ($horasExtra+$horasAcumuladas/*+$horasExtraVacaciones*/)-$horasConsumidas;
    }

    public function getHorasExtraByEmpleadoID($empleadoID){
        $horasExtra= $this->db->query("SELECT SUM(rep_Horas) as 'horas' FROM reportehoraextra WHERE rep_Estado='PAGADO' AND rep_TipoPago='Tiempo por tiempo' AND rep_EmpleadoID=".$empleadoID)->getRowArray()['horas'] ?? 0;
        //$horasExtraVacaciones= db()->query("SELECT SUM(vach_Horas) as 'horas' FROM vacacionhoras WHERE vach_Estado=1 AND vach_Estatus='AUTORIZADO_RH' AND vach_EmpleadoID=".$empleadoID)->getRowArray()['horas']??0;
        $horasAcumuladas=$this->db->query("SELECT acu_HorasExtra as 'horas' FROM acumulados WHERE acu_EmpleadoID=".$empleadoID)->getRowArray()['horas'] ?? 0;
        $horasConsumidas = $this->db->query("SELECT SUM(per_Horas) as 'horas' FROM permiso WHERE per_TipoID=7 AND per_Estatus=1 AND per_EmpleadoID=" . $empleadoID . " AND per_Estado IN ('PENDIENTE','AUTORIZADO_GG','AUTORIZADO_GO','AUTORIZADO_RH')")->getRowArray()['horas'] ?? 0;
        return ($horasExtra+$horasAcumuladas/*+$horasExtraVacaciones*/)-$horasConsumidas;
    }

    function getComunicadosInbox(){
        $idEmpleado=session('id');
        $sql = "SELECT COUNT(*) as 'total' FROM noticomunicado
                JOIN comunicado ON com_ComunicadoID=not_ComunicadoID
                WHERE com_Estatus=1 AND com_Estado='Enviado'
                  AND not_Enterado=0 AND not_Visto=0 AND not_EmpleadoID=?";
        return $this->db->query($sql,array($idEmpleado))->getRowArray();
    }

    public function getComunicados(){
        $idEmpleado=session('id');
        $sql = "SELECT * FROM noticomunicado
                JOIN comunicado ON com_ComunicadoID=not_ComunicadoID
                WHERE com_Estatus=1 AND com_Estado='Enviado' AND not_EmpleadoID=?";
       return $this->db->query($sql,array($idEmpleado))->getResultArray();
    }


    public function getRetardosColaborador()
    {
        $retardos = 0;
        //registros del mes
        $queryMes = "SELECT DISTINCT(asi_Fecha) as 'dia' FROM asistencia WHERE asi_EmpleadoID=".session('id')." AND MONTH(asi_Fecha)=".date('m')." AND YEAR(asi_Fecha)=".date('Y')." ORDER BY asi_Fecha DESC LIMIT 1";
        $ultimoDia = $this->db->query($queryMes)->getRowArray();
        if($ultimoDia){
            $ultimoDia=$ultimoDia['dia'];
            $lastDay=explode('-',$ultimoDia);
            $registros = array();
            $i=1;
            $fechaIngreso = $this->db->query("SELECT DAY(emp_FechaIngreso) as 'dia' FROM empleado WHERE emp_EmpleadoID=? AND MONTH(emp_FechaIngreso)=? AND YEAR(emp_FechaIngreso)=?",array(session('id'),date('m'),date('Y')))->getRowArray()['dia'] ?? null;
            if($fechaIngreso){
                $i=$fechaIngreso;
            }
            for($i;$i<=$lastDay[2];$i++){
                if($i<10) $i = '0'.$i;
                array_push($registros,array('dia'=>$lastDay[0].'-'.$lastDay[1].'-'.$i));
            }
            if(date('Y-m')=='2023-11'){
                $fechaLimite = "2023-11-15";
                $filtrarPorFecha = function ($registro) use ($fechaLimite) {
                    return $registro["dia"] >= $fechaLimite;
                };
                $registros = array_filter($registros, $filtrarPorFecha);
            }

            foreach ($registros as $registro) {
                $guardia = $this->db->query("SELECT * FROM guardia WHERE gua_EmpleadoID=".session('id').' AND "'.$registro['dia'].'" BETWEEN gua_FechaInicio AND gua_FechaFin')->getRowArray();
                if($guardia!==NULL || !empty($guardia) ){
                    $horario= $this->db->query("SELECT * FROM horario WHERE hor_HorarioID=?",[$guardia['gua_HorarioID']])->getRowArray();
                }else{
                    //Horario
                    $queryHorario = "SELECT H.* FROM horario H JOIN empleado E on E.emp_HorarioID=H.hor_HorarioID WHERE E.emp_EmpleadoID=" . session('id');
                    $horario = $this->db->query($queryHorario)->getRowArray();
                }
                $descanso = DescansoColaborador(session('id'), $registro['dia']);
                $diaAsistencia = $this->db->query("SELECT * FROM asistencia WHERE asi_EmpleadoID=" . session('id') . " AND asi_Fecha='" . $registro['dia'] . "'")->getRowArray();
                if ((int)$descanso !== 1) {
                    if ($diaAsistencia) {
                        $horas = json_decode($diaAsistencia['asi_Hora']);
                        $diaNombre = get_nombre_dia($registro['dia']);

                        if ($diaNombre === 'Domingo') {
                            $retardos += 0;
                        } else {
                            sort($horas);
                            $horas = array_unique($horas);
                            $horas = array_values($horas);
                            $tolerancia = "+" . $horario['hor_Tolerancia'] . " minutes";
                            $horaEntrada = date('h:i', strtotime($tolerancia, strtotime($horario['hor_'.$diaNombre . 'Entrada'])));
                            $retardos += $horaEntrada >= $horas[0] ? 0 : 1;
                        }
                    } elseif($diaAsistencia==null){
                        $diaNombre = get_nombre_dia($registro['dia']);
                        if($diaNombre!== 'Domingo'){
                            $retardos += 1;
                        }
                    }else {
                        $retardos += 0;
                    }
                    //DIA INHABIL
                    $all = '["0"]';
                    $sucursal = '["'.session('sucursal').'"]';
                    $fechaexplode = explode('-', $registro['dia']);
                    if(get_nombre_dia($registro['dia'])!=='Domingo'){
                        $sql = "SELECT D.dia_Fecha AS 'fecha'
                                FROM diainhabil D
                                WHERE dia_MedioDia=0 AND (JSON_CONTAINS(dia_SucursalID,'".$all."') OR JSON_CONTAINS(dia_SucursalID,'".$sucursal."')) AND MONTH(D.dia_Fecha)=" . date('m') . " AND YEAR(D.dia_Fecha)=" . DATE('Y') . " AND DAY(D.dia_Fecha)=" . $fechaexplode[2] . "
                                UNION
                                SELECT DI.dial_Fecha as 'fecha'
                                FROM diainhabilley DI
                                WHERE MONTH(DI.dial_Fecha)=" . date('m') . " AND YEAR(DI.dial_Fecha)=" . DATE('Y') . " AND DAY(DI.dial_Fecha)=" . $fechaexplode[2];
                        $inhabiles = $this->db->query($sql)->getRowArray();
                        if ($inhabiles) {
                            if($retardos>0){
                                $retardos = $retardos - 1;
                            }
                        }
                    }

                    //Permisos
                    $diaNombre = get_nombre_dia($registro['dia']);
                    if ($diaNombre !== 'Domingo') {
                        $queryPermisos = "SELECT P.*, C.cat_Nombre FROM permiso P
                                            JOIN catalogopermiso C ON C.cat_CatalogoPermisoID=P.per_TipoID
                                            WHERE ( ?  >= P.per_FechaInicio  AND  ? <=  P.per_FechaFin) AND P.per_EmpleadoID=? AND P.per_Estado = ?";
                        $permisos = $this->db->query($queryPermisos, array($registro['dia'], $registro['dia'], session('id'), 'AUTORIZADO_RH'))->getRowArray();
                        if ($permisos) {
                            if($diaAsistencia){
                                if($diaAsistencia['asi_Hora']){
                                    $asistio = json_decode($diaAsistencia['asi_Hora']);
                                    $asistio = array_unique($asistio);
                                    $asistio = array_values($asistio);
                                    if($asistio[0]>$horaEntrada){
                                        if ($permisos['per_FechaInicio'] <= $registro['dia'] && $permisos['per_FechaFin'] >= $registro['dia']) {
                                            if($retardos>0){
                                            $retardos = $retardos - 1;
                                            }
                                        }
                                    }
                                }
                            }else{
                                if ($permisos['per_FechaInicio'] <= $registro['dia'] && $permisos['per_FechaFin'] >= $registro['dia']) {
                                    if($retardos>0){
                                    $retardos = $retardos - 1;
                                    }
                                }
                            }
                        }
                    }

                    //Vacaciones
                    $sql = "SELECT V.vac_FechaInicio AS 'FechaIni', V.vac_FechaFin AS 'FechaFin'
                            FROM vacacion V
                            WHERE V.vac_EmpleadoID=? AND V.vac_Estatus='AUTORIZADO_RH' AND ( ?  >= V.vac_FechaInicio  AND  ? <=  V.vac_FechaFin)";
                    $vacaciones = $this->db->query($sql, array(session('id'), $registro['dia'], $registro['dia']))->getRowArray();
                    if ($vacaciones) {
                        if ($vacaciones['FechaIni'] <= $registro['dia'] && $vacaciones['FechaFin'] >= $registro['dia']) {
                            if($retardos>0){
                                $retardos = $retardos - 1;
                            }
                        }
                    }


                    //Incapacidad
                    $sql = "SELECT I.inc_FechaInicio AS 'FechaIni', I.inc_FechaFin AS 'FechaFin',I.inc_Tipo AS 'tipo'
                            FROM incapacidad I
                            WHERE I.inc_EmpleadoID=? AND ( ?  >= I.inc_FechaInicio  AND  ? <=  I.inc_FechaFin) AND I.inc_Estatus='Autorizada'";
                    $incapacidades = $this->db->query($sql, array(session('id'), $registro['dia'], $registro['dia']))->getRowArray();
                    if ($incapacidades) {
                        if ($incapacidades['FechaIni'] <= $registro['dia'] && $incapacidades['FechaFin'] >= $registro['dia']) {
                            if($retardos>0){
                                $retardos = $retardos - 1;
                            }
                        }
                    }

                    //Salidas
                    $sql = "SELECT * FROM reportesalida WHERE rep_EmpleadoID=? AND ( ?  >= rep_DiaInicio  AND  ? <=  rep_DiaFin) AND rep_Estado IN('APLICADO','PAGADO')";
                    $repsalidas = $this->db->query($sql, array(session('id'), $registro['dia'], $registro['dia']))->getRowArray();
                    if ($repsalidas) {
                        $dias = json_decode($repsalidas['rep_Dias'], true);
                        foreach($dias as $dia){
                            if ($dia['fecha'] === $registro['dia']) {
                                if($retardos>0) $retardos--;
                                break;
                            }
                        }
                    }
                }
            } //end foreach
        }
        return $retardos;
    }

    public function getRetardosColaboradorPrueba()
    {
        $retardos = 0;
        //registros del mes
        $queryMes = "SELECT DISTINCT(asi_Fecha) as 'dia' FROM asistencia WHERE asi_EmpleadoID=".session('id')." AND MONTH(asi_Fecha)=2 AND YEAR(asi_Fecha)=".date('Y')." ORDER BY asi_Fecha DESC LIMIT 1";
        $ultimoDia = $this->db->query($queryMes)->getRowArray();
        if($ultimoDia){
            $ultimoDia=$ultimoDia['dia'];
            $lastDay=explode('-',$ultimoDia);
            $registros = array();
            $i=1;
            $fechaIngreso = $this->db->query("SELECT DAY(emp_FechaIngreso) as 'dia' FROM empleado WHERE emp_EmpleadoID=? AND MONTH(emp_FechaIngreso)=? AND YEAR(emp_FechaIngreso)=?",array(session('id'),date('m'),date('Y')))->getRowArray()['dia'] ?? null;
            if($fechaIngreso){
                $i=$fechaIngreso;
            }
            for($i;$i<=$lastDay[2];$i++){
                if($i<10) $i = '0'.$i;
                array_push($registros,array('dia'=>$lastDay[0].'-'.$lastDay[1].'-'.$i));
            }
            if(date('Y-m')=='2023-11'){
                $fechaLimite = "2023-11-15";
                $filtrarPorFecha = function ($registro) use ($fechaLimite) {
                    return $registro["dia"] >= $fechaLimite;
                };
                $registros = array_filter($registros, $filtrarPorFecha);
            }

            foreach ($registros as $registro) {
                $guardia = $this->db->query("SELECT * FROM guardia WHERE gua_EmpleadoID=".session('id').' AND "'.$registro['dia'].'" BETWEEN gua_FechaInicio AND gua_FechaFin')->getRowArray();
                if($guardia!==NULL || !empty($guardia) ){
                    $horario= $this->db->query("SELECT * FROM horario WHERE hor_HorarioID=?",[$guardia['gua_HorarioID']])->getRowArray();
                }else{
                    //Horario
                    $queryHorario = "SELECT H.* FROM horario H JOIN empleado E on E.emp_HorarioID=H.hor_HorarioID WHERE E.emp_EmpleadoID=" . session('id');
                    $horario = $this->db->query($queryHorario)->getRowArray();
                }
                $descanso = DescansoColaborador(session('id'), $registro['dia']);
                $diaAsistencia = $this->db->query("SELECT * FROM asistencia WHERE asi_EmpleadoID=" . session('id') . " AND asi_Fecha='" . $registro['dia'] . "'")->getRowArray();
                if ((int)$descanso !== 1) {
                    if ($diaAsistencia) {
                        $horas = json_decode($diaAsistencia['asi_Hora']);
                        $diaNombre = get_nombre_dia($registro['dia']);

                        if ($diaNombre === 'Domingo') {
                            $retardos += 0;
                        } else {
                            sort($horas);
                            $horas = array_unique($horas);
                            $horas = array_values($horas);
                            $tolerancia = "+" . $horario['hor_Tolerancia'] . " minutes";
                            $horaEntrada = date('h:i', strtotime($tolerancia, strtotime($horario['hor_'.$diaNombre . 'Entrada'])));
                            $retardos += $horaEntrada >= $horas[0] ? 0 : 1;
                            if($horaEntrada <$horas[0]){echo $registro['dia'].'| retardo '.$retardos.'|' ;}
                        }
                    } elseif($diaAsistencia==null){
                        $diaNombre = get_nombre_dia($registro['dia']);
                        if($diaNombre!== 'Domingo'){
                            $retardos += 1;
                            echo $registro['dia'].'| falta '.$retardos.'|' ;
                        }
                    }else {
                        $retardos += 0;
                    }
                    //DIA INHABIL
                    $all = '["0"]';
                    $sucursal = '["'.session('sucursal').'"]';
                    $fechaexplode = explode('-', $registro['dia']);
                    if(get_nombre_dia($registro['dia'])!=='Domingo'){
                        $sql = "SELECT D.dia_Fecha AS 'fecha'
                                FROM diainhabil D
                                WHERE dia_MedioDia=0  AND (JSON_CONTAINS(dia_SucursalID,'".$all."') OR JSON_CONTAINS(dia_SucursalID,'".$sucursal."')) AND MONTH(D.dia_Fecha)=2 AND YEAR(D.dia_Fecha)=" . DATE('Y') . " AND DAY(D.dia_Fecha)=" . $fechaexplode[2] . "
                                UNION
                                SELECT DI.dial_Fecha as 'fecha'
                                FROM diainhabilley DI
                                WHERE MONTH(DI.dial_Fecha)=2 AND YEAR(DI.dial_Fecha)=" . DATE('Y') . " AND DAY(DI.dial_Fecha)=" . $fechaexplode[2];
                        $inhabiles = $this->db->query($sql)->getRowArray();
                        if ($inhabiles) {
                            if($retardos>0){
                                $retardos = $retardos - 1;
                                echo $registro['dia'].'| di'.$retardos.'|' ;
                            }
                        }
                    }

                    //Permisos
                    $diaNombre = get_nombre_dia($registro['dia']);
                    if ($diaNombre !== 'Domingo') {
                        $queryPermisos = "SELECT P.*, C.cat_Nombre FROM permiso P
                                            JOIN catalogopermiso C ON C.cat_CatalogoPermisoID=P.per_TipoID
                                            WHERE ( ?  >= P.per_FechaInicio  AND  ? <=  P.per_FechaFin) AND P.per_EmpleadoID=? AND P.per_Estado = ?";
                        $permisos = $this->db->query($queryPermisos, array($registro['dia'], $registro['dia'], session('id'), 'AUTORIZADO_RH'))->getRowArray();
                        if ($permisos) {
                            if($diaAsistencia){
                                if($diaAsistencia['asi_Hora']){
                                    $asistio = json_decode($diaAsistencia['asi_Hora']);
                                    $asistio = array_unique($asistio);
                                    $asistio = array_values($asistio);
                                    if($asistio[0]>$horaEntrada){
                                        if ($permisos['per_FechaInicio'] <= $registro['dia'] && $permisos['per_FechaFin'] >= $registro['dia']) {
                                            if($retardos>0){
                                            $retardos = $retardos - 1;
                                            echo $registro['dia'].'| permiso '.$retardos.'|' ;

                                            }
                                        }
                                    }
                                }
                            }else{
                                if ($permisos['per_FechaInicio'] <= $registro['dia'] && $permisos['per_FechaFin'] >= $registro['dia']) {
                                    if($retardos>0){
                                    $retardos = $retardos - 1;
                                    echo $registro['dia'].'| permiso '.$retardos.'|' ;
                                    }
                                }
                            }
                        }
                    }

                    //Vacaciones
                    $sql = "SELECT V.vac_FechaInicio AS 'FechaIni', V.vac_FechaFin AS 'FechaFin'
                            FROM vacacion V
                            WHERE V.vac_EmpleadoID=? AND V.vac_Estatus='AUTORIZADO_RH' AND ( ?  >= V.vac_FechaInicio  AND  ? <=  V.vac_FechaFin)";
                    $vacaciones = $this->db->query($sql, array(session('id'), $registro['dia'], $registro['dia']))->getRowArray();
                    if ($vacaciones) {
                        if ($vacaciones['FechaIni'] <= $registro['dia'] && $vacaciones['FechaFin'] >= $registro['dia']) {
                            if($retardos>0){
                                $retardos = $retardos - 1;
                            }
                        }
                    }


                    //Incapacidad
                    $sql = "SELECT I.inc_FechaInicio AS 'FechaIni', I.inc_FechaFin AS 'FechaFin',I.inc_Tipo AS 'tipo'
                            FROM incapacidad I
                            WHERE I.inc_EmpleadoID=? AND ( ?  >= I.inc_FechaInicio  AND  ? <=  I.inc_FechaFin) AND I.inc_Estatus='Autorizada'";
                    $incapacidades = $this->db->query($sql, array(session('id'), $registro['dia'], $registro['dia']))->getRowArray();
                    if ($incapacidades) {
                        if ($incapacidades['FechaIni'] <= $registro['dia'] && $incapacidades['FechaFin'] >= $registro['dia']) {
                            if($retardos>0){
                                $retardos = $retardos - 1;
                            }
                        }
                    }

                    //Salidas
                    $sql = "SELECT * FROM reportesalida WHERE rep_EmpleadoID=? AND ( ?  >= rep_DiaInicio  AND  ? <=  rep_DiaFin) AND rep_Estado IN('APLICADO','PAGADO')";
                    $repsalidas = $this->db->query($sql, array(session('id'), $registro['dia'], $registro['dia']))->getRowArray();
                    if ($repsalidas) {
                        $dias = json_decode($repsalidas['rep_Dias'], true);
                        foreach($dias as $dia){
                            if ($dia['fecha'] === $registro['dia']) {
                                if($retardos>0) $retardos--;
                                echo $registro['dia'].'| salidas '.$retardos.'|' ;
                                break;
                            }
                        }
                    }
                }
            } //end foreach
        }
        return $retardos;
    }

    public function getRetardosColaborador_old(){
        $retardos=0;
        //Horario
        $queryHorario = "SELECT H.* FROM horario H JOIN empleado E on E.emp_HorarioID=H.hor_HorarioID WHERE E.emp_EmpleadoID=" . session('id');
        $horario = $this->db->query($queryHorario)->getRowArray();

        //Checador
        $query = "SELECT YEAR(asi_Fecha) AS 'anio', MONTH(asi_Fecha) AS 'mes', DAY(asi_Fecha) AS 'dia', asi_Fecha, asi_Hora FROM asistencia WHERE MONTH(asi_Fecha)=".date('m')." AND YEAR(asi_Fecha)=".date('Y')." AND asi_EmpleadoID=" . session('id');
        $checador = $this->db->query($query)->getResultArray();
        $asistencias = array();
        sort($checador);
        foreach ($checador as $ch) {
            $horas = json_decode($ch['asi_Hora']);
            if (!empty($horas)) {
                $horas = array_unique($horas);
                $data = array(
                    "dia" => $ch['asi_Fecha'],
                    "horaEntrada" => $horas[0],
                    "dia" => $ch['dia'],
                    "mes" => $ch['mes'],
                    "ano" => $ch['anio'],
                );
                array_push($asistencias, $data);
            } else {
                $data = array(
                    "dia" => $ch['asi_Fecha'],
                    "horaEntrada" => '00:00',
                    "dia" => $ch['dia'],
                    "mes" => $ch['mes'],
                    "ano" => $ch['anio'],
                );
                array_push($asistencias, $data);
            }
        }

        //Permisos
        $queryPermisos = "SELECT P.per_FechaInicio AS 'FechaIni', P.per_FechaFin AS 'FechaFin', per_TipoID
            FROM permiso P
            WHERE  MONTH(P.per_FechaInicio)=".date('m')." AND YEAR(P.per_FechaInicio)=" . DATE('Y') . " AND P.per_EmpleadoID=" . session('id') . " AND P.per_Estado = 'AUTORIZADO_RH'";
        $permisos = $this->db->query($queryPermisos)->getResultArray();

        $nDia = 0;
        switch (date('m')) {
            case 2:
                if (date("L")) $nDia = 29;
                else $nDia = 28;
                break;
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                $nDia = 31;
                break;
            case 4:
            case 6:
            case 9:
            case 11:
                $nDia = 30;
                break;
        }

        for ($i = 1; $i <= $nDia; $i++) {
            $fecha = date('Y');
            if (date('m') < 10) $fecha .= '-0' . date('m');
            else $fecha .= '-' . 11;
            if ($i < 10) $fecha .= '-0' . $i;
            else $fecha .= '-' . $i;

            foreach ($asistencias as $asistencia) {
                $diaNombre = get_nombre_dia($asistencia['dia']);
                $tolerancia = "+" . $horario['hor_Tolerancia'] . " minutes";
                switch ($diaNombre) {
                    case 'Lunes':
                        $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_LunesEntrada']));
                        $horaEntrada = date('h:i', $horaTolerancia);
                        break;
                    case 'Martes':
                        $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_MartesEntrada']));
                        $horaEntrada = date('h:i', $horaTolerancia);
                        break;
                    case 'Miercoles':
                        $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_MiercolesEntrada']));
                        $horaEntrada = date('h:i', $horaTolerancia);
                        break;
                    case 'Jueves':
                        $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_JuevesEntrada']));
                        $horaEntrada = date('h:i', $horaTolerancia);
                        break;
                    case 'Viernes':
                        $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_ViernesEntrada']));
                        $horaEntrada = date('h:i', $horaTolerancia);
                        break;
                    case 'Sabado':
                        $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_SabadoEntrada']));
                        $horaEntrada = date('h:i', $horaTolerancia);
                        break;
                    case 'Domingo':
                        $horaEntrada = 'Domingo';
                        break;
                }
                if ($asistencia['horaEntrada'] !== '00:00') {
                    if ($horaEntrada >= $asistencia['horaEntrada']) {
                        $retardos+=0;
                    } else {
                        $retardos+=1;
                    }
                }
            }

            //PERMISO
            foreach ($permisos as $permiso) {
                if (in_array($fecha, $permiso)) {
                    $retardos=$retardos-1;
                }
            }
        }
        $retardos=$retardos/$nDia;
        return $retardos;
    }

    public function getPoliticas(){
        $sql = "SELECT * FROM  politica";
        return  $this->db->query($sql)->getResultArray();
    }

    public function getMisSanciones(){
        $sanciones= $this->db->query("SELECT count('act_ActaAdministrativaID') as 'sanciones' FROM actaadministrativa WHERE act_EmpleadoID=".session('id')." AND MONTH(act_FechaRealizo)=".date('m'))->getRowArray();
        return $sanciones['sanciones'];
    }


    public function getUltimaSesion($idEmpleado){
        $sql = "SELECT *
                FROM acceso
                WHERE acc_UsuarioID = ? LIMIT 1 ";
        $attemps = $this->db->query($sql, array($idEmpleado))->getRowArray();
        return $attemps;
    }

    public function getUltimaGaleria(){
        return $this->db->query("SELECT gal_Nombre FROM galeria WHERE gal_Estatus=1 ORDER BY gal_Fecha DESC LIMIT 1")->getRowArray();
    }

    public function getUltimaSesionDia($idEmpleado){
        $sql = "SELECT *
                FROM acceso
                WHERE acc_UsuarioID = ? AND DATE(acc_Fecha) = CURDATE() LIMIT 1";
        $attemps = $this->db->query($sql, array($idEmpleado))->getRowArray();
        return $attemps;
    }

    public function getWelcome(){
        $empleado = $this->db->query("SELECT emp_Sexo FROM empleado WHERE emp_EmpleadoID=".session('id'))->getRowArray();
        if($empleado['emp_Sexo']=='Femenino'){
            $mensaje='Bienvenida';
        }else{
            $mensaje='Bienvenido';
        }
        return $mensaje;
    }

    public function getAnuncioActivo(){
        return $this->db->query("SELECT anu_AnuncioID FROM anuncio WHERE anu_Estatus=1 LIMIT 1")->getRowArray()['anu_AnuncioID'] ?? null;
    }
}