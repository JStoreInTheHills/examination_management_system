<?php
    require_once './templates/portrait.php';

    /***
     * Setting the orientation default = portrait.
     * Setting the page unit = mm
     * Setting the page format to A4.
     * Setting the unicode to false.
     * Setting the page encoding to UTF-8 
     * Setting diskcache to false. 
     */

     // bathuche

    // require_once './configs/TCPDF-master/tcpdf.php';
    $pdf = new MyPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    /**
     * Setting document informations.
     */
    $pdf->SetCreator(PDF_CREATOR); //this typically set the creator of the document.
    $pdf->SetAuthor('Salim Juma'); // this defines the author of the document. 
    $pdf->SetTitle('Student Result Card'); // this defines the title of the document.
    $pdf->SetSubject(''); // defines the subject of the document. 

    // Setting margins. 
    $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->setPrintHeader(false);
    // $pdf->setPrintFooter(false);

    // Setting Auto Page Break
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // Setting dependent language string.
    if(@file_exists(dirname(__FILE__).'/lang/eng.php')){
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    $pdf->SetFont('times', '', 12, '', true);

    $pdf->AddPage();

    // set some text to print
    $txt = <<<EOD
    EOD;

    // print a block of text using Write()
    $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

    $pdf->Output('report2.pdf', 'I');