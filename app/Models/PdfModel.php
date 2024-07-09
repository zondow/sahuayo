<?php
namespace App\Models;

use CodeIgniter\Model;
use phpDocumentor\Reflection\Types\Float_;

class PdfModel extends Model{

    //Lia-> Perfil de puesto por ID
    function getPerfilPuestoId($idpuesto){
        $perfilID = (int)$idpuesto;
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
                  P.per_FechaCreacion as 'fechaCreacion',
                  P.per_Conocimientos as 'conocimientos'
                from perfilpuesto P
                  left join puesto PU on PU.pue_PuestoID =  P.per_PuestoID
                  left join departamento D on D.dep_DepartamentoID =  P.per_DepartamentoID
                where P.per_Estatus = 1 and  P.per_PuestoID = ?";
        return $this->db->query($sql,array($perfilID))->getRowArray();
    }//getPerfilPuestoid

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

    //Germán -> Obtiene la info de la vacacion
    public function getInfoByVacacion($idVacacion)
    {
        $query = "SELECT *, DATE(vac_FechaRegistro) as 'registro' FROM vacacion VAC
                    LEFT JOIN empleado EMP ON VAC.vac_EmpleadoID = EMP.emp_EmpleadoID
                    LEFT JOIN puesto PUE ON EMP.emp_PuestoID = PUE.pue_PuestoID
                    LEFT JOIN departamento DEP ON EMP.emp_DepartamentoID = DEP.dep_DepartamentoID
                    LEFT JOIN sucursal SUC ON SUC.suc_SucursalID = EMP.emp_SucursalID
                  WHERE VAC.vac_VacacionesID = ?";
        return $this->db->query($query, array((int)$idVacacion))->getRowArray();
    }

    //Diego -> Obtiene la info de la vacacion por horas
    public function getInfoByVacacionHoras($idVacacion)
    {
        $query = "SELECT * FROM vacacionhoras VAC
                    LEFT JOIN empleado EMP ON VAC.vach_EmpleadoID = EMP.emp_EmpleadoID
                    LEFT JOIN puesto PUE ON EMP.emp_PuestoID = PUE.pue_PuestoID
                    LEFT JOIN departamento DEP ON EMP.emp_DepartamentoID = DEP.dep_DepartamentoID
                  WHERE VAC.vach_VacacionHorasID = ?";
        return $this->db->query($query, array((int)$idVacacion))->getRowArray();
    }

    //Nat -> obtiene informacion del permiso
    function getPermisoInfo($permisoID){
        $sql = "SELECT P.*, E.emp_Nombre, E.emp_Numero,
                  D.dep_Nombre, PUE.pue_Nombre, EJ.emp_Nombre AS 'jefe',
                  ECH.emp_Nombre AS 'ch', CP.cat_Nombre as 'tipoPermiso'
                FROM permiso P
                LEFT JOIN empleado E ON E.emp_EmpleadoID=P.per_EmpleadoID
                LEFT JOIN departamento D ON D.dep_DepartamentoID=E.emp_DepartamentoID
                LEFT JOIN puesto PUE ON PUE.pue_PuestoID=E.emp_PuestoID
                LEFT JOIN empleado EJ ON EJ.emp_EmpleadoID=P.per_JefeID
                LEFT JOIN empleado ECH ON ECH.emp_EmpleadoID=P.per_ChID
                LEFT JOIN catalogopermiso CP on CP.cat_CatalogoPermisoID = P.per_TipoID
                WHERE P.per_PermisoID=?";
        return $this->db->query($sql,array((int)$permisoID))->getRowArray();
    }//getPermisoInfo

    //Diego->getDatosContratos
    public function getDatosContratos($contratoID){
        return $this->db->query('select * from contrato C LEFT JOIN empleado E ON E.emp_EmpleadoID=C.con_EmpleadoID  where C.con_ContratoID = '.$contratoID)->getRowArray();
    }//end getDatosContratos

