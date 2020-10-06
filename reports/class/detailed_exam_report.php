<?php

include '../../config/config.php';
require_once '../template_report.php';


$class_name = $_GET['class_name'];

$exam_count;


try{
    
    $sql = "SELECT COUNT(distinct exam_id) AS examCount FROM class_exams 
            JOIN tblclasses ON class_exams.class_id = tblclasses.id WHERE ClassName LIKE :class_name";
    $query = $dbh->prepare($sql);
    $query->bindParam(':class_name', $class_name, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll();

    foreach($result as $row){
        $exam_count = $row[0];
    }

    // throw new Exception('Something Wrong with the SQL');
    
}catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

$pdf = new PDF();
$pdf->SetTitle( $class_name . ' Detailed Class Exam Report');

$pdf->AliasNbPages();
$pdf->AddPage('Landscape', 'A4', );

$fill = false;

$cnt = 1;

$pdf->SetFont('Times','B',14);
$pdf->SetFillColor(193, 229, 252);
$pdf->Ln(10);

$pdf->Cell(0, 10, '   DETAILED CLASS EXAM REPORT', 1, 1, 'C', 'B', true);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(100, 10, '   CLASS : '. $class_name, 1, 0,'','B');
$pdf->Cell(100, 10, 'CODE: '. $class_code, 1, 0, '', 'B');
$pdf->Cell(0,10, 'NUMBER OF EXAMS : ' .$exam_count[0], 1, 1,'', 'B');

$pdf->SetFont('Times','',10);
$pdf->Cell(0, 10, 'Printed at: '.date("F j, Y, g:i a").' ~ By: Salim Juma Silaha ( Examination Officer )', 0, 1);
$pdf->Cell(0, 10, '#ST : Number of Students' );


$pdf->Ln(4);

$pdf->SetFont('Times','B',12);

$pdf->Ln(10);
$width_cell = array(
    50, #0
    20, #1
    60, #2
    50, #3
    30, #4
    10, #5
    40  #6
);






$pdf->Output('I', 'All-Students-'.time(). 'pdf', true);
