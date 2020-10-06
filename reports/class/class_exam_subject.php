<?php

//start of the session.
session_start();

// set the default timezone to Africa/Nairobi. 
date_default_timezone_set('Africa/Nairobi');

$class_id = $_GET['cid'];
$ceid = $_GET['ceid'];
$class_name = "";

$class_exam_name = "";

$students_who_sat_for_the_exam = 0;
$class_total_students_count = 0; 

$width_cell = array(50,20,60,40,15,8,25,26,30, 65, 125);

try{
    if(file_exists('../templates/tcpdf_template.php')){
        require('../../utils/configs/TCPDF-master/tcpdf.php');// Include the template file
    }else{
        throw new Exception("Error Processing Request. File Template not Found", 1);
    }

    if(file_exists('../../config/config.php')){
        require_once( '../../config/config.php'); // Include the Database Config File. 
    }else{
        throw new Exception("Error Processing Request. Database File not Found", 1);
    }

}catch (Exception $e){
    echo  "Uncaught Exception ",  $e->getMessage() , "\n"; 
}


try{
    $get_class_name = "SELECT exam_name, ClassName FROM class_exams ce
                       JOIN tblclasses c ON c.id = ce.class_id 
                       JOIN exam e ON e.exam_id = ce.exam_id
                       WHERE c.id =:class_id and ce.id =:class_exam_id";

    $get_class_name_sql = $dbh->prepare($get_class_name);
    $get_class_name_sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
    $get_class_name_sql->bindParam(":class_exam_id", $ceid, PDO::PARAM_STR);
    
    $get_class_name_sql->execute();
    $get_class_name_result = $get_class_name_sql->fetchAll();

    foreach($get_class_name_result as $class_name_item){
        $class_name = $class_name_item["ClassName"];
        $class_exam_name = $class_name_item['exam_name'];
    }


}catch(Exception $e){
    echo  "Uncaught Exception ",  $e->getMessage() , "\n";
}

try{

    $get_subject_performance = "SELECT RANK () OVER(partition by(class_Exam_id)order by sum(marks) desc)r, 
                                result.subject_id, SubjectName, SubjectCode, tblteachers.name,
                                SUM(marks) AS marks, 
                                GROUP_CONCAT(result.subject_id) AS concat
                                FROM result 
                                JOIN tblsubjectcombination c ON c.id = result.subject_id 
                                JOIN tblsubjects t ON c.SubjectId = t.subject_id JOIN tblteachers
                                ON tblteachers.teacher_id = c.teachers_id
                                WHERE class_id = :class_id AND class_exam_id =:class_exam_id 
                                GROUP BY result.subject_id ORDER BY marks DESC";

    $get_subject_performance_query = $dbh->prepare($get_subject_performance);
    $get_subject_performance_query->bindParam(":class_id", $class_id, PDO::PARAM_STR);
    $get_subject_performance_query->bindParam(":class_exam_id", $ceid, PDO::PARAM_STR);

    $get_subject_performance_query->execute();

    $get_subject_performance_query_result = $get_subject_performance_query->fetchAll();

}catch(Exception $e){

}

try{
    $sql_for_total_students = "SELECT COUNT(DISTINCT students_id) AS exam_sat_count,
                                (SELECT COUNT(DISTINCT StudentId)
                                FROM tblstudents WHERE ClassId =:class_id AND Status = 1) AS class_total_students_count
                                FROM result WHERE class_id =:class_id AND 
                                class_exam_id =:class_exam_id";
    
    $sql_for_total_students_query = $dbh->prepare($sql_for_total_students);
    
    $sql_for_total_students_query->bindParam(":class_id", $class_id, PDO::PARAM_STR);
    $sql_for_total_students_query->bindParam(":class_exam_id", $ceid, PDO::PARAM_STR);

    $sql_for_total_students_query->execute();

    $sql_for_total_students_query_result  = $sql_for_total_students_query->fetchAll();

    foreach($sql_for_total_students_query_result as $sql_for_total_students_query_result_item){
        $students_who_sat_for_the_exam = $sql_for_total_students_query_result_item['exam_sat_count'];
        $class_total_students_count = $sql_for_total_students_query_result_item['class_total_students_count'];
    }

}catch(Exception $e){

}

