<?php defined('FCPATH') OR exit('No direct script access allowed');

use App\Models\IncidenciasModel;

class Anticipos
{

    function db(){
        return $db = \Config\Database::connect();
    }

    public function __construct($empleadoID){
        return $this->empleadoID =(int)encryptDecrypt('decrypt',$empleadoID);
    }

    public  function calculo(){

        $calculo = array(
            "antiguedad"=>$this->antiguedadEmpleado(),
            "mesesDerecho"=>$this->mesesDerecho(),
            "salarioDiarioActual"=>$this->salarioDiarioActual(),
            "plazoAplicable"=>$this->plazoQuincenas(),
            "salarioMensual"=>$this->calcularSalarioMensual(),
            "fondoAhorro"=>$this->calcularFondoAhorro(),
            "montoDespensa"=>$this->montoDespensa(),
            "salarioMensualIntegrado"=>$this->calcularSalarioMensualIntegrado(),
            "montoMaximoSolicitar"=>$this->montoMaximoSolicitar(),
            "montoMaximoRetener"=>$this->calcularMontoMaximoRetener(),
            "noMinimoQuincenasPagando"=>$this->calcularNoQuincenasEstariaPagando(),
            "noMinimoMesesPagando"=>$this->calcularNoMesesEstariaPagando(),
            "noMinimoAniosPagando"=>$this->calcularNoAniosEstariaPagando(),
        );

        return $calculo;
    }//calculo

    public function antiguedadEmpleado(){
        $model = new IncidenciasModel();
        $antiguedad =  $model->getAntiguedadEmpleado($this->empleadoID);
        return (float)$antiguedad;
    }//antiguedadEmpleado

    public function mesesDerecho(){

        $mesesDerecho = 0;
        $model = new IncidenciasModel();
        $montosAnticipo = $model->getMontosAnticiposConfig();
        $antiguedad = $model->getAntiguedadEmpleado($this->empleadoID);

        if($antiguedad > 0){
            switch ($antiguedad){
                case 1:
                    $mesesDerecho = isset($montosAnticipo[0][1]) ? $montosAnticipo[0][1] : 0;
                    break;
                case 2:
                    $mesesDerecho = isset($montosAnticipo[1][1]) ? $montosAnticipo[1][1] : 0;
                    break;
                case 3:
                    $mesesDerecho = isset($montosAnticipo[1][1]) ? $montosAnticipo[1][1] : 0;
                    break;
                case 4:
                    $mesesDerecho = isset($montosAnticipo[2][1]) ? $montosAnticipo[2][1] : 0;
                    break;
                case 5:
                    $mesesDerecho = isset($montosAnticipo[2][1]) ? $montosAnticipo[2][1] : 0;
                    break;
                case 6:
                    $mesesDerecho = isset($montosAnticipo[3][1]) ? $montosAnticipo[3][1] : 0;
                    break;
                default:
                    $mesesDerecho = isset($montosAnticipo[4][1]) ? $montosAnticipo[4][1] : 0;
                    break;

            }//switch
        }
        return $mesesDerecho;
    }//getMesesDerecho

    public function salarioDiarioActual(){
        $model = new IncidenciasModel();
        $empleado = $model->getInfoEmpleado($this->empleadoID);
        return (float)$empleado['emp_SalarioDiario'];
    }//getSalarioDiarioActual

    public function plazoQuincenas(){

        $quincenas = 0;
        $model = new IncidenciasModel();
        $montosAnticipo = $model->getMontosAnticiposConfig();
        $antiguedad = $model->getAntiguedadEmpleado($this->empleadoID);

        if($antiguedad > 0){
            switch ($antiguedad){
                case 1:
                    $quincenas = isset($montosAnticipo[0][2]) ? $montosAnticipo[0][2] : 0;
                    break;
                case 2:
                    $quincenas = isset($montosAnticipo[1][2]) ? $montosAnticipo[1][2] : 0;
                    break;
                case 3:
                    $quincenas = isset($montosAnticipo[1][2]) ? $montosAnticipo[1][2] : 0;
                    break;
                case 4:
                    $quincenas = isset($montosAnticipo[2][2]) ? $montosAnticipo[2][2] : 0;
                    break;
                case 5:
                    $quincenas = isset($montosAnticipo[2][2]) ? $montosAnticipo[2][2] : 0;
                    break;
                case 6:
                    $quincenas = isset($montosAnticipo[3][2]) ? $montosAnticipo[3][2] : 0;
                    break;
                default:
                    $quincenas = isset($montosAnticipo[4][2]) ? $montosAnticipo[4][2] : 0;
                    break;

            }//switch
        }
        return $quincenas;
    }//getPlazoQuincenas