    //Diego->getDatosEmpleado
    public function getDatosEmpleado($empleadoID){
        return $this->db->query('select E.*,P.pue_Nombre,year(E.emp_FechaNacimiento) as "edad" from empleado E JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID where E.emp_EmpleadoID = '.$empleadoID)->getRowArray();
    }//end getDatosEmpleado

    //Diego->getDatosBeneficiariosByEmpleadoID
    public function getDatosBeneficiariosByEmpleadoID($empleadoID){
        return $this->db->query('select * from beneficiarios  WHERE ben_EmpleadoID= '.$empleadoID)->getResultArray();
    }//end getDatosBeneficiariosByEmpleadoID

    //Lia -> Get datos de la entrevista de salida
    public function getEntrevistaSalida($entrevistaID){
        $sql = "SELECT
                  ES.ent_EntrevistaSalidaID as 'id',
                  ES.ent_Fecha as 'fecha',E.emp_Nombre as 'empleado',A.dep_Nombre as 'departamento',
                  P.pue_Nombre as 'ultimoPuesto',E.emp_FechaIngreso as 'fechaIngreso',
                  ES.*
                FROM entrevistasalida ES
                  LEFT JOIN empleado E on E.emp_EmpleadoID = ES.ent_EmpleadoID
                  LEFT JOIN departamento A on A.dep_DepartamentoID = E.emp_DepartamentoID
                  LEFT JOIN puesto P on P.pue_PuestoID = E.emp_PuestoID
                WHERE ES.ent_EntrevistaSalidaID = ?";
        $entrevista = $this->db->query($sql,array((int)$entrevistaID))->getRowArray();
        return $entrevista;
    }//getEntrevistaSalida


    //Lia->informe by id
    public function getInformeById($idInforme){
        $sql = "SELECT R.*,E.emp_Nombre,E.emp_Jefe FROM reportesalida R
                    JOIN empleado E ON E.emp_EmpleadoID=R.rep_EmpleadoID
                WHERE rep_ReporteSalidaID = ?";
        return $this->db->query($sql,array($idInforme))->getRowArray();
    }

    //Lia ->reporte horas by id
    public function getReporteHorasById($idReporte){
        $sql = "SELECT R.*,E.emp_Nombre,E.emp_Jefe,D.dep_Nombre,P.pue_Nombre FROM reportehoraextra R
                    JOIN empleado E ON E.emp_EmpleadoID=R.rep_EmpleadoID
                    JOIN departamento D ON D.dep_DepartamentoID=E.emp_DepartamentoID
                    JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                WHERE rep_ReporteHoraExtraID = ?";
        return $this->db->query($sql,array($idReporte))->getRowArray();
    }

    //Nat -> obtiene la informacion del empleado
    public function getEmpleadoInfo($empleadoID){
        $sql = "SELECT E.*, D.dep_Nombre,P.pue_Nombre, YEAR(E.emp_FechaNacimiento) AS 'nacimiento',YEAR(emp_FechaIngreso) as 'ano', MONTH(emp_FechaIngreso) as 'mes', DAY(emp_FechaIngreso) as 'dia',emp_FechaIngreso
                FROM empleado E
                LEFT JOIN departamento D ON D.dep_DepartamentoID=E.emp_DepartamentoID
                LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                WHERE E.emp_EmpleadoID=?";
        return $this->db->query($sql,array($empleadoID))->getRowArray();
    }


    function getEvaluacionesGuia1($fI,$fF,$sucursal){
        $where ='';
        $sucursal = encryptDecrypt('decrypt',$sucursal);
        if($sucursal>0){
            $where = "E.emp_SucursalID=".$sucursal." AND ";
        }
        $sql = "SELECT * FROM evaluaciong1 EG1
                    LEFT JOIN empleado E ON E.emp_EmpleadoID=EG1.eva_EvaluadoID
                    WHERE $where E.emp_Estatus=1 AND E.emp_Estado='Activo' AND EG1.eva_Fecha BETWEEN '".$fI."' AND '".$fF."' ";
        return $this->db->query($sql)->getResultArray();
    }

