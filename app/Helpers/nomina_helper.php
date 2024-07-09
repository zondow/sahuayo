<?php
class CalculoNomina{
    function db(){
        return $db = \Config\Database::connect();
    }

    //Constructor no parametrizado.
/*    public function __construct(){
        //Fijar zona horaria
        date_default_timezone_set('America/Mexico_City');
        //Obtener instancia para poder usar la BD
        $this->CI =& get_instance();
        $this->CI->load->database();
    }//__construct*/

    //Dias de Vacaciones segun la ley
    public function diasley($emp_fechaIngreso){

        $fi = new DateTime($emp_fechaIngreso);
        $fn = new DateTime("now");
        $diff = $fi->diff($fn);

        $anios = $diff->y;

        if($anios === 1) $dias = 6;
        else if($anios === 2) $dias = 8;
        else if($anios === 3) $dias = 10;
        else if($anios === 4) $dias = 12;
        else if($anios >= 5 && $anios <= 9) $dias = 14;
        else if($anios >= 10 && $anios <= 14 ) $dias = 16;
        else if($anios >= 15 && $anios <= 19 ) $dias = 18;
        else if($anios >= 20 && $anios <= 24 ) $dias = 20;
        else if($anios >= 25 && $anios <= 29 ) $dias = 22;
        else if($anios >= 30 && $anios <= 34 ) $dias = 24;
        else $dias = 0;

        return $dias;
    }

