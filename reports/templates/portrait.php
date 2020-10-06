<?php
    require_once('../configs/TCPDF-master/tcpdf.php');

    class MyPdf extends TCPDF{
        
        public function Header(){
            // $this->Rect(5, 5, 200, 33); // Rectangle Around the page.
           
            $this->Image('../../img/favicon.jpeg', 7,6,35,30);
            $this->SetFont('Times', 'BU', 15);
            $this->Cell(70);
            $this->Cell(70,10,'ALMADRASATUL MUNAWWARAH AL ISLAMIYA',0,1,'C');
            // $this->Ln(20);
            $this->SetFont('Times', 'B', 12);
            $this->Cell(150,5,'P.O.Box: 98616-80100 Mombasa-Kenya', 0, 0, 'C');
            $this->Cell(-1,5,'Email: info@almunawwarah.ac.ke', 0, 1, 'C');
    
            $this->Cell(140,5,'Tel No: 0720 211 495/ 0733 806 60', 0, 0, 'C');
            $this->Cell(-1,5,'Website : www.almunawwarah.ac.ke', 0, 1, 'C');
    
        }

        public function Footer(){

            $this->SetY(-15);
            $this->SetFont('times', "I", 8);
            $this->Cell(0, 10, "Page" . $this->getAliasNumPage(). "/" . $this->getAliasNbPages(), 0, false, "C", 0, "", 0, false, "T", "M");

        }
    }