<?php

include '../../config/config.php';
require_once '../template_report.php';

$sql = "SELECT ClassName, ClassNameNumeric as code, CreationDate, name, (SELECT COUNT(StudentId) 
        FROM tblstudents WHERE ClassId = tblclasses.id) as id  
        FROM tblclasses JOIN stream ON tblclasses.stream_id = stream.stream_id";


$pdf = new PDF();
$pdf->SetTitle('Summary Class Report');

$pdf->AliasNbPages();
$pdf->AddPage('Portrait', 'A4', );

$fill = false;

$cnt = 1;

$pdf->SetFont('Times','',14);
$pdf->SetFillColor(193, 229, 252);
$pdf->Ln(10);

$pdf->Cell(0, 10, 'SUMMARY CLASS REPORT', 1, 1, 'C', 'B', true);
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
    10 #5
);

$pdf->Cell($width_cell[5], 10, '#', 1,0,'C','B');
$pdf->Cell($width_cell[0], 10, 'NAME',1,0,'C' ,'B', true);
$pdf->Cell($width_cell[1], 10, 'CODE',1,0,'C', 'B', true);
$pdf->Cell($width_cell[1], 10, '#ST',1,0,'C', 'B', true);
$pdf->Cell($width_cell[2], 10, 'CREATIONDATE',1,0,'C', 'B', true);
$pdf->Cell($width_cell[4], 10, 'STREAM',1,1,'C', 'B', true);

$pdf->SetFont('Times','',12);
$pdf->SetFillColor(235, 236, 236);

foreach ($dbh->query($sql) as $row) {
    $pdf->Cell($width_cell[5], 10, $cnt, 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[0], 10, $row['ClassName'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 10, $row['code'], 1, 0 , 'C', $fill);
    $pdf->Cell($width_cell[1], 10, $row['id'], 1, 0 , 'C', $fill);
    $pdf->Cell($width_cell[2], 10, $row['CreationDate'], 1, 0 , 'C', $fill);
    $pdf->Cell($width_cell[4], 10, $row['name'], 1, 1 , 'C', $fill);
    $fill = !$fill; $cnt = $cnt + 1; $count = $count + 1;
}

$pdf->Output('I', 'All-Students-'.time(). 'pdf', true);