    //Calculo de la nomina por Empleado
    public function calculoEmpleado($idEmpleado, $diasTrabajo,$tipo, $horasExtra = null, $comisiones = null){
        //Variables Nomina
        $variables = $this->CI->db->get("variablesnomina")->getRowArray();

        //Datos Empleado
        $dataEmpleado = $this->CI->db->get_where("empleado", array("emp_EmpleadoID" => $idEmpleado))->getRowArray();
        $fechaIngreso = $dataEmpleado['emp_FechaIngreso'];
        $cuotaDiaria = $dataEmpleado['emp_SalarioDiario'];

        //Calculo del SDI
        $factorIntegracion = (365 + $variables['var_Aguinaldo'] + ($this->diasley($fechaIngreso) * ($variables['var_PrimaVacacional'] / 100))) / 365;
        $sdi = $cuotaDiaria * $factorIntegracion;

        //Calculo del Importe de Dias Trabajados
        $idt = $cuotaDiaria * $diasTrabajo;

        //Calculo de los Premios de Puntualidad y Asistencia
        $premioPuntualidad = ($idt * ($variables['var_PremioPuntualidad'] / 100));
        $premioAsistencia = ($idt * ($variables['var_PremioAsistencia'] / 100));

        //Calculo de la Canasta Basica
        $exentoCB = ($variables['var_SalarioMinimo'] * ($variables['var_CanastaBasica'] / 100)) * $diasTrabajo;
        $totalCB = ($cuotaDiaria * ($variables['var_CanastaBasica'] / 100)) * $diasTrabajo;
        $icb = ($totalCB > $exentoCB) ? ($totalCB - $exentoCB) : $exentoCB;

        //Calculo del Importe de las Horas Extras
        $exentoHE = $variables['var_SalarioMinimo'] * 5;
        $costoHoraDoble = ($cuotaDiaria / 8) * 2;
        $costoHoraTriple = ($cuotaDiaria / 8) * 3;

        $semanas = floor($diasTrabajo / 7);
        $factorHoraExtra = 9 * $semanas;

        $totalHD = floor(($horasExtra > $factorHoraExtra) ? $factorHoraExtra : $horasExtra);
        $totalHT = floor($horasExtra - $factorHoraExtra);

        $pagoHD = $totalHD * $costoHoraDoble;
        $pagoHT = $totalHT * $costoHoraTriple;

        $ihd = (($pagoHD * 0.50) > $exentoHE) ? ($pagoHD - $exentoHE) : ($pagoHD * 0.50);
        $iht = $pagoHT;

        //Calculo del Aguinaldo
        $exentoAguinaldo = $variables['var_SalarioMinimo'] * 30;
        $aguinaldo = $cuotaDiaria * $variables['var_Aguinaldo'];
        $ida = ($aguinaldo > $exentoAguinaldo) ? ($aguinaldo - $exentoAguinaldo) : 0;

        //Calculo de Vacaciones
        $vacaciones = $cuotaDiaria * $this->diasley($fechaIngreso);

        //Calculo de Prima Vacacional
        $exentoPV = $variables['var_SalarioMinimo'] * 15;
        $primaVacacional = ($vacaciones * 0.30);
        $ipv = ($primaVacacional > $exentoPV) ? ($primaVacacional - $exentoPV) : 0;

        //SUMA TOTAL DE NOMINA
        $nomina = $idt + $premioAsistencia + $premioPuntualidad + $totalCB /*+ $pagoHD + $pagoHT*/;

        //SUMA TOTAL DE BASE PARA IMPUESTO
        $baseImpuesto = $idt + $premioAsistencia + $premioPuntualidad + $icb /*+ $ihd + $iht + $ida + $vacaciones + $ipv + $comisiones*/;

        //Calculo del ISR
        $retencion = $this->CI->db->query("SELECT * FROM retencion RET WHERE RET.ret_Tipo = '$tipo' AND RET.ret_Anio = ".date("Y")." AND $baseImpuesto BETWEEN RET.ret_LimiteInferior AND RET.ret_LimiteSuperior")->getRowArray();
        $ret = ($baseImpuesto - $retencion['ret_LimiteInferior']) * ($retencion['ret_Porcentaje'] / 100) + $retencion['ret_CuotaFija'];

        $subsidio = $this->CI->db->query("SELECT * FROM subsidio SUB WHERE SUB.sub_Tipo = '$tipo' AND SUB.sub_Anio = ".date("Y")." AND $baseImpuesto BETWEEN SUB.sub_LimiteInferior AND SUB.sub_LimiteSuperior")->getRowArray();
        $ise = $subsidio['sub_Monto'];
        $isr = ($ret > $ise) ? ($ret - $ise) : ($ise - $ret);

        //Calculo de Cuota Patronal en el Seguro de Riesgo
        $cps = $sdi * $diasTrabajo * ($variables['var_PrimaRiesgo'] / 100);

        //Calculo de Seguro de Enfermedades y Maternidad
        $cseFijo = $variables['var_SalarioMinimo'] * $diasTrabajo * ($variables['var_EnfermedadEspecieFijo'] / 100);
        $cuotaAdicionalPatron = (($sdi - ($variables['var_SalarioMinimo'] * 3)) * $diasTrabajo) * ($variables['var_EnfermedadEspecieAdicionalP'] / 100);
        $cuotaAdicionalTrabajador = (($sdi - ($variables['var_SalarioMinimo'] * 3)) * $diasTrabajo) * ($variables['var_EnfermedadEspecieAdicionalT'] / 100);
        $cseAdicionalPatron = ($cuotaAdicionalPatron > 0) ? $cuotaAdicionalPatron : 0;
        $cseAdicionalTrabajador = ($cuotaAdicionalTrabajador > 0) ? $cuotaAdicionalTrabajador : 0;

        $cuotaDineroPatron = ($sdi * $diasTrabajo) * ($variables['var_EnfermedadDineroP'] / 100);
        $cuotaDineroTrabajador = ($sdi * $diasTrabajo) * ($variables['var_EnfermedadDineroT'] / 100);
        $cseDineroPatron = ($cuotaDineroPatron > 0) ? $cuotaDineroPatron : 0;
        $cseDineroTrabajador= ($cuotaDineroTrabajador > 0) ? $cuotaDineroTrabajador : 0;

        //Calculo de Gastos Medicos Pensionados
        $gmpP = $sdi * $diasTrabajo * ($variables['var_GastosMedicosP'] / 100);
        $gmpT = $sdi * $diasTrabajo * ($variables['var_GastosMedicosT'] / 100);

        //Calculo de Invalidez y Vida
        $invP = $sdi * $diasTrabajo * ($variables['var_InvalidezVidaP'] / 100);
        $invT = $sdi * $diasTrabajo * ($variables['var_InvalidezVidaT'] / 100);

        //Calculo de Guarderias y Prestaciones Sociales
        $gpsP = $sdi * $diasTrabajo * ($variables['var_GuarderiasPrestacionesP'] / 100);

        //Calculo de Seguro de Retiro
        $sreP = $sdi * $diasTrabajo * ($variables['var_SeguroRetiroP'] / 100);

        //Calculo de Cesantia en Edad Avanzada y Vejez
        $eavP = $sdi * $diasTrabajo * ($variables['var_CesantiaVejezP'] / 100);
        $eavT = $sdi * $diasTrabajo * ($variables['var_CesantiaVejezT'] / 100);

        //TOTALES
        $cuotasPatron = $cps + $cseFijo + $cseAdicionalPatron + $cseDineroPatron + $gmpP + $invP + $gpsP + $sreP + $eavP;
        $cuotasTrabajador = $cseAdicionalTrabajador + $cseDineroTrabajador + $gmpT + $invT + $eavT;

        //RETURN
        $response = array(
            "fechaIngreso" => $fechaIngreso,
            "cuotaDiaria" => $cuotaDiaria,
            "sueldoDiarioIntegrado" => $sdi,
            "importeDiasTrabajados" => $idt,
            "premioPuntualidad" => $premioPuntualidad,
            "premioAsistencia" => $premioAsistencia,
            "canastaBasica" => $icb,
            "horasExtrasDoble" => $ihd,
            "horasExtrasTriple" => $iht,
            "aguinaldo" => $ida,
            "vacaciones" => $vacaciones,
            "primaVacacional" => $ipv,
            "sumaNomina" => $nomina,
            "baseImpuesto" => $baseImpuesto,
            "isr" => $isr,
            "subsidioEmpleo" => $ise,
            "cuotaPatronalSeguroRiesgo" => $cps,
            "cuotaFija" => $cseFijo,
            "cuotaAdicionalPatron" => $cseAdicionalPatron,
            "cuotaAdicionalTrabajador" => $cseAdicionalTrabajador,
            "prestacionDineroPatron" => $cseDineroPatron,
            "prestacionDineroTrabajador" => $cseDineroTrabajador,
            "gastosMedicosPatron" => $gmpP,
            "gastosMedicosTrabajador" => $gmpT,
            "invalidezVidaPatron" => $invP,
            "invalidezVidaTrabajador" => $invT,
            "guarderiasPrestaciones" => $gpsP,
            "seguroRetiro" => $sreP,
            "edadAvanzadaPatron" => $eavP,
            "edadAvanzadaTrabajador" => $eavT,
            "cuotasPatron" => $cuotasPatron,
            "cuotasTrabajador" => $cuotasTrabajador,
            "sumaDeducciones" => $cuotasTrabajador + $isr
        );
        return $response;
    }

