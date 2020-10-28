<?php 

// setting a global timezone to use across all pdfs.
date_default_timezone_set('Africa/Nairobi');

// instatiation of the main tcpdf Class. 
require('../../utils/configs/TCPDF-master/tcpdf.php');

class PDF extends TCPDF{

    function header(){

        // set document information
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('Munawara');

        // set some language dependent data:
        $lg = Array();

        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';

        // set some language-dependent strings (optional)
        $this->setLanguageArray($lg);

        $this->Rect(5, 5, 200, 33); // Rectangle Around the Header.

        $this->Image('../../src/img/favicon.jpeg', 7,6,35,30);

        $this->setRTL(false);        
        // set font
        $this->SetFont('aefurat', '', 29);

        $this->Cell(0, 12, '‫المدرسة‬ ‫ا لمنورة الإسلامية‬ ‫‬ ',0,1, 'C');
        $this->setRTL(false);

        $this->SetFont('aefurat', 'U', 17);
        $this->Cell(20);
        $this->Cell(0,10,'MADRASATUL MUNAWWARAH AL ISLAMIYYA',$border=0,$ln=1,'C',$fill=false, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
            
        $this->SetFont('aefurat', 'B', 12);

        $this->Cell(135,5,'P.O.Box: 98616-80100 Mombasa-Kenya', 0, 0, 'C');
        $this->Cell(0,5,'Email: info@almunawwarah.ac.ke', 0, 1, 'C');

        $this->Cell(130,5,'Tel No: 0720 211 495/ 0733 806 604', 0, 0, 'C');
        $this->Cell(0,5,'Website : www.almunawwarah.ac.ke', 0, 1, 'C');

    }
    function Footer(){
        $this->SetY(-17);
        // Arial italic 8
        $this->Cell(0, 5, '----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------' ,$border=0,$ln=1,'C',$fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='C');
        $this->SetFont('aefurat','',10);

        $this->Cell(0, 5, 'Printed on: '.date("F j, Y, g:i a").' ~ By: '.$_SESSION["alogin"].' ( Examination Officer )' ,$border=0,$ln=0,'L',$fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='C');
        // $this->Cell(0, 5, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0,0, 'C');
    }
}