<?php 
if(!defined('BASEPATH')) exit ('NO Direct script access allowed');
 require_once APPPATH."/third_party/fpdf/FPDF.php";
class Fpdf_gen{
    public function __construct(){
       
	   $pdf=new FPDF();
	   //$pdf->AliasNbPages();
	   $pdf->AddPage();
	   $CI=get_instance();
	   $CI->fpdf=$pdf;
    }
}