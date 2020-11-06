<?php

    //start of the session.
    session_start();

    //-----------------------------------------------------------------------------

    // Setting the global variables.
    $class_id = $_GET['cid'];
    $class_exam_id = $_GET['ceid'];
    $class_exam_name; // String to hold the class exam name.

    $width_cell = array(50,20,60,40,15,8,25,26,30, 10, 11);

    $cnt = 1; $grade; $SubjectCounts;

    $subjects_array_ids = array(); // array holding the ids of the Subjects. 

    $subjectMarksArray = array();

    // set some language dependent data:
    $lg = Array(); // Array to point to a reference in memory for the languages.
    $lg['a_meta_charset'] = 'UTF-8';
    $lg['a_meta_dir'] = 'rtl';
    $lg['a_meta_language'] = 'fa';
    $lg['w_page'] = 'page';


    // set the default timezone to Africa/Nairobi. 
    date_default_timezone_set('Africa/Nairobi');

    // Associating every thing and adding configuration files. 
    // Using the TCPDF file package. 
    try{

        if(file_exists('../templates/tcpdf_template.php')){
            require('../../utils/configs/TCPDF-master/tcpdf.php');// Include the template file
        }else{
            throw new Exception("Error Processing Request. File Template not Found", 1);
        }

        if(file_exists('../../config/config.php')){
            include '../../config/config.php'; // Include the Database Config File. 
        }else{
            throw new Exception("Error Processing Request. Database File not Found", 1);
        }

        if(file_exists('./module/getAllSubjectsforClass.php')){
            include './module/getAllSubjectsforClass.php'; // Include the Database Config File. 
        }else{
            throw new Exception("Error Processing Request. getAllSubjectsforClass.php not Found", 1);
        }

        if(file_exists('../../utils/functions/getClassTeacher.php')){
            include '../../utils/functions/getClassTeacher.php'; // Include the Database Config File. 
        }else{
            throw new Exception("Error Processing Request. getClassTeacher.php not Found", 1);
        }
    }catch(Exception $e){
        echo 'Exception Caught ',  $e->getMessage() , "\n";
    }

    $_class_name; 
    $term_name;
    $exam_out_of;

    try{
        $query_to_get_class_details = "SELECT ClassName, exam_name, term.name, exam.exam_out_of
                                    FROM class_exams
                                    JOIN tblclasses ON class_exams.class_id = tblclasses.id 
                                    JOIN exam ON exam.exam_id = class_exams.exam_id
                                    JOIN term_year ON term_year.term_year_id = class_exams.term_id
                                    LEFT JOIN term ON term.id = term_year.term_id
                                    WHERE class_exams.class_id =:id 
                                    AND class_exams.id =:ceid";

        $sql_to_get_class_details = $dbh->prepare($query_to_get_class_details);
        
        $sql_to_get_class_details->bindParam(":id", $class_id,PDO::PARAM_STR);
        $sql_to_get_class_details->bindParam(":ceid", $class_exam_id ,PDO::PARAM_STR);

        $sql_to_get_class_details->execute();
        $results_of_class_details = $sql_to_get_class_details->fetchAll();
        foreach($results_of_class_details as $results_of_class){
            $_class_name = $results_of_class['ClassName'];
            $class_exam_name = $results_of_class['exam_name'];
            $term_name = $results_of_class['name'];
            $exam_out_of = $results_of_class['exam_out_of'];
        }
    }catch(Exception $e){
        echo 'Exception Caught ',  $e->getMessage() , "\n";
    }
    
    try{
        $subject_query = "SELECT DISTINCT sum(marks) AS total_subject_marks, r.subject_id, SubjectName
                        FROM result r JOIN tblsubjectcombination sc 
                        ON r.subject_id = sc.id 
                        JOIN tblsubjects s 
                        ON s.subject_id = sc.SubjectId 
                        WHERE r.class_id =:class_id AND class_exam_id =:class_exam_id
                        GROUP BY r.subject_id 
                        ORDER BY r.subject_id";

        $sql = $dbh->prepare($subject_query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);

        $sql->execute();
        $subject_result = $sql->fetchAll();
    
    }catch(Exception $e){

    }
    try{

        $results = " SELECT RollId, FirstName, OtherNames, LastName,
                    GROUP_CONCAT(subject_id ORDER BY subject_id) AS subjects_,
                    GROUP_CONCAT(marks ORDER BY subject_id) AS mar, SUM(marks) AS m,
                    RANK() OVER(PARTITION BY ClassId, class_exam_id ORDER BY SUM(marks) DESC) AS s
                    FROM result r 
                    JOIN tblstudents s ON  r.students_id = s.StudentId 
                    WHERE s.ClassId =:class_id 
                    AND class_exam_id =:class_exam_id 
                    GROUP BY students_id 
                    ORDER BY m DESC";

                    
        $results_query = $dbh->prepare($results);
        $results_query->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $results_query->bindParam(":class_exam_id",$class_exam_id, PDO::PARAM_STR);
        $results_query->execute();

        $results_ = $results_query->fetchAll();

        
    }catch(Exception $e){
    }

    try{
        $sql = "SELECT subject_id, sum(marks) AS subject_ 
                FROM result 
                WHERE class_id =:class_id 
                AND class_exam_id =:class_exam_id 
                GROUP BY subject_id 
                ORDER BY subject_id";

        $query = $dbh->prepare($sql);
        $query->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $query->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);
        $query->execute();

        $r = $query->fetchAll();

        foreach($r as $r_items){
            array_push($subjectMarksArray, $r_items['subject_']);
        }

    }catch(Exception $e){
    }

    // Add page and utf-8 and pdf-page-orientation. 
    try{
            $pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        
            $pdf->SetTitle( $_class_name .' ~ Exam Report Sheet');
            $pdf->SetSubject("class exam report");

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
            
            // add a page
            $pdf->AddPage();

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Munawara');

            // set some language-dependent strings (optional)
            $pdf->setLanguageArray($lg);

            $pdf->Rect(5, 2.5, 289, 35); // Rectangle Around the Header.


            $pdf->Image('../../src/img/favicon.jpeg', 7,3,35,30);
            
            $pdf->setRTL(false);
            // set font
            $pdf->SetFont('aefurat', '', 29);

            $pdf->Cell(0, 1, '‫المدرسة‬ ‫ا لمنورة الإسلامية‬ ‫‬ ',0,1, 'C');

            // $pdf->SetMargins(5, 3, 5, $keepmargins=true);
            $pdf->SetFont('aefurat', '', 17);
            $pdf->Cell(20);
            $pdf->Cell(0,10,'MADRASATUL MUNAWWARAH AL ISLAMIYYA',$border=0,$ln=1,'C',$fill=false, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
                
            $pdf->SetFont('aefurat', 'B', 12);

            $pdf->Cell(35);
            $pdf->Cell(150,5,'P.O.Box: 98616-80100 Mombasa-Kenya', 0, 0, 'C');
            $pdf->Cell(0,5,'Email: info@almunawwarah.ac.ke', 0, 1, 'C');

            $pdf->Cell(35);
            $pdf->Cell(150,5,'Tel No: 0720 211 495/ 0733 806 604', 0, 0, 'C');
            $pdf->Cell(0,5,'Website : www.almunawwarah.ac.ke',$border=0,$ln=1,'C',$fill=false, $link='/index.php', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
            $pdf->Ln(5);

            // Restore RTL direction
            $pdf->setRTL(false);

            $pdf->SetFillColor(193, 229, 252);

            $pdf->SetFont('aefurat', '', 11);

            $pdf->Cell(0, 8, "STREAM EXAM REPORT SHEET",$border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
            $pdf->Cell(94, 8, "Stream Name: ". $_class_name, $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
            $pdf->Cell(90, 8, "Term Name: ". $term_name, $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
            $pdf->Cell(0, 8, "Exam Name: ". $class_exam_name, $border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');

            $pdf->Cell(94, 8, " Total Number of Results Declared: " .getAllStudentsSatForExam($class_id, $class_exam_id). " " ,$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
            $pdf->Cell(90, 8, "Printed On: " .date("F j, Y, g:i a").  " ",$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
            $pdf->Cell(0, 8, "Exam Out of: ". $exam_out_of, $border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');


            $pdf->Cell(94, 8, "Printed By: ". $_SESSION['alogin']. " ",$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
            $pdf->Cell(90, 8, "Total Number of Subjects: ". getClassSubjectsCount($class_id). " ",$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
            $pdf->Cell(0, 8, "Class Teacher: ". getClassTeacher($class_id). " ",$border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        
            $pdf->Ln(3);

    }catch(Exception $e){
        echo "Uncaught Exception " , $e->getMessage() , "\n";
    }


    // populate the table 
    try{
        $pdf->SetFillColor(193, 229, 252);

        $pdf->SetFont("dejavusanscondensed", "", 10);

        $pdf->Cell($width_cell[5], 7, 'No.', $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='C');
        $pdf->Cell($width_cell[2], 7, 'Student Name',$border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[4], 7, 'Roll-ID',$border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        
        for ($i=0; $i < count($subject_result) ; $i++) { 
            
            $upper_name = $subject_result[$i]['SubjectName'];
            $pdf->Cell($width_cell[4], 7, $upper_name, $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='C');

        }

        $x = $pdf->setX(238);

        $pdf->Cell($width_cell[4], 7, 'Total',$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[4], 7, 'Average',$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[4], 7, 'Out Of',$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[10], 7, 'Grade',$border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        

        $pdf->SetFont("dejavusanscondensed", "", 10);

        $pdf->SetFillColor(235, 236, 236); $fill = false;


        foreach ($results_ as $row) {

    
            $smarks = $row['mar'];
            $integerIDs = explode(',', $smarks);
            asort($integerIDs);

            // ---------------------------------------------------------------------
            $subjects_ = $row['subjects_'];
            $subjectIDs = explode(',', $subjects_);
            asort($subjectIDs);

            $subject_count = count($subjectIDs);

            $average = round($row['m'] / $subject_count, 2);

            $total_subject_marks = $exam_out_of * $subject_count;

            $SubjectPercentage = round(($row['m'] / $total_subject_marks) * 100);
            // ----------------------------------------------------------------------

            $pdf->Cell($width_cell[5], 7, $row['s'], $border=1,$ln=0,'C',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
            $pdf->Cell($width_cell[2], 7, $row['FirstName'] . " " . $row['OtherNames'] . " " . $row['LastName'], $border=1,$ln=0,'L',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
            $pdf->Cell($width_cell[4], 7, $row['RollId'],$border=1,$ln=0,'L',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');

                for($i=0; $i < count(getAllSubjects($class_id)); $i++){
                    if(in_array($subjectIDs[$i], getAllSubjects($class_id))){
                        $pdf->Cell($width_cell[4], 7, $integerIDs[$i] ,$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
                    }else{
                        $pdf->Cell($width_cell[4], 7, "_" ,$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
                    }
                }

            $pdf->setX(238);
        
            $pdf->Cell($width_cell[4], 7, $row['m'], $border=1,$ln=0,'C',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
            $pdf->Cell($width_cell[4], 7, $average , $border=1,$ln=0,'C',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
            $pdf->Cell($width_cell[4], 7, $exam_out_of, $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');

            $SubjectPercentages = round($SubjectPercentage);

                if($SubjectPercentages >= 96){
                    $grade = "EX";
                }elseif ($SubjectPercentages >= 86 && $SubjectPercentages <= 95) {
                    $grade = "VG";
                }elseif($SubjectPercentages >=70 && $SubjectPercentages <= 85 ){
                    $grade = "G";
                }elseif ($SubjectPercentages >= 50 && $SubjectPercentages <= 69) {
                    $grade = "P";
                }else {
                    $grade = "F";
                }

            $pdf->Cell($width_cell[10], 7, $grade   ,$border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');

            $fill = !$fill; $cnt = $cnt + 1;
        }

        // Total Section --------------------------------------------------------------------
        $pdf->Ln(1);
        $pdf->SetFillColor(193, 229, 252);
        $pdf->SetFont('aefurat', '', 11);

        $pdf->Cell(83, 7, "Total / Jumla", $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');

        for($i = 0; $i < count($subject_result); $i++){
                $pdf->Cell($width_cell[4] ,7, $subject_result[$i]['total_subject_marks'], $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        }

        $averages = round((getTotalScoreForClass($class_id, $class_exam_id) / getAllStudentsSatForExam($class_id, $class_exam_id)),2);

        $pdf->setX(238);

        $pdf->Cell($width_cell[4], 7, getTotalScoreForClass($class_id, $class_exam_id), $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[4], 7, "$averages", $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[4], 7, "_", $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');

           
        $pdf->Cell($width_cell[10], 7, calculateGrades($averages), $border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');  

        $pdf->Cell(83, 7, "Mean Score / Average",$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');  

        for($i = 0; $i < count($subjectMarksArray); $i++){

            $avgSubjects  = round($subjectMarksArray[$i] / getAllStudentsSatForExam($class_id, $class_exam_id), 1);

            if($avgSubjects >=96){
                $grading = "A";
            }else if($avgSubjects <= 95 && $avgSubjects >= 86){
                $grading = "B";
            }else if($avgSubjects <= 85 && $avgSubjects >= 70){
                    $grading = "C";
            }else if($avgSubjects <= 69 && $avgSubjects >= 50){
                    $grading = "D";
            }else{
                    $grading = "E";
            }
            $pdf->Cell($width_cell[4] ,7, $avgSubjects , $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        }

        $classMean = round(getTotalScoreForClass($class_id, $class_exam_id) / getAllStudentsSatForExam($class_id, $class_exam_id), 1);
        $pdf->setX(238);
    
        $pdf->Cell($width_cell[4], 7, $classMean ,$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');  

    }catch(Exception $e){
        echo "Uncaught Exception " , $e->getMessage() , "\n";
    }

    // Output everything. 
    $pdf->Output( $_class_name."_".$class_exam_name.'.pdf', 'I');

?>