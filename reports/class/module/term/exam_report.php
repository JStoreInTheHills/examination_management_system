<?php

    session_start();
    // this is the report card for the students. 
    // It holds the students exam performance. 
    // We check the config file which holds the database configuration settings.
    try{

        if(file_exists('./tcpdf_template.php')){
            require_once('./tcpdf_template.php'); // Include the template file
        }else{
            throw new Exception("Error Processing Request. File Template not Found", 1);
        }

        if(file_exists('../../../../config/config.php')){
            include '../../../../config/config.php'; // Include the Database Config File. 
        }else{
            throw new Exception("Error Processing Request. Database File not Found", 1);
        }
        
        if(file_exists('../../../../utils/functions/getClassTeacher.php')){
            include ('../../../../utils/functions/getClassTeacher.php'); // Include the template file
        }else{
            throw new Exception("Get Class Teacher file not found. Try again", 1);
        }

        if(file_exists('./getStudentTermResult.php')){
            include ('./getStudentTermResult.php'); // Include the template file
        }else{
            throw new Exception("reports/class/module/term/getStudentTermResult file not found. Try again", 1);
        }
    }catch(Exception $e){
        echo 'Exception Caught ',  $e->getMessage() , "\n";
    }
     
        $student_id =$_GET['sid']; // variable holding the students id. 
        $arr = getStudentsDetails($student_id); // array holding the students details.
        $class_id = $_GET['cid']; // variable holding the class id of the student.
        $term_id = $_GET['term_id']; // variable holding the class id of the student.
        $year_id = $_GET['year_id'];
        $sum_of_total = getTotalSumOfStudentForTheExam($student_id, $class_id, $year_id, $term_id);

        $subjectName = getNamesOfSubjectsForTerm($class_id);
        
        //Array holding the exams for that term. 
        $exams = getExamsForThatTerm($term_id, $year_id, $class_id); 

        $students_result = checkIfTheStudentSatForAllSubjectsBetweenTheExams($student_id, $term_id, $year_id);
  
        $width_cell = array(50,20,60,40,15,8,30,25,10,54,24,22,9,45);


        $marks_for_subjects = getStudentsMarksForRespectiveSubjects($year_id, $term_id, $student_id);

        $totalSubjectPerformance = getTotalSumOfTermSubjectPerformance($term_id, $year_id, $student_id);

        $stream_id = getClassStreamId($class_id);
        
    // Add page and utf-8 and pdf-page-orientation. 
    try{
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetTitle('Student End of Semester Report');
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

        $pdf->Cell(0, 10, "كشفا الدر جات لنها ية السنة الدزاسية لعام ", 0, 1, 'C', 'B');

        $pdf->SetFont('aefurat', '', 14);
        $pdf->Cell(0, 10, "Student's Examination Report ( Mid & End 0f 1st Semester for the Academic Year 2020/2021 ) ", 0, 1, 'C', 'B');

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
        $pdf->Cell(110,0, getPercentage($sum_of_total, $class_id) . "%", 0, 1, 'C', '', false, 'C', 'C');
        $pdf->Cell(100, 0, 'Percentage(%):_______________________________(%) ', 0,0,'',false);
        $pdf->Cell(20, 0, ' النسبة ‫المئة ية', 0,0,'',false);
    
        $pdf->Cell(0, 5, '  Grade:________' .caluculateGrade(getPercentage($sum_of_total, $class_id)). "______", 0,0,'',false);

        // $pdf->SetFont('aefurat', '', 12);
        $pdf->setRTL(true);
        $pdf->Cell(0, 5, '  ‫التق ير‬: ',  0,1,'',false);
        $pdf->setRTL(false);
    
        $pdf->Cell(100, 12, 'Stream Position:  ____' . getStudentsRank($year_id, $term_id, $student_id, $class_id). ' _______Out Of:_______'.getNumberOfStudentsSatForTheExam($class_id, $term_id, $year_id).' ___ ', 0,0,'',false);
        
        $pdf->Cell(90, 12, '  ‫  __________________'.getStudentsRank($year_id, $term_id, $student_id, $class_id).'_______‫من‬ ‫العدد‬:',  0,0,'',false);
      
        $pdf->setRTL(true);
        $pdf->Cell(90, 10, '  ‫ ا‫لترتيب  ‫الصفي‬ ‬',  0,1,'',false);
        $pdf->setRTL(false);
    
        $pdf->Cell(100, 10, 'Overal Position: _____'.getOverallStudentsPerformance($stream_id, $term_id, $year_id, $student_id) .'_______ Out Of: ______'.getOveralNumberOfStudentsSatForExam($term_id, $stream_id, $year_id).'___', 0,0,'',false);
        $pdf->Cell(90, 10, '  ‫  _____________'.getOverallStudentsPerformance($stream_id, $term_id, $year_id, $student_id).'____________ ‫من‬ ‫العدد‬:',  0,0,'',false);
      
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

            $pdf->Cell($width_cell[9], 10, 'SUBJECTS',1,0,'C');
            
            $pdf->Cell($width_cell[6], 10, 'الفصل الدر اسي‬',1,0,'C');
            $pdf->Cell($width_cell[6], 10, 'الفصل الدر اسي',1,0,'C');
            $pdf->Cell($width_cell[6], 10, 'المجمؤ (٥٠)',1,0,'C');
            $pdf->Cell($width_cell[9], 10, ' ‫‫المواد الدراسية‬ ‬',1,1,'C');
            $count = 1;

            for($x=0; $x < count($subjectName); $x++){
                $pdf->Cell(10, 8, $count,1,0,'C');
                $pdf->Cell(44, 8, $subjectName[$x]['SubjectName'],1,0,'C');
                $pdf->Cell($width_cell[6], 8, $marks_for_subjects[0][$x], 1,0,'C');
                $pdf->Cell($width_cell[6], 8, $marks_for_subjects[1][$x], 1,0,'C');
                $pdf->Cell($width_cell[6], 8, $totalSubjectPerformance[$x]['marks'], 1,0,'C');
                $pdf->Cell(44, 8, $subjectName[$x]['SubjectName'],1,0,'C');
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
    $pdf->Cell($width_cell[11], 8, $sum_of_total,1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 8, 'Out Of',1,0,'C','B');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($width_cell[11], 8, getTotalMarksProposed(getNumberOfSubjects($class_id)),1,0,'C');
    $pdf->SetTextColor(255,255,255);

    $pdf->Cell($width_cell[11], 8, '',1,0,'C', 'B');
    $pdf->SetTextColor(0,0,0);

    $pdf->Cell($width_cell[11], 8, getTotalMarksProposed(getNumberOfSubjects($class_id)),1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 8, 'من ',1,0,'C','B');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($width_cell[11], 8, $sum_of_total,1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 8, 'المجموع',1,1,'C','B');
    $pdf->SetTextColor(0,0,0);

    $pdf->Ln(3);

    // ----------------------------- Start Of Grade Section ----------------------------------------------------

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
