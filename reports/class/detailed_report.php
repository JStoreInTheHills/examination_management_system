<?php

include '../../config/config.php';
require_once '../../utils/configs/template_report.php';

$class_name = $_GET['class_name'];
$student_count; 

try{
            $count_sql = "SELECT COUNT(DISTINCT StudentId)as Count 
                    FROM tblstudents s JOIN tblclasses c ON s.ClassId = c.id
                    WHERE ClassName LIKE :class_name";

        $count_query = $dbh->prepare($count_sql);
        $count_query->bindParam(':class_name', $class_name, PDO::PARAM_STR);
        $count_query->execute();
        $count_result = $count_query->fetchAll();

        foreach($count_result as $count_r){
            $student_count = $count_r[0];
        }

}catch(Exception $e){
    echo "Caught Exception: ", $e->getMessage(), "\n";
}

try{
        $sql = "SELECT StudentName, RollId, StudentEmail, RegDate, (CASE WHEN status = 1 THEN 'Active' ELSE 'Inactive' END) as status, Gender, DOB 
                FROM tblstudents JOIN tblclasses ON tblclasses.id = tblstudents.ClassId WHERE ClassName LIKE :class_name";

            $query = $dbh->prepare($sql);
            $query->bindParam(':class_name', $class_name, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetchAll();
}catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

$pdf = new PDF();
$pdf->SetTitle( $class_name . ' Detailed Class Report');

$pdf->AliasNbPages();
$pdf->AddPage('Landscape', 'A4', );

$fill = false;

$cnt = 1;

$pdf->SetFont('Times','B',14);
$pdf->SetFillColor(193, 229, 252);
$pdf->Ln(10);

$pdf->Cell(0, 10, '   DETAILED CLASS REPORT', 1, 1, 'C', 'B', true);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(100, 10, '   CLASS : '. $class_name, 1, 0,'','B');
$pdf->Cell(100, 10, 'CODE: '. $class_code, 1, 0, '', 'B');
$pdf->Cell(0,10, 'NUMBER OF STUDENTS : ' .$student_count[0], 1, 1,'', 'B');

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
    40 #6
);

try{
    $pdf->Cell($width_cell[5], 10, '#', 1,0,'C','B');
    $pdf->Cell($width_cell[0], 10, 'STUDENT NAME',1,0,'C' ,'B', true);
    $pdf->Cell($width_cell[1], 10, 'ROLLID',1,0,'C', 'B', true);
    $pdf->Cell($width_cell[2], 10, 'ADDRESS',1,0,'C', 'B', true);
    $pdf->Cell($width_cell[0], 10, 'REGDATE',1,0,'C', 'B', true);
    $pdf->Cell($width_cell[1], 10, 'STATUS',1,0,'C', 'B', true);
    $pdf->Cell($width_cell[4], 10, 'GENDER',1,0,'C', 'B', true);
    $pdf->Cell($width_cell[6], 10, 'DOB',1,1,'C', 'B', true);

}catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

try{
    $pdf->SetFont('Times','',12);
    $pdf->SetFillColor(235, 236, 236);

    foreach ($result as $row) {
        
        $pdf->Cell($width_cell[5], 10, $cnt, 1, 0, 'C', $fill);
        $pdf->Cell($width_cell[0], 10, $row['StudentName'], 1, 0, 'C', $fill);
        $pdf->Cell($width_cell[1], 10, $row['RollId'], 1, 0 , 'C', $fill);
        $pdf->Cell($width_cell[2], 10, $row['StudentEmail'], 1, 0 , 'C', $fill);
        $pdf->Cell($width_cell[0], 10, $row['RegDate'], 1, 0 , 'C', $fill);
        $pdf->Cell($width_cell[1], 10, $row['status'], 1, 0 , 'C', $fill);
        $pdf->Cell($width_cell[4], 10, $row['Gender'], 1, 0 , 'C', $fill);
        $pdf->Cell($width_cell[6], 10, $row['DOB'], 1, 1 , 'C', $fill);
        $fill = !$fill; $cnt = $cnt + 1; $count = $count + 1;
    }
}catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


$pdf->Output('I', 'All-Students-'.time(). 'pdf', true);