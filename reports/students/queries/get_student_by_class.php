<?php 

include '../../config/config.php';
require_once './queries/template_report.php';

$pdf = new PDF();
$pdf->SetTitle('Summary Class Student');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',14);

$pdf->Output('I', 'All Students.pdf', true);