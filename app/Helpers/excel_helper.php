<?php

//require(APPPATH."Libraries/phpexcel/Classes/PHPExcel.php");
//require(APPPATH."Libraries/phpexcel/Classes/PHPExcel/Writer/Excel2007.php");


class ExcelDoc {

    private $objPHPExcel;
    private $filename;

    public function __construct($filename){
        $this->objPHPExcel = null;
        $this->filename = $filename;
    }

    public function getInstance(){
        return $this->objPHPExcel;
    }//getInstance

    public function crear_excel($title = "", $subject = "", $description = "",$name = "Reporte"){

        try {

            // Create new PHPExcel object
            $this->objPHPExcel = new PHPExcel();

            $this->objPHPExcel->getProperties()->setCreator("Admin-Eventos");
            $this->objPHPExcel->getProperties()->setLastModifiedBy("Admin-Eventos");
            $this->objPHPExcel->getProperties()->setTitle($title);
            $this->objPHPExcel->getProperties()->setSubject($subject);
            $this->objPHPExcel->getProperties()->setDescription($description);

            // Add some data
            $this->objPHPExcel->getActiveSheet()->setTitle($name);
            $this->objPHPExcel->setActiveSheetIndex(0);

            return true;

        } catch(Exception $e){
            return false;
        }

    }//End crear_excel

    public function fijar_ancho_automatico($columnas){
        foreach ($columnas AS $col)
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
    }//fijar_ancho_automatico

    public function descargar_excel(){

        header('Content-Type: application/vnd.ms-excel;charset=utf-8');
        header("Content-Disposition: attachment;filename=\"{$this->filename}\"");
        header('Cache-Control: max-age=0');

        try{
            $this->objPHPExcel = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
            $this->objPHPExcel->save('php://output');
            exit;
        } catch(Exception $e) { }

    }//descargar_excel

    public function fijar_fila_multilinea($columna, $width){
        $activeSheet = $this->objPHPExcel->getActiveSheet();
        $activeSheet->getStyle("$columna" . "1" . ":$columna" . $this->objPHPExcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);
        $activeSheet->getColumnDimension($columna)->setWidth($width);
    }//fijar_fila_multilinea

    public function escribir_encabezados($encabezados = null, $fila = 1, $bg_color = '1A2942', $font_color = 'FFFFFF', $font_size = 16, $start = 'A'){
        if (empty($this->objPHPExcel) || empty($encabezados)) return;
        $col = $start;
        foreach ($encabezados as $encabezado)
            $this->escribir_en_celda(($col++) . $fila, $encabezado, $bg_color, $font_color, true, $font_size);
    }//End escribir_encabezados

    public function fijar_filtros($rango){
        $this->objPHPExcel->getActiveSheet()->setAutoFilter($rango);
    }//fijar_filtros

    public function escribir_en_celda($celda, $texto, $bg_color = 'FFFFFF', $font_color = '000000', $bold = false, $size = '14', $alignment_p = "center"){

        if (empty($this->objPHPExcel)) return;

        $alignment = "";

        switch($alignment_p){
            case "left":
                $alignment = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
                break;
            case "center":
                $alignment = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
                break;
            case "right":
                $alignment = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
                break;
        }

        $this->objPHPExcel->getActiveSheet()->SetCellValue($celda, $texto);
        if (strlen($texto) > 15)
            $this->objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setWrapText(true);
        $style = $this->objPHPExcel->getActiveSheet()->getStyle($celda);
        $style->applyFromArray(array(
            'alignment' => array(
                'horizontal' => $alignment,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
            ),
            'font' => array(
                'bold' => $bold,
                'color' => array('rgb' => $font_color),
                'size' => $size,
                'name' => 'Calibri'
            )
        ));

        if ($bg_color !== 'FFFFFF') {
            $style->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => $bg_color
                )
            ));
        }//End if

    }//CellColor

    //LLena celdas de color.
    public function colorear_fila($fila, $col_ini, $col_fin, $bg_color){
        if ($fila < 1 || !$col_ini || !$col_fin) return;
        for ($i_col = $col_ini; $i_col <= $col_fin; $i_col++)
            $this->objPHPExcel->escribir_en_celda($i_col . $fila, " ", $bg_color);
    }//End colorear_fila

    //Combinar celdas
    public function combinar_celdas($celdas,$index = 0)
    {
        $this->objPHPExcel->setActiveSheetIndex($index)->mergeCells($celdas);
    }//End combinar_celdas

    //Poner bordes a celda
    public function poner_bordes($celdas,$style)
    {
        $this->objPHPExcel->getActiveSheet()->getStyle($celdas)->applyFromArray($style);
    }//End poner_bordes

    //Poner ancho a una celda
    public function poner_ancho_celda($celda,$tamaño)
    {
        $this->objPHPExcel->getActiveSheet()->getColumnDimension($celda)->setWidth($tamaño);
    }//End poner_ancho_celda

    //Poner formato de numero a celda
    public function formato_numero($celda)
    {
        $this->objPHPExcel->getActiveSheet()->getStyle($celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
    }//End formato_numero

    //Colocal una imagen en el excel
    public function set_Imagen($name,$description,$url,$cell,$offsetX,$offsetY,$height){
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName($name);
        $objDrawing->setDescription($description);
        $objDrawing->setPath($url);
        $objDrawing->setCoordinates($cell); //setOffsetX works properly
        $objDrawing->setOffsetX($offsetX);
        $objDrawing->setOffsetY($offsetY); //set width, height
        //$objDrawing->setWidth(120);
        $objDrawing->setHeight($height);
        $objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
    }//set_Imagen

    //Inmovilizar columnas
    public function freezePane($column){
        $this->objPHPExcel->getActiveSheet()->freezePane($column);
    }

    //Formato moneda
    public function formato_moneda($celda){
        $this->objPHPExcel->getActiveSheet()->getStyle($celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
    }//End formato_moneda

    //Add page
    public function add_page($index,$name){
        $this->objPHPExcel->createSheet($index);
        $this->objPHPExcel->setActiveSheetIndex($index);
        $this->objPHPExcel->getActiveSheet()->setTitle($name);
    }//Add page

    //Hoja activa excel
    public function setActiveSheet($index){
       return $this->objPHPExcel->setActiveSheetIndex($index);
    }//setActiveSheet

}//End class ExcelDoc