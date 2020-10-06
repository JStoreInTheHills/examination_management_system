<?php

session_start();

// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')

try{

        if(file_exists('../templates/tcpdf_template.php')){
            require_once('../templates/tcpdf_template.php'); // Include the template file
        }else{
            throw new Exception("Error Processing Request. File Template not Found", 1);
        }

        if(file_exists('../../config/config.php')){
            include '../../config/config.php'; // Include the Database Config File. 
        }else{
            throw new Exception("Error Processing Request. Database File not Found", 1);
        }
}catch(Exception $e){
        echo 'Exception Caught ',  $e->getMessage() , "\n";
}

// Query to fetch all the students. 
try{
    $sql = "SELECT FirstName, OtherNames, LastName, RegDate, ClassName, RollId, TIMESTAMPDIFF(YEAR, DOB, CURDATE()) AS age 
    FROM tblstudents s JOIN tblclasses c ON s.ClassId = c.id ORDER BY RegDate DESC";

    $query = $dbh->prepare("SELECT COUNT(DISTINCT StudentId) AS StudentCount FROM tblstudents");
    $query->execute();
    $student_count = $query->fetchAll();

}catch(Exception $e){
    echo "Uncaught Exception " , $e->getMessage() , "\n";
}


// Add page and utf-8 and pdf-page-orientation. 
try{
        $pdf = new PDF("PDF_PAGE_ORIENTATION", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    
        $pdf->SetTitle('Student ~ Summary Report');
        $pdf->SetSubject("summary students report");
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, 6, $keepmargins=false);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);

        // set font
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->setCellHeightRatio(1);
        
        // add a page
        $pdf->AddPage();

        $pdf->SetMargins(5, 2, 6);
        // Restore RTL direction
        $pdf->setRTL(false);

        $pdf->Ln(12);
        // set font
        $pdf->SetFillColor(193, 229, 252);

        $pdf->SetFont('aefurat', '', 14);

        $pdf->Cell(0, 8, "SUMMARY STUDENT'S REPORT",$border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->SetFont('aefurat', 'B', 10);
        $pdf->Cell(68, 10, 'Total Number of Students : '. $student_count[0]["StudentCount"] . '  ', $border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='C');
        $pdf->Cell(81, 10, 'Dated :  '.date("F j, Y, g:i a").'', $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='C');

        $pdf->Cell(0, 10, 'Print By: '.$_SESSION["alogin"].'' ,$border=1,$ln=1,'R',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='C');

        
}catch(Exception $e){
        echo "Uncaught Exception " , $e->getMessage() , "\n";
}

// populate the table 
try{
    
    $width_cell = array(50,20,60,40,15,8,25,26,30);

    $pdf->SetFillColor(193, 229, 252);

    // $pdf->Ln(6);

    $pdf->SetFont('aefurat', 'B', 11);
    $pdf->Cell($width_cell[5], 10, '#', $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='C');
    $pdf->Cell($width_cell[2], 10, 'STUDENT NAME',$border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[7], 10, 'REG#',$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[4], 10, 'AGE',$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[3], 10, 'REGDATE',$border=1,$ln=0,'R',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[0], 10, 'CLASS',$border=1,$ln=1,'R',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    
    $pdf->SetFont('aefurat', 'I', 10);
    $pdf->SetFillColor(235, 236, 236);
    $fill = false;

    $cnt = 1;
    foreach ($dbh->query($sql) as $row) {
        $pdf->Cell($width_cell[5], 10, $cnt, $border=1,$ln=0,'C',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[2], 10, $row['FirstName'] ." ". $row['OtherNames'] ." ". $row['LastName'], $border=1,$ln=0,'L',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[7], 10, $row['RollId'],$border=1,$ln=0,'C',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[4], 10, $row['age'], $border=1,$ln=0,'C',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[3], 10, $row['RegDate'], $border=1,$ln=0,'R',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[0], 10, $row['ClassName'], $border=1,$ln=1,'R',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $fill = !$fill; $cnt = $cnt + 1; $count = $count + 1;
    }
}catch(Exception $e){
    echo "Uncaught Exception " , $e->getMessage() , "\n";
}

$pdf->Output('SUMMARY STUDENT REPORT.pdf', 'I');
?>