    public function calcularSalarioMensual(){
        $salario = $this->salarioDiarioActual();

        $salarioMensual = $salario * 30.4;

        return round($salarioMensual,2);
    }//calcularSalarioMensual

    public function calcularFondoAhorro(){
        $model = new IncidenciasModel();
        $porcentaje = (float)$model->getSettings('porc_fondo_ahorro_simulador_anticipo');
        $porcentaje = $porcentaje > 0 ? $porcentaje/100 : 0;
        $salarioMensual = (float)$this->calcularSalarioMensual();

        $fondoAhorro = $porcentaje > 0 ? $salarioMensual * $porcentaje : 0.00;

        return round($fondoAhorro,2);



        return $porcentaje;
    }//calcularFondoAhorro

    public function montoDespensa(){
        $model = new IncidenciasModel();
        $despensa = $model->getSettings('valor_despensa_simulador_anticipo');
        return (float)$despensa;
    }//montoDespensa

    public function calcularSalarioMensualIntegrado(){
        $salarioMensual = $this->calcularSalarioMensual();
        $fondoAhorro = $this->calcularFondoAhorro();
        $despensa = $this->montoDespensa();

        $smi = (float)$salarioMensual + (float)$fondoAhorro + (float)$despensa;

        return round($smi,2);

    }//calcularSalarioMensualIntegrado

    public function montoMaximoSolicitar(){
        $mesesDerecho = (float)$this->mesesDerecho();
        $smi = (float)$this->calcularSalarioMensualIntegrado();

        $maximo = $mesesDerecho * $smi;

        return round($maximo,2);
    }//montoMaximoSolicitar

    public function salarioMinimo(){
        $model = new IncidenciasModel();
        $sm = $model->getSettings('salario_minimo_2021');

        return (float)$sm;
    }//salarioMinimo

    public function  porcMaximoRetencionLFT(){
        $model = new IncidenciasModel();
        $porcentaje = (float)$model->getSettings('porc_lft_max_retencion');

        $porcentaje = $porcentaje > 0 ? $porcentaje / 100 : 0.00;
        return $porcentaje;

    }//porcMaximoRetencionLFT

    public function calcularMontoMaximoRetener(){
        $salarioMinimo = (float)$this->salarioMinimo();
        $salarioMensualEmpleado = (float)$this->calcularSalarioMensual();
        $salarioQuincenalEmpleado = round($salarioMensualEmpleado/2,2);
        $salarioMensualPais = round($salarioMinimo * 30.4,2);
        $salarioQuincenalPais = round($salarioMensualPais/2,2);
        $diferencia = round($salarioQuincenalEmpleado - $salarioQuincenalPais,2);
        $porcentajeLFT = (float)$this->porcMaximoRetencionLFT();

        $maximo = $diferencia * $porcentajeLFT;

        return round($maximo,2);
    }//calcularMontoMaximoRetener

    public function calcularNoQuincenasEstariaPagando(){
        $maximoSolicitar = (float)$this->montoMaximoSolicitar();
        $maximoRetener = (float)$this->calcularMontoMaximoRetener();

        $no = $maximoRetener > 0 ? $maximoSolicitar / $maximoRetener : 0.0;
        return round($no,2);
    }//calcularNoQuincenasEstariaPagando

    public function calcularNoAniosEstariaPagando(){
        $quincenas = (float)$this->calcularNoQuincenasEstariaPagando();
        $anios = $quincenas / 24;

        return round($anios,2);
    }//calcularNoAniosEstariaPagando

    public function calcularNoMesesEstariaPagando(){
        $anios = (float)$this->calcularNoAniosEstariaPagando();
        $meses = $anios * 12;

        return round($meses,2);
    }//calcularNoMesesEstariaPagando

    public function generarPlanPago($montoSolicitado,$quincenas,$pago){
        $data = array();
        if($montoSolicitado > 0 && $quincenas > 0 && $pago > 0){
            $hoy = date('d');
            if ($hoy <= 15)
                $quincena = date('Y-m')."-15";
            else
                $quincena = date('Y-m-t');

            for($i = 1; $i <= $quincenas; $i++){
                $montoSolicitado -= $pago;

                $montoSolicitado = $montoSolicitado < 0 ? 0 : $montoSolicitado;
                $row['plazo'] = $i;
                $row['fechaAbono'] = $quincena;
                $row['importeAbono'] = "$ ".number_format($pago,2);
                $row['interesesPagar'] = "$ ".number_format(0,2);
                $row['saldoActual'] = "$ ".number_format($montoSolicitado,2);
                $row['compromisoAhorro'] ="$ ".number_format(0,2);
                $row['totalAbono'] = "$ ".number_format($pago,2);
                array_push($data,$row);

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
        return $data;
    }//generarPlanPago

}