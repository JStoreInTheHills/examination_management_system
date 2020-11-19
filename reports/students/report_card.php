<?php

    session_start();
    // this is the report card for the students. 
    // It holds the students exam performance. 
    // We check the config file which holds the database configuration settings.
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
        
        if(file_exists('../../utils/functions/getClassTeacher.php')){
            include ('../../utils/functions/getClassTeacher.php'); // Include the template file
        }else{
            throw new Exception("Get Class Teacher file not found. Try again", 1);
        }
    }catch(Exception $e){
        echo 'Exception Caught ',  $e->getMessage() , "\n";
    }
            
        // GLOBAL VARIABLES --------------------------------------------------------------
        $stream_id; // variable of the stream that the student belongs to. 
      
        $student_id =$_GET['sid']; // variable holding the students id. 
        $class_id = $_GET['cid']; // variable holding the class id of the student.
       
        $class_exam_id = $_GET['ceid']; // variable holding the id of the exam being outputted. 

        $exam_name; // variable holding the name of the exam. 
   
        $year_name; // variable holding the academic year of the exam. 
  
        $exam_id; // variable holding the exam id for the result.

        $className; // variable holding the name of the class. 
  
        $name; 

        // Variable holding the exams out of value

        $exam_out_of_value;

        $sum_of_total =getTotalSumOfStudent($student_id, $class_exam_id, $class_id);

    // Query to fetch the exam of the result card. 
    try{

        $exam_result = getExamDetails($class_exam_id);
     
        foreach($exam_result as $exam_result_item){
            $exam_name = $exam_result_item['exam_name'];
            $name = $exam_result_item['name'];
            $year_name = $exam_result_item['year_name'];
            $exam_id = $exam_result_item['exam_id'];
            $exam_out_of_value = $exam_result_item['exam_out_of'];
        }
        
    }catch(Exception $e){
        echo "Uncaught Exception" , $e->getMessage() , "\n";
    }

    try{

        // ------------------------------------------------------------------------------------------
        $stream_id_query = $dbh->prepare("SELECT stream_id FROM tblclasses WHERE id =:class_id");
        $stream_id_query->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $stream_id_query->execute();

        $stream_result = $stream_id_query->fetchAll();
        foreach($stream_result as $stream_item){
            $stream_id = $stream_item['stream_id'];
        }
        // -------------------------------------------------------------------------------------
        $result_query = "SELECT t.SubjectNamesAr, t.o_r, students_id, 
                                class_exam_id, class_id, t.subject_id, t.subjectNames,
                                t.marks, t.total
                        FROM(
                                SELECT
                                class_exam_id,
                                r.class_id,
                                students_id,
                                stream_id,
                                ce.exam_id,
                                GROUP_CONCAT(r.subject_id) AS subject_id,
                                GROUP_CONCAT(SubjectName) as subjectNames,
                                GROUP_CONCAT(SubjectNameAr) as SubjectNamesAr,
                                GROUP_CONCAT(marks) as marks,
                                SUM(marks) as total,
                                RANK() OVER (PARTITION BY c.stream_id, ce.exam_id ORDER BY SUM(marks) DESC)AS o_r
                                FROM result r 
                                LEFT JOIN tblsubjectcombination ts ON ts.id = r.subject_id 
                                JOIN tblsubjects s ON s.subject_id = ts.SubjectId 
                                JOIN tblclasses c ON c.id = r.class_id 
                                JOIN class_exams ce ON ce.id = r.class_exam_id 
                                GROUP BY students_id, class_exam_id
                                ORDER BY ts.id asc
                                )AS t 
                            WHERE students_id =:students_id 
                            AND class_id=:class_id 
                            AND class_exam_id =:class_exam_id
                            GROUP BY students_id
                            ORDER BY t.subject_id ASC";

        $result_prepare_statement = $dbh->prepare($result_query);
        $result_prepare_statement->bindParam(':students_id',$student_id, PDO::PARAM_STR);
        $result_prepare_statement->bindParam(':class_id',$class_id, PDO::PARAM_STR);
        $result_prepare_statement->bindParam(':class_exam_id',$class_exam_id, PDO::PARAM_STR);

        $result_prepare_statement->execute();

        $result_from_result_table = $result_prepare_statement->fetchAll();

        foreach($result_from_result_table as $result_item){
            
            // Array containing all the subject names. 
            // fetch all the subject names and explode them into an array. 
            $result_subjects_name = $result_item['subjectNames'];
            $subjects_names = explode(',', $result_subjects_name);
            // var_dump($subjects_names);
                     
            $result_subject_marks = $result_item['marks'];
            $marks = explode(',', $result_subject_marks);
            // var_dump($marks);

            $result_subject_id = $result_item['subject_id'];
            $subject_ids = explode(',', $result_subject_id);
            // var_dump($subject_ids);
            $result_total = $result_item['total'];
          

            $o_r = $result_item['o_r'];

            $subject_name_in_ar_array = $result_item['SubjectNamesAr'];
            $subjectAr = explode(',', $subject_name_in_ar_array);
        }

        // ---------------------------------------------------------------------------------------------
        // Overall Position -----------------------------


    }catch(Exception $e){
        echo 'Uncaught Exception', $e->getMessage(), "\n";
    }
    // ------End of Query to fetch students result -------------------------------------------------------

    // Add page and utf-8 and pdf-page-orientation. 
    try{
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetTitle('Student Result Card');
        $pdf->SetSubject("students result card");

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

        // set font
        $pdf->SetFont('dejavusanscondensed', '', 12);

        // $pdf->SetFont('dejavusanscondensed', '', 12);
        $pdf->setCellHeightRatio(1);
        
        // add a page
        $pdf->AddPage();

        // $width =$pdf->getPageHeight();
        $pdf->Ln(38);
        // Restore RTL direction
        $pdf->setRTL(true);

        $pdf->Rect(5, 39, 200, 255); // Rectangle Around the Page.

        $pdf->SetTextColor(255,255,255);

        $pdf->SetFont('aefurat', '', 25);

        $pdf->Cell(0, 10, "كشفا الدر جات لنها ية السنة الدزاسية لعام ", 0, 1, 'C', 'B');

        $pdf->SetFont('aefurat', '', 14);

        $pdf->Cell(0, 10, "Student's Examination Report ( " . $exam_name. " ".  $name . " For Academic Year " . $year_name . " / 2021 )", 0, 1, 'C', 'B');

        $pdf->SetFont('aefurat', '', 12);

        $pdf->SetTextColor(0,0,0);  
    }catch(Exception $e){
        echo "Uncaught Exception " , $e->getMessage() , "\n";
    }

    $arr = getStudentsDetails($student_id);

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
    
        $out_of = getNumberOfSubjects($class_id) * $exam_out_of_value;
        $percentage = number_format((($sum_of_total /$out_of) * 100));
        
        $pdf->Ln(5);
        // $pdf->SetFont('timesI', 'I', 12);
        $pdf->Cell(110,0,  $percentage . "%",  0, 1,'C', '', false, 'C', 'C');
        // $pdf->SetFont('aefurat', '', 12);
        $pdf->Cell(100, 0, 'Percentage(%):_______________________________(%) ', 0,0,'',false);
        $pdf->Cell(20, 0, ' النسبة ‫المئية', 0,0,'',false);
    
        if($stream_id == 108 || $stream_id == 109 || $stream_id == 110){
            $pdf->Cell(0, 5, '  Grade:______ '.getStudentsGradeForRaudhwa($percentage).' _____', 0,0,'',false);
        }else{
        $pdf->Cell(0, 5, '  Grade:______ '.getStudentsGrade($percentage).' _____', 0,0,'',false);
        }

        // $pdf->SetFont('aefurat', '', 12);
        $pdf->setRTL(true);
        $pdf->Cell(0, 5, '  ‫التقدير‬: ',  0,1,'',false);
        $pdf->setRTL(false);
    
        $pdf->Cell(100, 12, 'Stream Position:  ____'. getStudentsPosition($class_id, $class_exam_id, $student_id).' ____  Out Of:   ___ '.getAllStudentsSatForExam($class_id, $class_exam_id).' ___ ', 0,0,'',false);
        
        $pdf->Cell(90, 12, '  ‫  _________________________‫من‬ ‫العدد‬:',  0,0,'',false);
      
        $pdf->setRTL(true);
        $pdf->Cell(90, 10, '  ‫ ا‫لترتيب  ‫الصفي‬ ‬',  0,1,'',false);
        $pdf->setRTL(false);
    
        $pdf->Cell(100, 10, 'Overal Position: ____'. $o_r. '_ Out Of: ___'. getTotalOveralNumberOfStudents($stream_id) .'___', 0,0,'',false);
        $pdf->Cell(90, 10, '  ‫  _________________________‫من‬ ‫العدد‬:',  0,0,'',false);
      
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

        $width_cell = array(50,20,60,40,15,8,30,25,10,54,24,22,9,45);

        $pdf->Cell($width_cell[9], 10, 'SUBJECTS',1,0,'L');
        $pdf->Cell($width_cell[13], 10, ' Marks Obtained',1,0,'C');
        $pdf->Cell($width_cell[13], 10, 'Out of (Marks)',1,0,'C');
        $pdf->Cell($width_cell[9], 10, ' ‫‫المواد الدراسية‬ ‬',1,1,'R');
        $count = 1;
        
        $sub = getSubjectNames($class_id);
        
        for($x=0; $x < count($subjects_names); $x++){
            for($i=0; $i < 1; $i++){
    
                $pdf->Cell(10, 7, $count, 1,0,'C');
                $pdf->Cell(44, 7, $subjects_names[$x],1,0,'L');
                $pdf->Cell($width_cell[13], 7, $marks[$x],1,0,'C');
                $pdf->Cell($width_cell[13], 7, $exam_out_of_value,1,0,'C');
                $pdf->Cell($width_cell[9], 7, $subjectAr[$x], 1,1,'R');
                
                $count++;
            }
        }
    }catch(Exception $e){
        echo 'Uncaught Exception' , $e->getMessage(), "\n";
    }

    // ------ Subjects Result Total -------------------------------------------------------
    $pdf->Ln(3);

    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 8, 'Total',1,0,'C','B');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($width_cell[11], 8, $sum_of_total,1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 8, 'Out Of',1,0,'C','B');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($width_cell[11], 8, getNumberOfSubjects($class_id) * $exam_out_of_value,1,0,'C');
    $pdf->SetTextColor(255,255,255);

    $pdf->Cell($width_cell[11], 8, '',1,0,'C', 'B');
    $pdf->SetTextColor(0,0,0);

    $pdf->Cell($width_cell[11], 8, getNumberOfSubjects($class_id) * $exam_out_of_value,1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 8, 'من ',1,0,'C','B');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($width_cell[11], 8, $sum_of_total,1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 8, 'المجموع',1,1,'C','B');
    $pdf->SetTextColor(0,0,0);

    $pdf->Ln(3);

    // ----------------------------- Start Of Grade Section ----------------------------------------------------

    if($stream_id == 110 || $stream_id == 109 || $stream_id == 108){
        try{
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(74, 5, 'GRADES', 'LTB',0,'C', 1);
            $pdf->Cell(124, 5,'‫التقديرات‬', 'TRB',1,'C', 1);
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
            $pdf->Cell(124, 5,'‫التقديرات‬', 'TRB',1,'C', 1);
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

    $pdf->SetFont('aefurat', '', 11);

    $pdf->Cell(100);
    $pdf->Cell(85, 0,  getClassTeacher($class_id) , 0, 1);
    $pdf->Cell(95);
    $pdf->Cell(80, 0, '_________________________:(Class Teacher)', 0, 0);

    if(getClassTeacherGender($class_id) == "Male"){
        $pdf->Cell(5, 5, ' ‫ مشرف الفصل‬ ‫‬', 0, 1);
    }else{
        $pdf->Cell(5, 5, ' ‫ مشرفة الفصل‬ ‫‬', 0, 1);
    }


    $pdf->Ln(1);

    $pdf->Cell(100);
    $pdf->Cell(20, 0,  "Hassan Faraj Awadh" , 0, 1);
    $pdf->Cell(95);
    $pdf->Cell(80, 0, '__________________________:(Principal)', 0, 0);
    $pdf->Cell(5, 5, '‫المدیر‬', 0, 1);
    
    
    $pdf->Cell(20);
    $pdf->Cell(0, 5, '‫الختم ‫الرسمي‬‬');

    //Close and output PDF document
    $pdf->Output($arr[0]['firstname'] . " ". $arr[0]['second_name'] . " ". $arr[0]['last_name'] . " (" . $arr[0]['rollId']. ").pdf", 'I');