    function getEvaluacionesGuia2($fI,$fF,$sucursal=null){
        $where='';
        if($sucursal>0){
            $where= ' E.emp_SucursalID='.$sucursal.' AND';
        }
        $sql = "SELECT * FROM evaluaciong2 EG2
                    LEFT JOIN empleado E ON E.emp_EmpleadoID=EG2.eva_EvaluadoID
                    WHERE $where E.emp_Estatus=1 AND E.emp_Estado='Activo' AND EG2.eva_Fecha BETWEEN '".$fI."' AND '".$fF."'";
        return $this->db->query($sql)->getResultArray();
    }

    function getEvaluacionesGuia3($f1,$f2,$sucursal){
        $where='';
        if($sucursal>0){
            $where= ' E.emp_SucursalID='.$sucursal.' AND';
        }
        $sql = "SELECT * FROM evaluaciong3 EG3
                    LEFT JOIN empleado E ON E.emp_EmpleadoID=EG3.eva_EvaluadoID
                    WHERE $where eva_Fecha BETWEEN ? AND ?";
        return $this->db->query($sql,[$f1,$f2])->getResultArray();
    }

    public function getCF($fInicio,$fFin){
        $evaluados = $this->db->query("SELECT * FROM empleado WHERE emp_Estatus=1")->getResultArray();
        $suma = 0;
        $totalEvaluados=0;
        foreach ($evaluados as $evaluado){
            $calificacionEvaluado= $this->db->query("SELECT SUM(eva_P1+eva_P2+eva_P3+eva_P4+eva_P5+eva_P6+eva_P7+eva_P8+eva_P9+eva_P10+eva_P11+eva_P12+eva_P13+eva_P14+eva_P15+eva_P16+eva_P17+eva_P18+eva_P19+eva_P20+eva_P21+eva_P22+eva_P23+eva_P24+eva_P25+eva_P26+eva_P27+eva_P28+eva_P29+eva_P30+eva_P31+eva_P32+eva_P33+eva_P34+eva_P35+eva_P36+eva_P37+eva_P38+eva_P39+eva_P40+eva_P41+eva_P42+eva_P43+eva_P44+eva_P45+eva_P46)
            as 'calificacionT' FROM evaluaciong2 WHERE eva_EvaluadoID=".$evaluado['emp_EmpleadoID'])->getRowArray();
            if(!empty($calificacionEvaluado)){
                $totalEvaluados+=1;
                $suma+= $calificacionEvaluado['calificacionT'];
            }
        }
        if((int)$suma>0 && $totalEvaluados>0) {
            return (int)$suma / $totalEvaluados;
        }else{
            return 0;
        }
    }

    //Diego - traer los departamentos por empresa
    public function traerDepartamentos (){
        $sql="Select dep_DepartamentoID, dep_Nombre, dep_Estatus
              from departamento
              where dep_Estatus=1
              order by dep_Nombre ASC ";
        return $query=$this->db->query($sql)->getResultArray();
    }

    //Diego V -> Obtiene los comentarios de empleados
    public function comentariosEvaluacionClimaLaboral($inicio,$fin,$sucursal)
    {
        $join='';
        $where='';
        if($sucursal!='0'){
            $join=' JOIN empleado ON emp_EmpleadoID=eva_EmpleadoID ';
            $where = ' emp_SucursalID='. encryptDecrypt('decrypt',$sucursal).' AND ';
        }
        $query = "SELECT eva_Comentarios FROM evaluacionclimalaboral $join
                    WHERE $where eva_FechaEvaluacionClimaLaboral BETWEEN '".$inicio."' AND '".$fin."' AND eva_Comentarios IS NOT NULL AND eva_Comentarios!=''";
        return $this->db->query($query)->getResultArray();
    }

    //Diego V -> Obtiene los comentarios de empleados
    public function comentariosEvaluacionClimaLaboral_old($inicio,$fin,$sucursal=null)
    {
        $join='';
        $where='';
        if($sucursal!='0'){
            $join=' JOIN empleado ON emp_EmpleadoID=eva_EmpleadoID ';
            $where = ' emp_SucursalID='. encryptDecrypt('decrypt',$sucursal).' AND ';
        }
        $query = "SELECT eva_Comentarios FROM evaluacionclimalaboral $join
                    WHERE $where eva_FechaEvaluacionClimaLaboral BETWEEN '".$inicio."' AND '".$fin."' AND eva_Comentarios IS NOT NULL AND eva_Comentarios!=''";
                    var_dump($query);exit();
        return $this->db->query($query)->getResultArray();
    }

    public function getSolicitudPrestamoFondoByID($solicitudID){
        $solicitudID=encryptDecrypt('decrypt',$solicitudID);
        $query = "SELECT P.*, E.emp_Nombre, E.emp_Direccion, E.emp_Municipio, E.emp_EntidadFederativa FROM prestamofondoahorro P
                    JOIN empleado E ON E.emp_EmpleadoID=P.pre_EmpleadoID
                    WHERE  P.pre_PrestamoFondoAhorroID=?";
        return $this->db->query($query, array($solicitudID))->getRowArray();
    }

    public function getPlanPagoPrestamoFondo($montoSolicitado,$quincenas,$pago){
        $montoSolicitado = (float)$montoSolicitado;
        $quincenas = (float)$quincenas;
        $pago = (float)$pago;

        $data = array();
        if($montoSolicitado > 0 && $quincenas > 0 && $pago > 0){
            $hoy = date('d');
            if ($hoy <= 15)
                $quincena = date('Y-m')."-15";
            else
                $quincena = date('Y-m-t');
            $n=0;
            $total=0;
            for($i = 1; $i <= $quincenas; $i++){

                $montoSolicitado -= $pago;

                $montoSolicitado = $montoSolicitado < 0 ? 0 : $montoSolicitado;

                if($i == 1){
                    $intereses=0;
                    $abono=$pago;

                }else{
                    $fechaAnterior=$data[$n-1]['fechaAbono'];
                    $firstDate = $fechaAnterior;
                    $secondDate = $quincena;

                    $dateDifference = abs(strtotime($firstDate) - strtotime($secondDate));
                    $years  = floor($dateDifference / (365 * 60 * 60 * 24));
                    $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

                    $intereses=(($montoSolicitado*0.06)/365)* $days;

                    $abono=$pago+$intereses;
                }


                $row['plazo'] = $i;
                $row['fechaAbono'] = $quincena;
                $row['importeAbono'] = "$ ".number_format($pago,2);
                $row['interesesPagar'] = "$ ".number_format($intereses,2);
                $row['saldoActual'] = "$ ".number_format($montoSolicitado,2);
                $row['totalAbono'] = "$ ".number_format($abono,2);
                array_push($data,$row);
                $n++;
                //Calcular quincena
                $dayx = date('d', strtotime($quincena)); // sacamos el dia de $last_day
                $hoy3 = date('Y-m', strtotime($quincena));// sacamos el año y mes de $last_day

                if ($dayx <= 15) {

                    $aux = date('Y-m-d', strtotime("{$hoy3} + 1 month"));
                    $quincena = date('Y-m-d', strtotime("{$aux} -1 day"));

                } else {

                    $aux = date('Y-m-d', strtotime("{$hoy3} + 1 month"));
                    $quincena = date('Y-m-d', strtotime("{$aux} +14 day"));
                }
                $total+=$pago;
            }
        }
        return $data;
    }


    public function getTotalesPrestamoFondo($montoSolicitado,$quincenas,$pago){
        $montoSolicitado = (float)$montoSolicitado;
        $quincenas = (float)$quincenas;
        $pago =round($pago,4);

        $amortizacion = $montoSolicitado/$quincenas;
        $amortizacion=round($amortizacion,4);
        $total = ($amortizacion*$quincenas);
        $totalamort = round($total, 0, PHP_ROUND_HALF_UP);

        $data = array();
        $dataTotales = array();

        if($montoSolicitado > 0 && $quincenas > 0 && $pago > 0){
            $hoy = date('d');
            if ($hoy <= 15)
                $quincena = date('Y-m')."-15";
            else
                $quincena = date('Y-m-t');
            $n=0;

            $totalPrestamo=$totalamort;
            $totalInteres=0;
            $totalAbono=0;

            for($i = 1; $i <= $quincenas; $i++){
                $montoSolicitado -= $pago;

                $montoSolicitado = $montoSolicitado < 0 ? 0 : $montoSolicitado;

                if($i == 1){
                    $intereses=0;
                    $abono=$pago;

                }else{
                    $fechaAnterior=$data[$n-1]['fechaAbono'];
                    $firstDate = $fechaAnterior;
                    $secondDate = $quincena;

                    $dateDifference = abs(strtotime($firstDate) - strtotime($secondDate));
                    $years  = floor($dateDifference / (365 * 60 * 60 * 24));
                    $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

                    $intereses=(($montoSolicitado*0.06)/365)* $days;

                    $abono=$pago+$intereses;
                }


                $row['plazo'] = $i;
                $row['fechaAbono'] = $quincena;
                $row['importeAbono'] = "$ ".number_format($pago,2);
                $row['interesesPagar'] = number_format($intereses,4);
                $row['saldoActual'] = "$ ".number_format($montoSolicitado,2);
                $row['totalAbono'] = "$ ".number_format($abono,2);
                array_push($data,$row);
                $n++;
                //Calcular quincena
                $dayx = date('d', strtotime($quincena)); // sacamos el dia de $last_day
                $hoy3 = date('Y-m', strtotime($quincena));// sacamos el año y mes de $last_day

                if ($dayx <= 15) {

                    $aux = date('Y-m-d', strtotime("{$hoy3} + 1 month"));
                    $quincena = date('Y-m-d', strtotime("{$aux} -1 day"));

                } else {

                    $aux = date('Y-m-d', strtotime("{$hoy3} + 1 month"));
                    $quincena = date('Y-m-d', strtotime("{$aux} +14 day"));
                }

            }
        }


        for($x=0;$x<count($data);$x++){
            $totalInteres+= $data[$x]['interesesPagar'];
        }

        $totalAbono=$totalPrestamo + $totalInteres;

        $dataTotales['totalPrestamo']="$ ".number_format($totalPrestamo,2);
        $dataTotales['totalInteres']="$ ".number_format($totalInteres,2);
        $dataTotales['totalAbono']="$ ".number_format($totalAbono,2);
        $dataTotales['quincena']=$row['fechaAbono'];
        $dataTotales['abonos']=$quincenas;

        return $dataTotales;
    }

    //Nat -> Obtiene la ultima evaluacion por competencias de un empleado
    public function getLastEvaluacionCompetenciasByEmpleado($empleadoID) {
        $sql = "SELECT *
                FROM evaluacioncompetencia EC
                WHERE EC.evac_EmpleadoID=?
                ORDER BY EC.evac_Fecha DESC";
        $lastEC = $this->db->query($sql,array((int)$empleadoID))->getRowArray();

        if(is_null($lastEC)){
            return null;
        }

        $calificaciones = json_decode($lastEC['evac_Calificacion'],1);
        $porcentajes = json_decode($lastEC['evac_Porcentaje'],1);

        $calificacionesJefe = json_decode($lastEC['evac_CalificacionJefe'],1);
        $porcentajesJefe = json_decode($lastEC['evac_PorcentajeJefe'],1);

        foreach ($porcentajes as $key => $val) {
            $comID = $calificaciones[$key]['IdComp'];
            $sql = 'SELECT com_Nombre from competencia where com_CompetenciaID=?';
            $comNombre = $this->db->query($sql,$comID)->getRowArray()['com_Nombre'];

            $calificaciones[$key]['porcentaje'] = $val['Porcentaje'];
            $calificaciones[$key]['comNombre'] = $comNombre;
            $calificaciones[$key]['calJefe'] = $calificacionesJefe[$key]['Valor'] ?? null;
            $calificaciones[$key]['porJefe'] = $porcentajesJefe[$key]['Porcentaje'] ?? null;
        }

        $lastEC['calificaciones'] = $calificaciones;
        return $lastEC;
    }


    //Lia -> Get datos de la baja del empleado
    public function getBajaEmpleado($empleadoID){
        $sql = "SELECT
                E.emp_Nombre AS 'empleado',
                E.emp_Numero AS 'numero',
                P.pue_Nombre AS 'puesto',
                D.dep_Nombre AS 'departamento',
                G.emp_Nombre AS 'jefe',
                C.emp_Nombre AS 'capitalHumano',
                B.*
                FROM bajaempleado B
                LEFT JOIN empleado E ON E.emp_EmpleadoID = B.baj_EmpleadoID
                LEFT JOIN puesto P ON P.pue_PuestoID = E.emp_PuestoID
                LEFT JOIN departamento D ON D.dep_DepartamentoID=E.emp_DepartamentoID
                LEFT JOIN empleado G ON G.emp_Numero = E.emp_Jefe
                LEFT JOIN empleado C ON C.emp_EmpleadoID = B.baj_EmpleadoDaBaja
                WHERE B.baj_BajaEmpleadoID = ? ";

        return  $this->db->query($sql,array($empleadoID))->getRowArray();
    }//getBajaEmpleado


    public function getSolicitudAnticipoSueldoByID($anticipoID){
        $anticipoID=encryptDecrypt('decrypt',$anticipoID);
        $query = "SELECT A.*, E.emp_Numero,E.emp_Nombre, E.emp_EstadoCivil, E.emp_Direccion, E.emp_Celular, E.emp_CodigoPostal,
                        P.pue_Nombre,E.emp_FechaIngreso, E.emp_Telefono, E.emp_Municipio, E.emp_EntidadFederativa, E.emp_Colonia,E.emp_NumSocio FROM anticiposueldo A
                    JOIN empleado E ON E.emp_EmpleadoID=A.ant_EmpleadoID
                    JOIN puesto P ON P.pue_PuestoID = E.emp_PuestoID
                    WHERE A.ant_AnticipoSueldoID=?";
        return $this->db->query($query, array($anticipoID))->getRowArray();
    }

    public function getPlanPagoAnticipoSueldo($anticipoID){
        $anticipoID=encryptDecrypt('decrypt',$anticipoID);
        $query = "SELECT pla_Quincena, pla_Fecha,pla_Saldo, pla_ImporteAbono FROM planpagoadelantosueldo
            WHERE pla_AnticipoSueldoID=?";
        $pagos=$this->db->query($query,array($anticipoID))->getResultArray();

        $arrPagos=array();
        foreach($pagos as $pago){
            $pago['pla_ImporteAbono']='$'.number_format($pago['pla_ImporteAbono'],2, '.',',');
            $pago['pla_Saldo']='$'.number_format($pago['pla_Saldo'],2, '.',',');

            array_push($arrPagos, $pago);
        }

        return $arrPagos;
    }

    public function getDominiosGuia3($fechaI,$fechaF,$sucursal)
    {
        $where = '';
        if($sucursal>0) $where=" emp_SucursalID=".$sucursal." AND ";
        $evaluados = $this->db->query("SELECT * FROM empleado WHERE $where emp_Estatus=1 ")->getResultArray();
        $ambienteTBR = 0;$ambienteTRM = 0;$ambienteTAR = 0;
        $cargaTBR = 0;$cargaTRM = 0;$cargaTAR = 0;
        $faltaCBR = 0;$faltaCRM = 0;$faltaCAR = 0;
        $jornadaTBR = 0;$jornadaTRM = 0;$jornadaTAR = 0;
        $interferenciaBR = 0;$interferenciaRM = 0;$interferenciaAR = 0;
        $liderazgoBR = 0;$liderazgoRM = 0;$liderazgoAR = 0;
        $relacionTBR = 0;$relacionTRM = 0;$relacionTAR = 0;
        $violenciaBR = 0;$violenciaRM = 0;$violenciaAR = 0;
        $reconocimientoBR=0;$reconocimientoRM=0;$reconocimientoAR=0;
        $insuficienteBR=0;$insuficienteRM=0;$insuficienteAR=0;
        foreach ($evaluados as $evaluado) {
            $calificacionEvaluado = $this->db->query("SELECT
                    SUM(eva_P1+eva_P3+eva_P2+eva_P4+eva_P5) as 'ambienteTrabajo',
                    SUM(eva_P6+eva_P12+eva_P7+eva_P8+eva_P8+eva_P19+eva_P11+eva_P65+eva_P66+eva_P67+eva_P68+eva_P13+eva_P14+eva_P15+eva_P16) as 'cargaTrabajo',
                    SUM(eva_P25+eva_P26+eva_P27+eva_P28+eva_P29+eva_P30+eva_P23+eva_P24+eva_P35+eva_P36) as 'faltaControl',
                    SUM(eva_P17+eva_P18) as 'jornadaTrabajo',
                    SUM(eva_P19+eva_P20+eva_P21+eva_P22) as 'interferencia',
                    SUM(eva_P31+eva_P32+eva_P33+eva_P34+eva_P37+eva_P38+eva_P39+eva_P40+eva_P41) as 'liderazgo',
                    SUM(eva_P42+eva_P43+eva_P44+eva_P45+eva_P46+eva_P69+eva_P70+eva_P71+eva_P72) as 'relacionTrabajo',
                    SUM(eva_P57+eva_P58+eva_P59+eva_P60+eva_P61+eva_P62+eva_P63+eva_P64) as 'violencia',
                    SUM(eva_P47+eva_P48+eva_P49+eva_P50+eva_P51+eva_P52) as 'reconocimiento',
                    SUM(eva_P53+eva_P54) as 'insuficiente'
                FROM evaluaciong3 WHERE eva_Fecha BETWEEN '".$fechaI."' AND '".$fechaF."' AND eva_EvaluadoID=" . $evaluado['emp_EmpleadoID'])->getRowArray();
            if (
                $calificacionEvaluado['ambienteTrabajo'] !== null && $calificacionEvaluado['cargaTrabajo'] !== null &&
                $calificacionEvaluado['faltaControl'] !== null && $calificacionEvaluado['jornadaTrabajo'] !== null &&
                $calificacionEvaluado['interferencia'] !== null && $calificacionEvaluado['liderazgo'] !== null &&
                $calificacionEvaluado['relacionTrabajo'] !== null && $calificacionEvaluado['violencia'] !== null &&
                $calificacionEvaluado['reconocimiento'] !== null && $calificacionEvaluado['insuficiente'] !== null
            ) {
                //ambiente de trabajo
                if ($calificacionEvaluado['ambienteTrabajo'] < 9) {
                    $ambienteTBR += 1;
                } elseif ($calificacionEvaluado['ambienteTrabajo'] >= 9 && $calificacionEvaluado['ambienteTrabajo'] < 11) {
                    $ambienteTRM += 1;
                } elseif ($calificacionEvaluado['ambienteTrabajo'] >= 11) {
                    $ambienteTAR += 1;
                }
                //carga de trabajo
                if ($calificacionEvaluado['cargaTrabajo'] < 21) {
                    $cargaTBR += 1;
                } elseif ($calificacionEvaluado['cargaTrabajo'] >= 21 && $calificacionEvaluado['cargaTrabajo'] < 27) {
                    $cargaTRM += 1;
                } elseif ($calificacionEvaluado['cargaTrabajo'] >= 27) {
                    $cargaTAR += 1;
                }
                //falta de control
                if ($calificacionEvaluado['faltaControl'] < 16) {
                    $faltaCBR += 1;
                } elseif ($calificacionEvaluado['faltaControl'] >= 16 && $calificacionEvaluado['faltaControl'] < 21) {
                    $faltaCRM += 1;
                } elseif ($calificacionEvaluado['faltaControl'] >= 21) {
                    $faltaCAR += 1;
                }
                //jornada de trabajo
                if ($calificacionEvaluado['jornadaTrabajo'] < 2) {
                    $jornadaTBR += 1;
                } elseif ($calificacionEvaluado['jornadaTrabajo'] >= 2 && $calificacionEvaluado['jornadaTrabajo'] < 4) {
                    $jornadaTRM += 1;
                } elseif ($calificacionEvaluado['jornadaTrabajo'] >= 4) {
                    $jornadaTAR += 1;
                }
                //interferencia
                if ($calificacionEvaluado['interferencia'] < 6) {
                    $interferenciaBR += 1;
                } elseif ($calificacionEvaluado['interferencia'] >= 6 && $calificacionEvaluado['interferencia'] < 8) {
                    $interferenciaRM += 1;
                } elseif ($calificacionEvaluado['interferencia'] >= 8) {
                    $interferenciaAR += 1;
                }
                //liderazgo
                if ($calificacionEvaluado['liderazgo'] < 12) {
                    $liderazgoBR += 1;
                } elseif ($calificacionEvaluado['liderazgo'] >= 12 && $calificacionEvaluado['liderazgo'] < 16) {
                    $liderazgoRM += 1;
                } elseif ($calificacionEvaluado['liderazgo'] >= 16) {
                    $liderazgoAR += 1;
                }
                //relacion de trabajo
                if ($calificacionEvaluado['relacionTrabajo'] < 13) {
                    $relacionTBR += 1;
                } elseif ($calificacionEvaluado['relacionTrabajo'] >= 13 && $calificacionEvaluado['relacionTrabajo'] < 17) {
                    $relacionTRM += 1;
                } elseif ($calificacionEvaluado['relacionTrabajo'] >= 17) {
                    $relacionTAR += 1;
                }
                //violencia
                if ($calificacionEvaluado['violencia'] < 10) {
                    $violenciaBR += 1;
                } elseif ($calificacionEvaluado['violencia'] >= 10 && $calificacionEvaluado['violencia'] < 13) {
                    $violenciaRM += 1;
                } elseif ($calificacionEvaluado['violencia'] >= 13) {
                    $violenciaAR += 1;
                }
                //reconocimento del desempeño
                if($calificacionEvaluado['reconocimiento'] <10){
                    $reconocimientoBR+=1;
                }elseif($calificacionEvaluado['reconocimiento'] >=10 && $calificacionEvaluado['reconocimiento'] <14){
                    $reconocimientoRM+=1;
                }elseif ($calificacionEvaluado['reconocimiento'] >=14) {
                    $reconocimientoAR+=1;
                }
                //insuficiente
                if($calificacionEvaluado['insuficiente'] <6){
                    $insuficienteBR+=1;
                }elseif($calificacionEvaluado['insuficiente'] >=6 && $calificacionEvaluado['insuficiente'] <8){
                    $insuficienteRM+=1;
                }elseif ($calificacionEvaluado['insuficiente'] >=8) {
                    $insuficienteAR+=1;
                }
            }
        }

        $data['bajo'] = array($ambienteTBR, $cargaTBR, $faltaCBR, $jornadaTBR, $interferenciaBR, $liderazgoBR, $relacionTBR, $violenciaBR,$reconocimientoBR,$insuficienteBR);
        $data['medio'] = array($ambienteTRM, $cargaTRM, $faltaCRM, $jornadaTRM, $interferenciaRM, $liderazgoRM, $relacionTRM, $violenciaRM,$reconocimientoRM,$insuficienteRM);
        $data['alto'] = array($ambienteTAR, $cargaTAR, $faltaCAR, $jornadaTAR, $interferenciaAR, $liderazgoAR, $relacionTAR, $violenciaAR,$reconocimientoAR,$insuficienteAR);
        return $data;
    }
}