    //Calculo de dias asistidos
    public function asistenciaByEmpleado($idEmpleado, $fechaInicio, $fechaFin){
        $query = "SELECT * FROM asistencia ASI WHERE ASI.asi_EmpleadoID = $idEmpleado AND ASI.asi_Asistencia = 'ASISTENCIA' AND (ASI.asi_Fecha BETWEEN  '$fechaInicio' AND '$fechaFin')";
        $result = $this->CI->db->query($query);

        return ($result) ? count($result->result_array()) : null;
    }

    //Calculo de horas extra
    public function horasExtraByEmpleado($idEmpleado, $fechaInicio, $fechaFin){
        $query = "SELECT * FROM horasextras EXT WHERE EXT.hore_NombreEmpleado = $idEmpleado 
                                AND EXT.hore_Estatus = 'APLICADA' AND (EXT.hore_Fecha BETWEEN '$fechaInicio' AND '$fechaFin')";
        $result = $this->CI->db->query($query)->result_array();

        $horasExtra = 0;
        foreach ($result as $time){
            $horaInicio = new DateTime($result['hore_HoraInicio']);
            $horaFin = new DateTime($result['hore_HoraFin']);

            $interval = $horaInicio->diff($horaFin);
            $horasExtra += $interval->format('%H');

        }

        return $horasExtra;
    }

    //Calculo de comisiones
    public function comisionesByEmpleado($idEmpleado, $fechaInicio, $fechaFin){
        $query = "SELECT (SUM(BON.bon_Rendimiento) + SUM(BON.bon_Quejas) + SUM(BON.bon_Limpieza) + SUM(BON.bon_Asistencia) + SUM(BON.bon_Uniforme)) AS 'bonos' 
                  FROM bono BON WHERE BON.bon_EmpleadoID = $idEmpleado AND (BON.bon_Fecha BETWEEN  '$fechaInicio' AND '$fechaFin')";
        $result = $this->CI->db->query($query)->getRowArray();
        $comisiones = $result['bonos'] * 250;

        return $comisiones;
    }

