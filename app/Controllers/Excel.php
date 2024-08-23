<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\ExcelModel;

class Excel extends BaseController
{

    private static $titulo = '6E6E6E';
    private static $subtitulo = '70bf96';
    private static $columna = '9ac11f';
    private static $datos = 'F2F2F2';


    //Diego -> Descargar catalogo de empleados
    public function generarExcelDirectorioEmpleados()
    {
        //Get Data
        $sql = "SELECT E.emp_Numero, E.emp_Nombre,  P.pue_Nombre, E.emp_Celular
                FROM empleado E
                    JOIN puesto P ON P.pue_PuestoID =   E.emp_PuestoID
                    JOIN departamento D ON D.dep_DepartamentoID = E.emp_DepartamentoID
                WHERE  E.emp_Estatus = 1 ORDER BY E.emp_Nombre ASC ";
        $empleados = $this->db->query($sql)->getResultArray();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Thigo")
            ->setTitle("Directorio de empleados")
            ->setSubject("Empleados")
            ->setDescription("Directorio de empleados");


        $model = new ExcelModel();
        $resultado = $model->getPuestos();

        $estiloTitulo = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'f3f6f8',
                ]
            ],
        ];

        $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'NÚMERO')
            ->setCellValue('B1', 'NOMBRE')
            ->setCellValue('C1', 'PUESTO')
            ->setCellValue('D1', 'CELULAR');

        $spreadsheet->getActiveSheet()->fromArray($empleados, '', 'A2');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:D1')->getFont()->setName('Arial');
        $spreadsheet->getActiveSheet()->getStyle('A1:D1')->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getStyle('A1:D1')->applyFromArray($estiloTitulo);

        $spreadsheet->getActiveSheet()->setAutoFilter($spreadsheet->getActiveSheet()->calculateWorksheetDimension());

        $writer = new Xlsx($spreadsheet);
        header("Content-Type: application/vnd.ms-excel");
        $writer->save('php://output');
        exit();
    } //generarExcelEmpleados

    //Lia -> Descargar catalogo de empleados
    public function generarExcelEmpleados()
    {
        //Validar sessión

        //Get Data
        $sql = "SELECT  E.emp_Numero,E.emp_Nombre,
        JEFE.emp_Nombre as 'jefe',
        E.emp_Correo,
        P.pue_Nombre,
        D.dep_Nombre,
        S.suc_Sucursal,
        E.emp_Direccion,
        E.emp_Curp,
        E.emp_Rfc,
        E.emp_Nss,
        E.emp_EstadoCivil,
        E.emp_FechaIngreso,
        E.emp_FechaNacimiento,
        E.emp_Telefono,
        E.emp_Celular,
        E.emp_Sexo,
        E.emp_SalarioMensual,
        E.emp_SalarioMensualIntegrado,
        E.emp_CodigoPostal,
        E.emp_Municipio,
        E.emp_EntidadFederativa,
        E.emp_Pais,
        E.emp_EstatusContratacion,
        E.emp_TipoPrestaciones,
        IF(E.emp_Rol>0,R.rol_Nombre,'Colaborador'),
        IF(E.emp_HorarioID>0,H.hor_Nombre,'Sin horario asignado'),
        E.emp_NumeroEmergencia,
        E.emp_NombreEmergencia,
        E.emp_Parentesco
                FROM empleado E
                    LEFT JOIN puesto P ON P.pue_PuestoID =   E.emp_PuestoID
                    LEFT JOIN departamento D ON D.dep_DepartamentoID = E.emp_DepartamentoID
                    LEFT JOIN empleado JEFE ON JEFE.emp_Numero=E.emp_Jefe
                    LEFT JOIN sucursal S ON S.suc_SucursalID=E.emp_SucursalID
                    LEFT JOIN rol R ON R.rol_RolID=E.emp_Rol
                    LEFT JOIN horario H ON H.hor_HorarioID=E.emp_HorarioID
                WHERE E.emp_Estatus = 1 ORDER BY E.emp_Nombre ASC ";
        $empleados = $this->db->query($sql)->getResultArray();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Thigo")
            ->setTitle("Catalogo de empleados")
            ->setSubject("Empleados")
            ->setDescription("Catalogo de empleados");

        $estiloTitulo = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'f3f6f8',
                ]
            ],
        ];

        $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'NÚMERO')
            ->setCellValue('A1', 'NUMERO')
            ->setCellValue('B1', 'NOMBRE')
            ->setCellValue('C1', 'JEFE DIRECTO')
            ->setCellValue('D1', 'CORREO')
            ->setCellValue('E1', 'PUESTO')
            ->setCellValue('F1', 'DEPARTAMENTO')
            ->setCellValue('G1', 'SUCURSAL')
            ->setCellValue('H1', 'DIRECCIÓN')
            ->setCellValue('I1', 'CURP')
            ->setCellValue('J1', 'RFC')
            ->setCellValue('K1', 'NSS')
            ->setCellValue('L1', 'ESTADO CIVIL')
            ->setCellValue('M1', 'FECHA DE INGRESO')
            ->setCellValue('N1', 'FECHA DE NACIMIENTO')
            ->setCellValue('O1', 'TELEFONO')
            ->setCellValue('P1', 'CELULAR')
            ->setCellValue('Q1', 'SEXO')
            ->setCellValue('R1', 'SALARIO MENSUAL')
            ->setCellValue('S1', 'SALARIO MENSUAL INTEGRADO')
            ->setCellValue('T1', 'CODIGO POSTAL')
            ->setCellValue('U1', 'CIUDAD')
            ->setCellValue('V1', 'ESTADO')
            ->setCellValue('W1', 'PAIS')
            ->setCellValue('X1', 'TIPO DE CONTRATO')
            ->setCellValue('Y1', 'TIPO DE PRESTACIONES')
            ->setCellValue('Z1', 'ROL')
            ->setCellValue('AA1', 'HORARIO')
            ->setCellValue('AB1', 'NUMERO EMERGENCIA')
            ->setCellValue('AC1', 'PERSONA EMERGENCIA')
            ->setCellValue('AD1', 'PARENTESCO EMERGENCIA')
            ;

        $spreadsheet->getActiveSheet()->fromArray($empleados, '', 'A2');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);


        $spreadsheet->getActiveSheet()->getStyle('A1:AE1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:AE1')->getFont()->setName('Arial');
        $spreadsheet->getActiveSheet()->getStyle('A1:AE1')->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getStyle('A1:AE1')->applyFromArray($estiloTitulo);

        $spreadsheet->getActiveSheet()->setAutoFilter($spreadsheet->getActiveSheet()->calculateWorksheetDimension());

        $writer = new Xlsx($spreadsheet);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="Empleados.xls"');
        $writer->save('php://output');
        exit();
    } //generarExcelEmpleados

    //Lia -> Descargar catalogo de empleados
    public function generarExcelTodosEmpleados()
    {
        //Validar sessión

        //Get Data
        $sql = "SELECT  E.emp_Numero,E.emp_Nombre,
        JEFE.emp_Nombre as 'jefe',
        E.emp_Correo,
        E.emp_Estudios,
        E.emp_Carrera,
        P.pue_Nombre,
        D.dep_Nombre,
        S.suc_Sucursal,
        E.emp_Direccion,
        E.emp_Curp,
        E.emp_Rfc,
        E.emp_Nss,
        E.emp_EstadoCivil,
        E.emp_FechaIngreso,
        BE.baj_FechaBaja,
        E.emp_FechaNacimiento,
        E.emp_Telefono,
        E.emp_Celular,
        E.emp_Sexo,
        E.emp_SalarioMensual,
        E.emp_SalarioMensualIntegrado,
        E.emp_CodigoPostal,
        E.emp_Municipio,
        E.emp_EntidadFederativa,
        E.emp_Pais,
        E.emp_EstatusContratacion,
        E.emp_TipoPrestaciones,
        IF(E.emp_Rol>0,R.rol_Nombre,'Colaborador'),
        IF(E.emp_HorarioID>0,H.hor_Nombre,'Sin horario asignado'),
        E.emp_NumeroEmergencia,
        E.emp_NombreEmergencia,
        E.emp_Parentesco
                FROM empleado E
                    LEFT JOIN bajaempleado BE ON BE.baj_EmpleadoID = E.emp_EmpleadoID
                    LEFT JOIN puesto P ON P.pue_PuestoID =   E.emp_PuestoID
                    LEFT JOIN departamento D ON D.dep_DepartamentoID = E.emp_DepartamentoID
                    LEFT JOIN empleado JEFE ON JEFE.emp_Numero=E.emp_Jefe
                    LEFT JOIN sucursal S ON S.suc_SucursalID=E.emp_SucursalID
                    LEFT JOIN rol R ON R.rol_RolID=E.emp_Rol
                    LEFT JOIN horario H ON H.hor_HorarioID=E.emp_HorarioID
                ORDER BY E.emp_Nombre ASC ";
        $empleados = $this->db->query($sql)->getResultArray();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Thigo")
            ->setTitle("Catalogo de empleados")
            ->setSubject("Empleados")
            ->setDescription("Catalogo de empleados");

        $estiloTitulo = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'f3f6f8',
                ]
            ],
        ];

        $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'NÚMERO')
            ->setCellValue('A1', 'NUMERO')
            ->setCellValue('B1', 'NOMBRE')
            ->setCellValue('C1', 'JEFE DIRECTO')
            ->setCellValue('D1', 'CORREO')
            ->setCellValue('E1', 'ESTUDIOS')
            ->setCellValue('F1', 'PROFESION')
            ->setCellValue('G1', 'PUESTO')
            ->setCellValue('H1', 'DEPARTAMENTO')
            ->setCellValue('I1', 'SUCURSAL')
            ->setCellValue('J1', 'DIRECCIÓN')
            ->setCellValue('K1', 'CURP')
            ->setCellValue('L1', 'RFC')
            ->setCellValue('M1', 'NSS')
            ->setCellValue('N1', 'ESTADO CIVIL')
            ->setCellValue('O1', 'FECHA DE INGRESO')
            ->setCellValue('P1', 'FECHA DE BAJA')
            ->setCellValue('Q1', 'FECHA DE NACIMIENTO')
            ->setCellValue('R1', 'TELEFONO')
            ->setCellValue('S1', 'CELULAR')
            ->setCellValue('T1', 'SEXO')
            ->setCellValue('U1', 'SALARIO MENSUAL')
            ->setCellValue('V1', 'SALARIO MENSUAL INTEGRADO')
            ->setCellValue('W1', 'CODIGO POSTAL')
            ->setCellValue('X1', 'CIUDAD')
            ->setCellValue('Y1', 'ESTADO')
            ->setCellValue('Z1', 'PAIS')
            ->setCellValue('AA1', 'TIPO DE CONTRATO')
            ->setCellValue('AB1', 'TIPO DE PRESTACIONES')
            ->setCellValue('AC1', 'ROL')
            ->setCellValue('AD1', 'HORARIO')
            ->setCellValue('AE1', 'NUMERO EMERGENCIA')
            ->setCellValue('AF1', 'PERSONA EMERGENCIA')
            ->setCellValue('AG1', 'PARENTESCO EMERGENCIA')
            ;

        $spreadsheet->getActiveSheet()->fromArray($empleados, '', 'A2');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);


        $spreadsheet->getActiveSheet()->getStyle('A1:AG1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:AG1')->getFont()->setName('Arial');
        $spreadsheet->getActiveSheet()->getStyle('A1:AG1')->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getStyle('A1:AG1')->applyFromArray($estiloTitulo);

        $spreadsheet->getActiveSheet()->setAutoFilter($spreadsheet->getActiveSheet()->calculateWorksheetDimension());

        $writer = new Xlsx($spreadsheet);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="Empleados.xls"');
        $writer->save('php://output');
        exit();
    } //generarExcelEmpleados

 
    public function reporteAsistencias()
    {
        $post = $this->request->getPost();
        $fechaInicio = $post['fechaInicio'];
        $fechaFin = $post['fechaFin'];
        //$fechaInicio = '2023-08-01';
        //$fechaFin = '2023-08-31';

        ini_set('max_execution_time', 0);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Thigo")
            ->setTitle("Reporte de asistencia")
            ->setSubject("Asistencia")
            ->setDescription("Reporte de asistencia");

        $estiloTitulo = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'f3f6f8',
                ]
            ],
        ];

        $spreadsheet->getActiveSheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', 'No. Colaborador')
            ->setCellValue('B1', 'Nombre')
            ->setCellValue('C1', 'Sucursal')
            ->setCellValue('D1', 'Retardos')
            ->setCellValue('E1', 'Faltas')
            ;

        $spreadsheet->getActiveSheet()->mergeCells("A1:A2");
        $spreadsheet->getActiveSheet()->mergeCells("B1:B2");
        $spreadsheet->getActiveSheet()->mergeCells("C1:C2");
        $spreadsheet->getActiveSheet()->mergeCells("D1:D2");
        $spreadsheet->getActiveSheet()->mergeCells("E1:E2");


        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:E2')->applyFromArray($estiloTitulo);



        //WRITE FILE PERIOD
        $dateCols = array();
        $row = 1;
        $col = 'F';           //Column where the dates will be printed from (E), cell index starts on A=1, B=2, and so on...
        $iFecha = $fechaInicio;
        //Sumar un día a la fecha fin, para poder obtener las salidas de los turnos que acaban al siguiente día...
        $temp = strtotime('+0 days', strtotime($fechaFin));
        $fechaFinMasUnDIa = date('Y-m-d', $temp);
        while ($iFecha <= $fechaFinMasUnDIa) {

            //Save initial date colum
            $dateCols[$iFecha] = $col;

            $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);

            //WRITE DATA AND MERGE CELLS
            if ($iFecha <= $fechaFin) {


                $spreadsheet->getActiveSheet()->setCellValue($col . $row,  weekDate($iFecha));
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . $row)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . $row)->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . $row)->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . $row)->applyFromArray($estiloTitulo);

                $spreadsheet->getActiveSheet()->setCellValue($col . ($row + 1), 'Entrada');
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->applyFromArray($estiloTitulo);

                $startCol = $col++;


                $spreadsheet->getActiveSheet()->setCellValue($col . ($row + 1), 'Salida');
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->applyFromArray($estiloTitulo);

                $col++;

                $spreadsheet->getActiveSheet()->setCellValue($col . ($row + 1), 'Horario');
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->applyFromArray($estiloTitulo);

                $col++;

                $spreadsheet->getActiveSheet()->setCellValue($col . ($row + 1), 'Checadas');
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->applyFromArray($estiloTitulo);

                $col++;

                $spreadsheet->getActiveSheet()->setCellValue($col . ($row + 1), 'Observaciones');
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->applyFromArray($estiloTitulo);

                $endCol = $col++;
                $spreadsheet->getActiveSheet()->mergeCells($startCol . $row . ":" . $endCol . $row);
            } //if



            //ADD ONE DAY
            $temp = strtotime('+1 days', strtotime($iFecha));
            $iFecha = date('Y-m-d', $temp);
        } //while


        $row++;

        $model = new ExcelModel();
        $resultado = $model->getEmpleadosHorario($fechaInicio, $fechaFinMasUnDIa, $dateCols);
        $spreadsheet->getActiveSheet()->fromArray($resultado, '', 'A3');

        $spreadsheet->getActiveSheet()->setAutoFilter('A2:' . $endCol . '2');
        $spreadsheet->getActiveSheet()->freezePaneByColumnAndRow(5, 3);

        $writer = new Xlsx($spreadsheet);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="ReporteAsistencia.xls"');
        $writer->save('php://output');
        exit();

       /* $url = FCPATH . "./assets/uploads/ReporteAsistencia.xls";

        //Subir doc

        if (file_exists($url)) {
            unlink($url);
            $writer->save('./assets/uploads/ReporteAsistencia.xls');
        } else {
            $writer->save('./assets/uploads/ReporteAsistencia.xls');
        }

        return redirect()->to(base_url("Incidencias/reporteAsistencia"));*/

    }

    public function reporteAsistenciasDiario()
    {
        $nombreArchivo = 'reporteAsistencia.xlsx';
        $rutaDirectorio = FCPATH.('assets/uploads/reporteAsistencia/'.date('Y').'/'.date('m'));
        $rutaArchivo = $rutaDirectorio.'/'.$nombreArchivo;
        if (!file_exists($rutaDirectorio)) {
            mkdir($rutaDirectorio, 0777, true);
        }

        $fechaInicio = date('Y-m-01');
        $fechaFin = date('Y-m-d');
        if(date('d')==1){
            $spreadsheet = new Spreadsheet();
        }else{
            if(!file_exists($rutaArchivo)){
                $spreadsheet = new Spreadsheet();
            }else{
                $spreadsheet = IOFactory::load($rutaArchivo);
            }
        }

        ini_set('max_execution_time', 0);

        $spreadsheet->getProperties()
            ->setCreator("Thigo")
            ->setTitle("Reporte de asistencia")
            ->setSubject("Asistencia")
            ->setDescription("Reporte de asistencia");



        $estiloTitulo = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'f3f6f8',
                ]
            ],
        ];

        $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', 'No. Colaborador')
            ->setCellValue('B1', 'Nombre')
            ->setCellValue('C1', 'Retardos')
            ->setCellValue('D1', 'Faltas')
            ;

        $spreadsheet->getActiveSheet()->mergeCells("A1:A2");
        $spreadsheet->getActiveSheet()->mergeCells("B1:B2");
        $spreadsheet->getActiveSheet()->mergeCells("C1:C2");
        $spreadsheet->getActiveSheet()->mergeCells("D1:D2");


        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:D2')->applyFromArray($estiloTitulo);



        //WRITE FILE PERIOD
        $dateCols = array();
        $row = 1;
        $col = 'E';           //Column where the dates will be printed from (E), cell index starts on A=1, B=2, and so on...
        $iFecha = $fechaInicio;
        //Sumar un día a la fecha fin, para poder obtener las salidas de los turnos que acaban al siguiente día...
        $temp = strtotime('+0 days', strtotime($fechaFin));
        $fechaFinMasUnDIa = date('Y-m-d', $temp);
        while ($iFecha <= $fechaFinMasUnDIa) {

            //Save initial date colum
            $dateCols[$iFecha] = $col;

            $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);

            //WRITE DATA AND MERGE CELLS
            if ($iFecha <= $fechaFin) {


                $spreadsheet->getActiveSheet()->setCellValue($col . $row,  weekDate($iFecha));
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . $row)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . $row)->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . $row)->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . $row)->applyFromArray($estiloTitulo);

                $spreadsheet->getActiveSheet()->setCellValue($col . ($row + 1), 'Entrada');
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->applyFromArray($estiloTitulo);

                $startCol = $col++;


                $spreadsheet->getActiveSheet()->setCellValue($col . ($row + 1), 'Salida');
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->applyFromArray($estiloTitulo);

                $col++;

                $spreadsheet->getActiveSheet()->setCellValue($col . ($row + 1), 'Horario');
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->applyFromArray($estiloTitulo);

                $col++;

                $spreadsheet->getActiveSheet()->setCellValue($col . ($row + 1), 'Checadas');
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->applyFromArray($estiloTitulo);

                $col++;

                $spreadsheet->getActiveSheet()->setCellValue($col . ($row + 1), 'Observaciones');
                $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setName('Arial');
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->getStyle($col . ($row + 1))->applyFromArray($estiloTitulo);

                $endCol = $col++;
                $spreadsheet->getActiveSheet()->mergeCells($startCol . $row . ":" . $endCol . $row);
            } //if



            //ADD ONE DAY
            $temp = strtotime('+1 days', strtotime($iFecha));
            $iFecha = date('Y-m-d', $temp);
        } //while


        $row++;

        $model = new ExcelModel();
        $resultado = $model->getEmpleadosHorario($fechaInicio, $fechaFinMasUnDIa, $dateCols);
        $spreadsheet->getActiveSheet()->fromArray($resultado, '', 'A3');

        $spreadsheet->getActiveSheet()->setAutoFilter('A2:' . $endCol . '2');
        $spreadsheet->getActiveSheet()->freezePaneByColumnAndRow(5, 3);

        $writer = new Xlsx($spreadsheet);
        $writer->save($rutaArchivo);
        exit();
    }
}
