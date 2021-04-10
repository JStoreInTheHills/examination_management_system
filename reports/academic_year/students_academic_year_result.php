<?php

    session_start();
    // this is the report card for the students. 
    // It holds the students exam performance. 
    // We check the config file which holds the database configuration settings.
    try{

        if(file_exists('../../reports/templates/tcpdf_template.php')){
            require_once('../../reports/templates/tcpdf_template.php'); // Include the template file
        }else{
            throw new Exception("Error Processing Request. File Template not Found", 1);
        }

        if(file_exists('../../config/config.php')){
            include '../../config/config.php'; // Include the Database Config File. 
        }else{
            throw new Exception("Error Processing Request. Database File not Found", 1);
        }
        
        if(file_exists('../../utils/functions/getClassTeacher.php')){
            include ('../../utils/functions/getClassTeacher.php'); // Include the template file
        }else{
            throw new Exception("Get Class Teacher file not found. Try again", 1);
        }

        if(file_exists('./module/get_position_of_student.php')){
            include ('./module/get_position_of_student.php'); // Include the template file
        }else{
            throw new Exception("reports/class/module/term/getStudentTermResult file not found. Try again", 1);
        }

        if(file_exists('../../reports/class/module/term/getStudentTermResult.php')){
            include ('../../reports/class/module/term/getStudentTermResult.php'); // Include the template file
        }else{
            throw new Exception("reports/class/module/term/getStudentTermResult file not found. Try again", 1);
        }

    }catch(Exception $e){
        echo 'Exception Caught ',  $e->getMessage() , "\n";
    }
     
    // ----------------------------------------------------------------------------------------------------------------------
    $student_id =$_GET['sid']; // variable holding the students id. 
    $class_id = $_GET['cid']; // variable holding the class id of the student.
    $year_id = $_GET['year_id'];
    // $sum_of_total = getTotalSumOfStudentForTheExam($student_id, $class_id, $year_id, $term_id);
    // ----------------------------------------------------------------------------------------------------------------------

    $subjectName = getSubjectNames($class_id);
    $arr = getStudentsDetails($student_id); // array holding the students details.

    // //Array holding the exams for that term. 
    // $exams = getExamsForThatTerm($term_id, $year_id, $class_id); 

    $terms = getTermsForTheYearClass($year_id);

    // $students_result = checkIfTheStudentSatForAllSubjectsBetweenTheExams($student_id, $term_id, $year_id);
  
    $width_cell = array(50,20,60,40,15,8,30,25,10,54,24,22,9,45, 51);

    $nameOfTerm = getTerms($class_id);

    $number_count_of_subjects = getNumberOfSubjectsForTheExam($class_id);

    // $marks_for_subjects = getStudentsMarksForRespectiveSubjects($year_id, $term_id, $student_id);

    // $totalSubjectPerformance = getTotalSumOfTermSubjectPerformance($term_id, $year_id, $student_id);

    $stream_id = getClassStreamId($class_id);

    $percentage = getPercentageYearPerformance(getTotalSumOfStudentForTheYear($student_id, $class_id, $year_id), getTotalMarksProposedForTheYear($number_count_of_subjects));

    // ------------------------------------------------------------------------------------------------------------------------
    $second_term_marks = getSubjectMarksFortheYear($student_id, $year_id);
    $firts_term_marks = getSubjectMarksFortheSecondTermYear($student_id, $year_id);
    $end_year = getTotalMarksForEachSubject($student_id, $year_id);
    // ------------------------------------------------------------------------------------------------------------------------

    $totalSumOfSubjects = getTotalSumOfStudentForTheYear($student_id, $class_id, $year_id);

    $totalProposedMarks = getTotalMarksProposedForTheYear($number_count_of_subjects);

    // --------------------------------------------------------------------------------------------------------------------------

    $students_overall_performance = getStudentOverallMarks($stream_id, $year_id, $student_id);
    $total_number_of_students_sat_for_exam_in_class = getNumberOfStudentsSatForTheExams($class_id, $year_id);

    $totla_number_of_students_sat_for_stream = getNumberOfStudentsForStreamSatForExam($year_id, $stream_id);
        
    // Add page and utf-8 and pdf-page-orientation. 
    try{
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetTitle("End Year || " . $arr[0]['firstname'] . " ". $arr[0]['second_name'] . " ". $arr[0]['last_name']);
        $pdf->SetSubject("students end of semester report");

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(6, 2, 6);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);

        $pdf->setCellHeightRatio(1);
        
        // add a page
        $pdf->AddPage();

        $pdf->Ln(38);
        // Restore RTL direction
        $pdf->setRTL(true);

        $pdf->Rect(5, 39, 200, 255); // Rectangle Around the Page.

        $pdf->SetTextColor(255,255,255);

        $pdf->SetFont('aefurat', '', 25);


        $pdf->SetFont('aefurat', '', 14);
        $pdf->Cell(0, 10, "Student's Examination Report ( For the end of the Academic Year 2020/2021 ) ", 0, 1, 'C', 'B');

        $pdf->SetFont('aefurat', '', 12);

        $pdf->SetTextColor(0,0,0);  
    }catch(Exception $e){
        echo "Uncaught Exception " , $e->getMessage() , "\n";
    }

    //Students Details 
    try{
       
        // set LTR direction for english translation
        $pdf->setRTL(false);

        $pdf->Ln(5);

        $pdf->Cell(75);
        $pdf->Cell(30,2,  $arr[0]['firstname'] . " ". $arr[0]['second_name'] . " ". $arr[0]['last_name'] . " (" . $arr[0]['rollId']. ")", 0, 1,'C', '', false, 'B', 'T');

        $pdf->Cell(165, 0, "Student's Name: _______________________________________________________________ ", 0,0,'',false);
        $pdf->setRTL(true);
        $pdf->Cell(0, 0, ' ‫اسم‬ الطالب‫ / الطالبة‬: ', 0,1, '',false);
       
        $pdf->setRTL(false);
        $pdf->Ln(3);
        $pdf->Cell(75, 0);

        $pdf->Cell(30,2,  $arr[0]['class_name'],  0, 1,'C', '', false, 'C', 'C');
        $pdf->Cell(165, 0, 'Class:__________________________________________________________________________________', 0,0,'',false);
        
        $pdf->setRTL(true);
        $pdf->Cell(0, 0, '‫الفصل‬: ', 0,1, '',false);
        $pdf->setRTL(false);
    
        $pdf->Ln(5);
        $pdf->Cell(110,0, $percentage . "%", 0, 1, 'C', '', false, 'C', 'C');
        $pdf->Cell(100, 0, 'Percentage(%):_______________________________(%) ', 0,0,'',false);
        $pdf->Cell(20, 0, ' النسبة المئوية', 0,0,'',false);
    
        // echo $stream_id;

        if($stream_id == 110 || $stream_id == 109 || $stream_id == 108){
            $pdf->Cell(0, 5, '  Grade:________' .calculateGradeForRaudha($percentage). "______", 0,0,'',false);
        }else{
            $pdf->Cell(0, 5, '  Grade:________' .calculateGrade($percentage). "______", 0,0,'',false);
        }

        $pdf->SetFont('aefurat', '', 12);
        $pdf->setRTL(true);
        $pdf->Cell(0, 5, '  ‫التقدير: ',  0,1,'',false);
        $pdf->setRTL(false);
    
        $pdf->Cell(100, 12, 'Stream Position:  ____' .  getStudentRankForTheYear($student_id, $class_id, $year_id). ' _______Out Of:_______'.$total_number_of_students_sat_for_exam_in_class.' ___ ', 0,0,'',false);
        
        $pdf->Cell(90, 12, '  ‫  __________________'.getStudentRankForTheYear($student_id, $class_id, $year_id).'_______‫من‬ ‫العدد‬:',  0,0,'',false);
      
        $pdf->setRTL(true);
        $pdf->Cell(90, 10, '  ‫ ا‫لترتيب  ‫الصفي‬ ‬',  0,1,'',false);
        $pdf->setRTL(false);
    
        $pdf->Cell(100, 10, 'Overal Position: _____'.$students_overall_performance .'_______ Out Of: _____'.$totla_number_of_students_sat_for_stream.'_____', 0,0,'',false);
        $pdf->Cell(90, 10, '  ‫  _____________'.$students_overall_performance.'____________ ‫من‬ ‫العدد‬:',  0,0,'',false);
      
        $pdf->setRTL(true);
        // $pdf->SetFont('dejavusanscondensed', '', 10);
        $pdf->Cell(90, 10, 'التر تيب العام‫‬',  0,1,'',false);
        $pdf->setRTL(false); 
    }catch(Exception $e){
        echo "Uncaught Exception" , $e->getMessage(), "\n";
    }
    //Students Details

    // ------ Subjects Result Total --------------------------------------------------
    try{
        $pdf->Ln(2);

         $pdf->Cell(42, 10, 'SUBJECTS',1,0,'C');

            for($x=0; $x < count($nameOfTerm); $x++){
                $pdf->Cell(38, 10, $nameOfTerm[$x]['name']. "(50)", 1,0,"C");
            }

        $pdf->Cell(38, 10, "Final Marks (100)", 1,0,"C");
        $pdf->Cell(42, 10, 'SUBJECTS',1,1,'C');
         $count = 1;

          for($x=0; $x < count($subjectName); $x++){

             $pdf->Cell(10, 8, $count,1,0,'C');
             $pdf->Cell(32, 8, $subjectName[$x]['SubjectName'],1,0,'C');
             $pdf->Cell(38, 8, $firts_term_marks[$x]['marks'], 1,0,'C');
             $pdf->Cell(38, 8, $second_term_marks[$x]['marks'], 1,0,'C');
             $pdf->Cell(38, 8, $end_year[$x]['marks'], 1,0,'C');
             $pdf->Cell(32, 8, $subjectName[$x]['SubjectName'],1,0,'C');
             $pdf->Cell(10, 8, $count,1,1,'C');
             $count++;
           }
            
    }catch(Exception $e){
          echo 'Uncaught Exception' , $e->getMessage(), "\n";
    }

    // $pdf->SetXY(200, 200);
    // ------ Subjects Result Total -------------------------------------------------------

    $pdf->Ln(3);

    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 8, 'Total',1,0,'C','B');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($width_cell[11], 8, $totalSumOfSubjects,1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 8, 'Out Of',1,0,'C','B');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($width_cell[11], 8, $totalProposedMarks,1,0,'C');
    $pdf->SetTextColor(255,255,255);

    $pdf->Cell($width_cell[11], 8, '',1,0,'C', 'B');
    $pdf->SetTextColor(0,0,0);

    $pdf->Cell($width_cell[11], 8, $totalProposedMarks,1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 8, 'من ',1,0,'C','B');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($width_cell[11], 8, $totalSumOfSubjects,1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 8, 'المجموع',1,1,'C','B');
    $pdf->SetTextColor(0,0,0);

    $pdf->Ln(3);

    // ----------------------------- Start Of Grade Section ----------------------------------------------------

    if($stream_id == 110 || $stream_id == 109 || $stream_id == 108){
        try{
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(74, 5, 'GRADES', 'LTB',0,'C', 1);
            $pdf->Cell(124, 5,'‫التقد ير ات‬', 'TRB',1,'C', 1);
            $pdf->SetTextColor(0,0,0);
        
            $pdf->Cell($width_cell[12], 5, '1', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, 'Excellent', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '96 - 100', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '‫ممتاز‬', 1, 0, 'C');
            $pdf->Cell($width_cell[12], 5, '١', 1, 1, 'C');
        
            $pdf->Cell($width_cell[12], 5, '2', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, 'Very Good', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '86 - 95', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, ' ‫جيد‬ ‫جدا‬ ', 1, 0, 'C');
            $pdf->Cell($width_cell[12], 5, '٢', 1, 1, 'C');
        
            $pdf->Cell($width_cell[12], 5, '3', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, 'Good', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '70 - 85', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '‫جيد‬', 1, 0, 'C');
            $pdf->Cell($width_cell[12], 5, '٣', 1, 1, 'C');
        
            $pdf->Cell($width_cell[12], 5, '4', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, 'Pass', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '50 - 69', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '‫مقبول‬', 1, 0, 'C');
            $pdf->Cell($width_cell[12], 5, '٤', 1, 1, 'C');
        
        
            $pdf->Cell($width_cell[12], 5, '5', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, 'Fail', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '00 - 49', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '‫راسب‬', 1, 0, 'C');
            $pdf->Cell($width_cell[12], 5, '٥', 1, 1, 'C');
        }catch (Exception $e){
            echo 'Uncaught Exception', $e->getMessage(), "\n";
       }   
    }else{
        try{
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(74, 5, 'GRADES', 'LTB',0,'C', 1);
            $pdf->Cell(124, 5,'‫التقد ير ات‬', 'TRB',1,'C', 1);
            $pdf->SetTextColor(0,0,0);
        
            $pdf->Cell($width_cell[12], 5, '1', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, 'Excellent', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '86 - 100', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '‫ممتاز‬', 1, 0, 'C');
            $pdf->Cell($width_cell[12], 5, '١', 1, 1, 'C');
        
            $pdf->Cell($width_cell[12], 5, '2', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, 'Very Good', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '76 - 85', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, ' ‫جيد‬ ‫جدا‬ ', 1, 0, 'C');
            $pdf->Cell($width_cell[12], 5, '٢', 1, 1, 'C');
        
            $pdf->Cell($width_cell[12], 5, '3', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, 'Good', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '66 - 75', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '‫جيد‬', 1, 0, 'C');
            $pdf->Cell($width_cell[12], 5, '٣', 1, 1, 'C');
        
            $pdf->Cell($width_cell[12], 5, '4', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, 'Pass', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '50 - 65', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '‫مقبول‬', 1, 0, 'C');
            $pdf->Cell($width_cell[12], 5, '٤', 1, 1, 'C');
        
        
            $pdf->Cell($width_cell[12], 5, '5', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, 'Fail', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '00 - 49', 1, 0, 'C');
            $pdf->Cell($width_cell[2], 5, '‫راسب‬', 1, 0, 'C');
            $pdf->Cell($width_cell[12], 5, '٥', 1, 1, 'C');
        }catch (Exception $e){
            echo 'Uncaught Exception', $e->getMessage(), "\n";
       }   
    }
   
    // ---------------------------- End of Grade Section -----------------------------------------------------

    $pdf->Ln(2);

    $pdf->SetXY(200, 238);

    $pdf->Rect(10, 250, 60, 30);
   
    $pdf->Cell(0, 10, "", 0, 1);

    $pdf->SetFont('aefurat', '', 10);

    $pdf->Cell(100);
    $pdf->Cell(85, 0,  getClassTeacher($class_id) , 0, 1);
    $pdf->Cell(95);
    $pdf->Cell(80, 0, '_______________________________:(Class Teacher)', 0, 0);

    if(getClassTeacherGender($class_id) == "Male"){
        $pdf->Cell(5, 5, ' ‫ مشرف الفصل‬ ‫‬', 0, 1);
    }else{
        $pdf->Cell(5, 5, ' ‫ مشرفة الفصل‬ ‫‬', 0, 1);
    }

    $pdf->Ln(1);

    $pdf->Cell(100);
    $pdf->Cell(20, 0,  "Hassan Faraj Awadh" , 0, 1);
    $pdf->Cell(95);
    $pdf->Cell(80, 0, '_________________________________:(Principal)', 0, 0);
    $pdf->Cell(5, 5, '‫المدير‬', 0, 1);
    
    
    $pdf->Cell(27);
    $pdf->Cell(0, 5, '‫الختم ‫الرسمي‬‬');

    //Close and output PDF document
    $pdf->Output($arr[0]['firstname'] . " ". $arr[0]['second_name'] . " ". $arr[0]['last_name'] . " (" . $arr[0]['rollId']. ").pdf", 'I');
