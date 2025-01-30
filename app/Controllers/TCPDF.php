<?php 
require(APPPATH . 'Libraries/tcpdf/tcpdf.php');
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}