    //Calculo de vacaciones
    public function vacacionesByEmpleado($idEmpleado, $fechaInicio, $fechaFin){
        $query = "SELECT * FROM vacaciones VAC WHERE VAC.vac_EmpleadoID = $idEmpleado 
                                AND VAC.vac_Estatus = 'REVISADA' AND (VAC.vac_FechaInicio BETWEEN '$fechaInicio' AND '$fechaFin')";
        $result = $this->CI->db->query($query)->result_array();

        $vacaciones = 0;
        foreach ($result as $vacaciones){
            $fechaInicio = new DateTime($result['vac_FechaInicio']);
            $fechaFin = new DateTime($result['vac_FechaFin']);

            $interval = $fechaInicio->diff($fechaFin);
            $vacaciones += $interval->days;
        }

        return $vacaciones;
    }

    //Calculo de permisos
    public function permisosByEmpleado($idEmpleado, $fechaInicio, $fechaFin){
        $query = "SELECT * FROM permiso PER WHERE PER.per_EmpleadoID = $idEmpleado 
                                AND PER.per_Estatus = 'AUTORIZADO_RH' AND (PER.per_FechaInicio BETWEEN '$fechaInicio' AND '$fechaFin')";
        $result = $this->CI->db->query($query);

        return ($result) ? count($result->result_array()) : null;

    }

    //Calculo de incapacidades
    public function incapacidadesByEmpleado($idEmpleado, $fechaInicio, $fechaFin){
        $query = "SELECT * FROM incapacidad INC WHERE INC.inc_EmpleadoID = $idEmpleado AND (INC.inc_FechaInicio BETWEEN '$fechaInicio' AND '$fechaFin')";
        $result = $this->CI->db->query($query);

        return ($result) ? count($result->result_array()) : null;

    }

    //Calculo de dias inhabiles
    public function diasInhabilesByPeriodo($fechaInicio, $fechaFin){
        $query = "SELECT * FROM diasinhabiles INH WHERE INH.inh_Fecha BETWEEN '$fechaInicio' AND '$fechaFin'";
        $result = $this->CI->db->query($query);

        return ($result) ? count($result->result_array()) : null;

    }

