<?php 
/**
 * This is the main student report card. 
 * All functions in this file are for the pdf generation 
 */

 /**
  *  Check if a file exists and then require it. 
  *  z
   */
 
try{
    if(file_exists('../template_report.php')){
        require_once '../template_report.php'; // Include the template file
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

$student_id =$_GET['sid'];
$class_id = $_GET['cid'];
$class_exam_id = $_GET['ceid'];


try{

    $sql = "SELECT StudentName, ClassName FROM tblstudents s JOIN tblclasses c ON s.ClassId = c.id WHERE s.StudentId =:student_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
    
    $query->execute();
    $results = $query->fetchAll();

    if($query->rowCount() > 0){
      foreach($results as $result){
          $student_name = ($result['StudentName']);
      }
    }else{
        throw new Exception("Data Fields Empty. ", 1);
    }
    
}catch(Exception $e){
    echo 'Uncaught Exception', $e->getMessage(), "\n";
}

$pdf = new PDF();
$pdf->SetTitle('Student Examination Report');

$pdf->AliasNbPages();

$pdf->AddPage();

// Automatic Page Break. 
$pdf->setAutoPageBreak(true); 

$width_cell = array(50,20,60,40,15,8,30,25);

$count; 

$pdf->SetFont('Times','B',11);
$pdf->SetFillColor(193, 229, 252);
$pdf->Ln(10);

$pdf->Rect(5, 40, 200, 250); // Rectangle Around the page. 

$pdf->Cell(0, 10, 'Students Examintaion Report (End Term Result)',0 ,1,'C',false);

$pdf->SetFont('Times','',11);

$pdf->Cell(165, 10, 'Students"s Name: ___________________________'. $results[0]['StudentName']  .'______________________ ', 0,0,'',false);
$pdf->Cell(0, 10, 'Student"s Name', 0,1, '',false);

$pdf->Cell(165, 10, 'Class: _________________________'. $results[0]['ClassName']  .'___________________________ :', 0,0,'',false);
$pdf->Cell(0, 10, 'Class', 0,1,'',false);


$pdf->Cell(70, 10, 'Percentage(%): ______________________ :', 0,0,'',false);
$pdf->Cell(0, 10, '(%)Grade: ____________________________________ : Arabic Grade ', 0,1,'',false);

$pdf->Cell(0, 10, 'Strem Position: _________________ Out Of _________________ : Out Of ____________________: Stream Position ', 0,1,'',false);
$pdf->Cell(0, 10, 'Overal Position: _________________ Out Of _________________ : Out Of ____________________: Overal Position ', 0,1,'',false);
$pdf->Ln(2);

$pdf->Cell($width_cell[0], 10, 'SUBJECTS',1,0,'C');
$pdf->Cell($width_cell[6], 10, 'MARKS',1,0,'C');
$pdf->Cell($width_cell[6], 10, 'MIDTERM',1,0,'C');
$pdf->Cell($width_cell[6], 10, 'ENDTERM',1,0,'C');
$pdf->Cell($width_cell[0], 10, 'SUBJECTS',1,1,'C');







$pdf->Ln(65);






$pdf->Cell($width_cell[1], 5, 'Total',1,0,'C','B');
$pdf->Cell($width_cell[1], 5, '400',1,0,'C');
$pdf->Cell($width_cell[1], 5, 'Out Of',1,0,'C','B');
$pdf->Cell($width_cell[1], 5, '600',1,0,'C');
$pdf->Cell($width_cell[6], 5, '',1,0,'C', 'B');
$pdf->Cell($width_cell[1], 5, '600',1,0,'C');
$pdf->Cell($width_cell[1], 5, 'Marks',1,0,'C','B');
$pdf->Cell($width_cell[1], 5, '400',1,0,'C');
$pdf->Cell($width_cell[1], 5, 'Total',1,1,'C','B');

$pdf->Ln(2);

$pdf->Cell(70, 5, 'GRADES', 'LTB',0,'C',);
$pdf->Cell(0, 5, 'GRADES', 'TRB',1,'C');

$pdf->Cell($width_cell[1], 5, '1', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, 'Excellent', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, '96 - 100', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, 'Excellent', 1, 0, 'C');
$pdf->Cell($width_cell[1], 5, '1', 1, 1, 'C');

$pdf->Cell($width_cell[1], 5, '2', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, 'Very Good', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, '86 - 95', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, 'Very Good', 1, 0, 'C');
$pdf->Cell($width_cell[1], 5, '2', 1, 1, 'C');

$pdf->Cell($width_cell[1], 5, '3', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, 'Good', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, '70 - 85', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, 'Good', 1, 0, 'C');
$pdf->Cell($width_cell[1], 5, '3', 1, 1, 'C');

$pdf->Cell($width_cell[1], 5, '4', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, 'Pass', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, '50 - 69', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, 'Pass', 1, 0, 'C');
$pdf->Cell($width_cell[1], 5, '4', 1, 1, 'C');


$pdf->Cell($width_cell[1], 5, '5', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, 'Fail', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, '00 - 49', 1, 0, 'C');
$pdf->Cell($width_cell[0], 5, 'Fail', 1, 0, 'C');
$pdf->Cell($width_cell[1], 5, '5', 1, 1, 'C');

$pdf->Ln(2);

$pdf->Cell(147, 5, 'Class Teacher"s Remarks: ', 0,0);
$pdf->Cell(0, 5, ': Class Teacher"s Remarks', 0, 1);   

$pdf->Cell(0, 10, '__________________________________________________________________________________________________', 0, 1);

$pdf->Rect(10, 250, 60, 30);
$pdf->Cell(10);
$pdf->Cell(20, 10, 'Official Stamp');

$pdf->Ln(2);
$pdf->Cell(70);
$pdf->Cell(0, 10, '___________________________________________________', 0, 1);

$pdf->Cell(70);
$pdf->Cell(0, 10, '______________________________________:(Class Teacher) Class-Teacher', 0, 1);

$pdf->Cell(70);
$pdf->Cell(0, 10, '______________________________________:(Principal) Principal', 0, 1);


$cnt = 1;
$pdf->Output('I', 'All Students.pdf', true);