try{
    $pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetTitle( $class_name .' ~ Stream Subject Report Sheet');
    $pdf->SetSubject("class subject exam report");

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(5, 3, 3, $keepmargins=true);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(true);

    // set font
    $pdf->SetFont('dejavusans', '', 12);
    $pdf->setCellHeightRatio(1);
    $pdf->AddPage();



    $pdf->Rect(5, 2.5, 289, 35); // Rectangle Around the Header.


        $pdf->Image('../../img/favicon.jpeg', 7,3,35,30);
        
        $pdf->setRTL(false);
    
        // set font
        $pdf->SetFont('aefurat', '', 29);

        $pdf->Cell(0, 1, '‫المدرسة‬ ‫ا لمنورة الإسلامية‬ ‫‬ ',0,1, 'C');

        // $pdf->SetMargins(5, 3, 5, $keepmargins=true);
        $pdf->SetFont('aefurat', '', 17);
        $pdf->Cell(20);
    
        $pdf->Cell(0,10,'AL-MADRASATUL MUNAWWARAH AL-ISLAMIYA',$border=0,$ln=1,'C',$fill=false, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
            
        $pdf->SetFont('aefurat', '', 12);

        $pdf->Cell(35);
        $pdf->Cell(150,5,'P.O.Box: 98616-80100 Mombasa-Kenya', 0, 0, 'C');
        $pdf->Cell(0,5,'Email: info@almunawwarah.ac.ke', 0, 1, 'C');

        $pdf->Cell(35);
        $pdf->Cell(150,5,'Tel No: 0720 211 495/ 0733 806 60', 0, 0, 'C');
        $pdf->Cell(0,5,'Website : www.almunawwarah.ac.ke',$border=0,$ln=1,'C',$fill=false, $link='/index.php', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Ln(5);

        // Restore RTL direction
        $pdf->setRTL(false);

        $pdf->SetFillColor(193, 229, 252);

        $pdf->SetFont('aefurat', '', 13);

        $pdf->Cell(0, 8, "STREAM SUBJECT EXAM REPORT SHEET",$border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Ln(1);
        $pdf->Cell(94, 8, "Stream Name: ". $class_name, $border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Cell(90, 8, "Class Teacher: Asma Khator " , $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Cell(0, 8, "Exam Name: ". $class_exam_name, $border=1,$ln=1,'R',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');

        $pdf->Cell(94, 8, " Total Number of Subjects:  " ,$border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Cell(90, 8, "Printed On: " .date("F j, Y, g:i a").  " ",$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Cell(0, 8, "Printed By: ". $_SESSION['alogin']. " ",$border=1,$ln=1,'R',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Ln(1);
        $pdf->Cell(0, 8, "Number of Students Result: ". $students_who_sat_for_the_exam. " Out Of " .$class_total_students_count . "",$border=1,$ln=1,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');

       
        $pdf->Ln(1);

}catch(Exception $e){
    echo "Uncaught Exception" , $e->getMessage(), "\n";
}

// populate the table 
try{
    $pdf->SetFillColor(193, 229, 252);

    $pdf->SetFont("dejavusanscondensed", "", 12);

    $pdf->Cell($width_cell[5], 10, '#', $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='C');
    $pdf->Cell($width_cell[2], 10, 'Subject Name',$border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[10], 10, 'Subject Teacher',$border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[7], 10, 'S.Code',$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    
    $pdf->Cell($width_cell[1], 10, 'Total',$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[6], 10, 'Average',$border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    // $pdf->Cell($width_cell[6], 10, 'Grade',$border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    
    $pdf->SetFillColor(235, 236, 236); $fill = false;

    foreach($get_subject_performance_query_result as $row){
        
        $smarks = $row['marks'];
        $subject_name = $row['SubjectName'];
        $teacher_name = $row['name'];
        $rank = $row['r'];
        $cnt = 1;

        $subjects_id = $row['subject_id'];
        // ---------------------------------------------------------------------

        // $integerIDs = explode(',', $smarks);
        // asort($integerIDs);

        // // ---------------------------------------------------------------------
        // $subjectIDs = explode(',', $subjects_);
        // asort($subjects_);

        // $SubjectCounts = (count($subjectIDs) * 100);
        // $SubjectPercentage = round(($row['m'] / $SubjectCounts) * 100);
        // // ----------------------------------------------------------------------

        $pdf->Cell($width_cell[5], 10, $rank, $border=1,$ln=0,'C',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[2], 10, $row['SubjectName'], $border=1,$ln=0,'L',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[10], 10, $row['name'],$border=1,$ln=0,'L',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[7], 10, $row['SubjectCode'], $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[1], 10, $row['marks'], $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');


        $average = round($smarks / $students_who_sat_for_the_exam, 2);

        $pdf->Cell($width_cell[6], 10, $average,$border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');


        $SubjectPercentages = round($average);

            if($SubjectPercentages >= 96){
                $grade = "A";
            }elseif ($SubjectPercentages >= 86 && $SubjectPercentages <= 95) {
                $grade = "B";
            }elseif($SubjectPercentages >=70 && $SubjectPercentages <= 85 ){
                $grade = "C";
            }elseif ($SubjectPercentages >= 50 && $SubjectPercentages <= 69) {
                $grade = "D";
            }else {
                $grade = "E";
            }

        // $pdf->Cell($width_cell[6], 10, $grade ,$border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');

        $fill = !$fill; $cnt = $cnt + 1; $count = $count + 1;
    }

}catch(Exception $e){
    echo "Uncaught Exception " , $e->getMessage() , "\n";
}

$pdf->Output( $class_name."_".$class_exam_name.'.pdf', 'I');