    //Generar xml para el recibo de nominca
    public function generarXMLnomina($idNomina){

        //Obtiene los datos del registro de la nomina
        $dataNomina = $this->CI->db->get_where("nomina", array("nom_NominaID" => $idNomina))->getRowArray();
        $idEmpleado = $dataNomina['nom_EmpleadoID'];

        //Obtiene los datos del empleados
        $queryE = "SELECT EMP.*, DEP.dep_Nombre, PUE.pue_Nombre, EPR.emp_RazonSocial,EPR.emp_RFC FROM empleado EMP 
                      LEFT JOIN departamento DEP ON EMP.emp_DepartamentoID = DEP.dep_DepartamentoID
                      LEFT JOIN puesto PUE ON EMP.emp_PuestoID = PUE.pue_PuestoID
                      LEFT JOIN empresa EPR on EPR.emp_EmpresaID = EMP.emp_EmpresaID
                   WHERE EMP.emp_EmpleadoID = ".$idEmpleado;
        $dataEmpleado = $this->CI->db->query($queryE)->getRowArray();

        $txt = '<?xml version="1.0" encoding="UTF-8"?>
        <cfdi:Comprobante xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/nomina12 http://www.sat.gob.mx/sitio_internet/cfd/nomina/nomina12.xsd" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:nomina12="http://www.sat.gob.mx/nomina12"   
            Version="3.3" Fecha="' . date("Y-m-d") . 'T' . date("H:i:s") . '" Serie="' . date("Y") . '" Folio="' . $idNomina . '" 
		    Sello="" 
		    FormaPago="99" Moneda="MXN" TipoDeComprobante="N" MetodoPago="PUE" LugarExpedicion="36620" SubTotal="' . $dataNomina['nom_Subtotal'] . '"  Descuento="' . $dataNomina['nom_TotalDeducciones'] . '"  Total="' . $dataNomina['nom_Total'] . '">
			<cfdi:Emisor Rfc="' . $dataEmpleado['emp_RFC'] . '" Nombre="' . $dataEmpleado['emp_RazonSocial'] . '" RegimenFiscal="601" />
			<cfdi:Receptor Rfc="' . $dataEmpleado['emp_Rfc'] . '" Nombre="' . $dataEmpleado['emp_Nombre'] . '"  UsoCFDI="P01" />
			<cfdi:Conceptos>
			    <cfdi:Concepto ClaveProdServ="84111505" Cantidad="1" ClaveUnidad="ACT" Descripcion="PAGO DE NÓMINA" ValorUnitario="' . number_format($dataNomina['nom_Subtotal'], 2, '.', '') . '" Importe="' . number_format($dataNomina['nom_Subtotal'], 2, '.', '') . '" Descuento="' . number_format($dataNomina['nom_TotalDeducciones'], 2, '.', '') . '"/>
			</cfdi:Conceptos>
			<cfdi:Complemento>
                <nomina12:Nomina Version="1.2" TipoNomina="O" FechaPago="' . date("Y-m-d") . '" FechaInicialPago="' . $dataNomina['nom_FechaInicial'] . '" FechaFinalPago="' . $dataNomina['nom_FechaFinal'] . '" NumDiasPagados="' . number_format($dataNomina['nom_DiasPagados'], 3, '.', ',') . '" 
                    TotalPercepciones="' . $dataNomina['nom_Subtotal'] .'" TotalDeducciones="' . $dataNomina['nom_TotalDeducciones'] .'">
                    <nomina12:Emisor RegistroPatronal="B4750526104" />
                    <nomina12:Receptor Curp="' . $dataEmpleado['emp_Curp'] .'" NumSeguridadSocial="' . $dataEmpleado['emp_Nss'] .'" FechaInicioRelLaboral="' . $dataEmpleado['emp_FechaIngreso'] .'" Antigüedad="P117W" TipoContrato="01" 
                        Sindicalizado="No" TipoJornada="01" TipoRegimen="02" NumEmpleado="' . $dataEmpleado['emp_Numero'] .'" Departamento="' . $dataEmpleado['dep_Nombre'] .'" Puesto="' . $dataEmpleado['pue_Nombre'] .'" RiesgoPuesto="1" 
                        PeriodicidadPago="04" SalarioBaseCotApor="' . $dataEmpleado['emp_SalarioDiario'] .'" SalarioDiarioIntegrado="' . $dataEmpleado['emp_SalarioDiarioIntegrado'] .'" ClaveEntFed="GUA" />
                    <nomina12:Percepciones TotalSueldos="' . $dataNomina['nom_Subtotal'] .'" TotalGravado="' . $dataNomina['nom_Subtotal'] .'" TotalExento="0.00">
                        <nomina12:Percepcion TipoPercepcion="001" Clave="001" Concepto="Sueldo" ImporteGravado="' . $dataNomina['nom_Importe'] .'" ImporteExento="0.00" />
                        <nomina12:Percepcion TipoPercepcion="010" Clave="015" Concepto="Bono puntualidad" ImporteGravado="' . $dataNomina['nom_BonoPuntualidad'] . '" ImporteExento="0.00" />
                        <nomina12:Percepcion TipoPercepcion="049" Clave="132" Concepto="Bono de asistencia" ImporteGravado="' . $dataNomina['nom_BonoAsistencia'] . '" ImporteExento="0.00" />
                    </nomina12:Percepciones>
                    <nomina12:Deducciones TotalOtrasDeducciones="' . $dataNomina['nom_Imss'] . '" TotalImpuestosRetenidos="' . $dataNomina['nom_ISR'] . '"> 
                        <nomina12:Deduccion TipoDeduccion="001" Clave="052" Concepto="IMSS" Importe="' . $dataNomina['nom_Imss'] . '" />
                        <nomina12:Deduccion TipoDeduccion="002" Clave="049" Concepto="ISR sp" Importe="' . $dataNomina['nom_ISR'] . '" />
                    </nomina12:Deducciones>
                </nomina12:Nomina>
            </cfdi:Complemento>
		</cfdi:Comprobante>';

        $url = dirname(BASEPATH)."/assets/files/timbradoNomina/archivoxmlfolio" . $idNomina . ".xml";
        $name_file = "archivoxmlfolio" . $idNomina . ".xml";
        $file = fopen($url, "w+");
        fwrite($file, $txt);
        fclose($file);

        return $name_file;
    }


    /**NUEVAS FUNCIONES**/
    //HUGO->Calcular sueldo diario integrado
    public function calcularSueldoDiarioIntegrado($fechaIngreso, $salarioDiario){

        try {
            $antiguedad = $this->antiguedadEmpleado($fechaIngreso);
            $config = $this->getDiasAguinaldoVacaciones($antiguedad);
            $fi = $this->calcularFactorIntegracion($config[0], $config[1]);
            $sdi = $fi * (float)$salarioDiario;
            return  round($sdi,2);
        }
        catch (exception $e){
            return 0;
        }
    }//calcularSueldoDiarioIntegrado

    //HUGO->Calcular factor de integracion
    private function calcularFactorIntegracion($diasVacaciones,$diasAguinaldo){
        $fi = 365 + $diasVacaciones + $diasAguinaldo;
        $fi = $fi / 365;
        return round($fi,4);
    }//calcularFactorIntegracion

    //HUGO->Calcular antiguedad empleado
    private function antiguedadEmpleado($fechaIngreso){

        $fi = new \DateTime($fechaIngreso);
        $fn = new \DateTime("now");
        $diff = $fi->diff($fn);

        return (int)$diff->y;
    }//antiguedadEmpleado

    //HUGO->Get aguinaldo
    private function getDiasAguinaldoVacaciones($antiguedad){
        $sql = "select vco_DiasVacaciones from vacacionconfig ";
        $vacacionesConfig = db()->query($sql)->getRowArray();
        $vaConfig = json_decode($vacacionesConfig['vco_DiasVacaciones'],true);

        $diasVacaciones = 0.0;
        $diasAguinaldo = 0.0;

        if($antiguedad == 0 || $antiguedad == 1){
            $dias = isset($vaConfig[0]['dias']) ? (float)$vaConfig[0]['dias'] : 0.0;
            $primaVac = isset($vaConfig[0]['prima']) ? (float)$vaConfig[0]['prima'] : 0.0;

            $diasVacaciones = ($dias / 100) * $primaVac;
            $diasAguinaldo = isset($vaConfig[0]['aguinaldo']) ? (float)$vaConfig[0]['aguinaldo'] : 0.0;

        }elseif($antiguedad == 2){
            $dias = isset($vaConfig[1]['dias']) ? (float)$vaConfig[1]['dias'] : 0.0;
            $primaVac = isset($vaConfig[1]['prima']) ? (float)$vaConfig[1]['prima'] : 0.0;

            $diasVacaciones = ($dias / 100) * $primaVac;
            $diasAguinaldo = isset($vaConfig[1]['aguinaldo']) ? (float)$vaConfig[1]['aguinaldo'] : 0.0;

        }elseif ($antiguedad == 3){
            $dias = isset($vaConfig[2]['dias']) ? (float)$vaConfig[2]['dias'] : 0.0;
            $primaVac = isset($vaConfig[2]['prima']) ? (float)$vaConfig[2]['prima'] : 0.0;

            $diasVacaciones = ($dias / 100) * $primaVac;
            $diasAguinaldo = isset($vaConfig[2]['aguinaldo']) ? (float)$vaConfig[2]['aguinaldo'] : 0.0;

        }elseif($antiguedad == 4){
            $dias = isset($vaConfig[3]['dias']) ? (float)$vaConfig[3]['dias'] : 0.0;
            $primaVac = isset($vaConfig[3]['prima']) ? (float)$vaConfig[3]['prima'] : 0.0;

            $diasVacaciones = ($dias / 100) * $primaVac;
            $diasAguinaldo = isset($vaConfig[3]['aguinaldo']) ? (float)$vaConfig[3]['aguinaldo'] : 0.0;

        }elseif($antiguedad >= 5 && $antiguedad <= 9){
            $dias = isset($vaConfig[4]['dias']) ? (float)$vaConfig[4]['dias'] : 0.0;
            $primaVac = isset($vaConfig[4]['prima']) ? (float)$vaConfig[4]['prima'] : 0.0;

            $diasVacaciones = ($dias / 100) * $primaVac;
            $diasAguinaldo = isset($vaConfig[4]['aguinaldo']) ? (float)$vaConfig[4]['aguinaldo'] : 0.0;

        }elseif($antiguedad >= 10 && $antiguedad <= 14){
            $dias = isset($vaConfig[5]['dias']) ? (float)$vaConfig[5]['dias'] : 0.0;
            $primaVac = isset($vaConfig[5]['prima']) ? (float)$vaConfig[5]['prima'] : 0.0;

            $diasVacaciones = ($dias / 100) * $primaVac;
            $diasAguinaldo = isset($vaConfig[5]['aguinaldo']) ? (float)$vaConfig[5]['aguinaldo'] : 0.0;

        }elseif($antiguedad >= 15 && $antiguedad <= 19){
            $dias = isset($vaConfig[6]['dias']) ? (float)$vaConfig[6]['dias'] : 0.0;
            $primaVac = isset($vaConfig[6]['prima']) ? (float)$vaConfig[6]['prima'] : 0.0;

            $diasVacaciones = ($dias / 100) * $primaVac;
            $diasAguinaldo = isset($vaConfig[6]['aguinaldo']) ? (float)$vaConfig[6]['aguinaldo'] : 0.0;

        }elseif($antiguedad >= 20 && $antiguedad <= 24){
            $dias = isset($vaConfig[7]['dias']) ? (float)$vaConfig[7]['dias'] : 0.0;
            $primaVac = isset($vaConfig[7]['prima']) ? (float)$vaConfig[7]['prima'] : 0.0;

            $diasVacaciones = ($dias / 100) * $primaVac;
            $diasAguinaldo = isset($vaConfig[7]['aguinaldo']) ? (float)$vaConfig[7]['aguinaldo'] : 0.0;

        }elseif($antiguedad >= 25 && $antiguedad <= 29){
            $dias = isset($vaConfig[8]['dias']) ? (float)$vaConfig[8]['dias'] : 0.0;
            $primaVac = isset($vaConfig[8]['prima']) ? (float)$vaConfig[8]['prima'] : 0.0;

            $diasVacaciones = ($dias / 100) * $primaVac;
            $diasAguinaldo = isset($vaConfig[8]['aguinaldo']) ? (float)$vaConfig[8]['aguinaldo'] : 0.0;

        }elseif($antiguedad >= 30 && $antiguedad <= 34){
            $dias = isset($vaConfig[9]['dias']) ? (float)$vaConfig[9]['dias'] : 0.0;
            $primaVac = isset($vaConfig[9]['prima']) ? (float)$vaConfig[9]['prima'] : 0.0;

            $diasVacaciones = ($dias / 100) * $primaVac;
            $diasAguinaldo = isset($vaConfig[9]['aguinaldo']) ? (float)$vaConfig[9]['aguinaldo'] : 0.0;

        }

        return array($diasVacaciones,$diasAguinaldo);
    }//getDiasAguinaldo

    //HUGO->Calcular el salario diario integrado a todos los empleados
    public function calcularSDIPorEmpresa($empresaID){
        $sql = "select emp_EmpleadoID as 'id', emp_SalarioDiario as 'sd', emp_FechaIngreso as 'fi' from empleado where emp_EmpresaID = ?";
        $empleados = db()->query($sql,array("emp_EmpresaID"=>(int)$empresaID))->getResultArray();

        foreach ($empleados as $empleado){
            $sdi = $this->calcularSueldoDiarioIntegrado($empleado['fi'],$empleado['sd'],$empresaID);
            $builder = db()->table("empleado");
            $builder->update(array("emp_SalarioDiarioIntegrado"=>(float)$sdi),array("emp_EmpleadoID"=>(int)$empleado['id']));
        }//foreach
    }//calcularSDIPorEmpresa

    public function calcularSueldoDiarioIntegradoYear($empresaID){
        $sql = "select emp_EmpleadoID as 'id', emp_SalarioDiario as 'sd', emp_FechaIngreso as 'fi' from empleado where emp_EmpresaID = ?";
        $empleados = db()->query($sql,array("emp_EmpresaID"=>(int)$empresaID))->getResultArray();

        foreach ($empleados as $empleado){

            if($empleado['fi'] != "0000-00-00") {
                $fecha = $empleado['fi'];
                $fechaentero = strtotime($fecha);
                $dia = date("d", $fechaentero);
                $mes = date("m", $fechaentero);
                $anoactual = date("Y");
                $cumple = $anoactual . "-" . $mes . "-" . $dia;
                if($cumple === date('Y-m-d')){
                    $sdi = $this->calcularSueldoDiarioIntegrado($empleado['fi'], $empleado['sd'], $empresaID);
                    $builder = db()->table("empleado");
                    $builder->update( array("emp_SalarioDiarioIntegrado" => (float)$sdi), array("emp_EmpleadoID" => (int)$empleado['id']));
                }
            }
        }//foreach
    }


}