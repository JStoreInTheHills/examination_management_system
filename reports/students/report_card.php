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
    }catch(Exception $e){
        echo 'Exception Caught ',  $e->getMessage() , "\n";
    }
    // ------------------------------------------------------------------------------
    
   // GLOBAL VARIABLES --------------------------------------------------------------
    $stream_id; // variable of the stream that the student belongs to. 
    
    $student_id =$_GET['sid']; // variable holding the students id. 
    $class_id = $_GET['cid']; // variable holding the class id of the student.
    $class_exam_id = $_GET['ceid']; // variable holding the id of the exam being outputted. 

    $exam_name; // variable holding the name of the exam. 
    $year_name; // variable holding the academic year of the exam. 
    $exam_id; // variable holding the exam id for the result.

    $className; // variable holding the name of the class. 
 
    $students_stream_position;

    $sum_of_total;
    // ------------------------------------------------------------------------------

    // Variable holding the exams out of value

    $exam_out_of_value;

    // Query to fetch the exam of the result card. 
    try{

        $sql = "SELECT exam_name, year_name, class_exams.exam_id, exam_out_of
                FROM exam JOIN class_exams 
                ON exam.exam_id = class_exams.exam_id
                JOIN year ON year.year_id = class_exams.year_id
                WHERE class_exams.id =:class_exam_id";

        $query = $dbh->prepare($sql);
        
        $query->bindParam(':class_exam_id', $class_exam_id, PDO::PARAM_STR);
        $query->execute();

        $exam_result = $query->fetchAll();
     
        foreach($exam_result as $exam_result_item){
            $exam_name = $exam_result_item['exam_name'];
            $year_name = $exam_result_item['year_name'];
            $exam_id = $exam_result_item['exam_id'];
            $exam_out_of_value = $exam_result_item['exam_out_of'];
        }
        
    }catch(Exception $e){
        echo "Uncaught Exception" , $e->getMessage() , "\n";
    }

    // End of Query to get the exam result. 
    
    // Query to get the students personal details. 
    try{

        $sql = "SELECT FirstName, OtherNames, LastName, ClassName, RollId 
                FROM tblstudents s 
                JOIN tblclasses c 
                ON s.ClassId = c.id 
                WHERE s.StudentId =:student_id";

        $query = $dbh->prepare($sql);
        $query->bindParam(':student_id', $student_id, PDO::PARAM_STR);
        
        $query->execute();
        $results = $query->fetchAll();

        if($query->rowCount() > 0){
            foreach($results as $result){
                $student_name = ($result['FirstName']);
                $other_name = ($result['OtherNames']);
                $last_name = ($result['LastName']);
                $className = ($result['ClassName']);
                $rollId = $result['RollId'];
            }
        }else{
            throw new Exception("Data Fields Empty. ", 1);
        }
        
    }catch(Exception $e){
        echo 'Uncaught Exception', $e->getMessage(), "\n";
    }

    // ------ Query to fetch students result -------------------------------------------------------
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
                                t.marks, t.total, t.query 
                        FROM(
                                SELECT class_exam_id, r.class_id, students_id, stream_id, ce.exam_id,
                                GROUP_CONCAT(r.subject_id) AS subject_id,
                                GROUP_CONCAT(SubjectName) as subjectNames,
                                GROUP_CONCAT(SubjectNameAr) as SubjectNamesAr,
                                GROUP_CONCAT(marks) as marks,
                                SUM(marks) as total,
                                RANK() OVER (PARTITION BY c.stream_id, ce.exam_id ORDER BY SUM(marks) DESC)AS o_r,
                                RANK() OVER (PARTITION BY class_exam_id, class_id ORDER BY SUM(marks) DESC) AS query 
                                FROM result r JOIN tblsubjectcombination ts ON ts.id = r.subject_id 
                                JOIN tblsubjects s ON s.subject_id = ts.SubjectId 
                                JOIN tblclasses c ON c.id = r.class_id 
                                JOIN class_exams ce ON ce.id = r.class_exam_id 
                                GROUP BY students_id, class_exam_id
                                )AS t 
                            WHERE students_id =:students_id 
                            AND class_id=:class_id AND class_exam_id =:class_exam_id
                            GROUP BY students_id";

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
                     
            $students_stream_position = $result_item['query'];

            $result_subject_marks = $result_item['marks'];
            $marks = explode(',', $result_subject_marks);
            // var_dump($marks);

            $result_subject_id = $result_item['subject_id'];
            $subject_ids = explode(',', $result_subject_id);
            // var_dump($subject_ids);
            $result_total = $result_item['total'];
            $sum_of_total = $result_total;

            $o_r = $result_item['o_r'];

            $subject_name_in_ar_array = $result_item['SubjectNamesAr'];
            $subjectAr = explode(',', $subject_name_in_ar_array);
        }

        // ---------------------------------------------------------------------------------------
        // Stream Position. -------------------------------------
        
        $query_for_total_number_of_students = "SELECT COUNT(DISTINCT StudentId) AS students_number 
                                               FROM tblstudents WHERE ClassId =:class_id 
                                               AND Status =1";

        $query_rank = $dbh->prepare($query_for_total_number_of_students);
        $query_rank->bindParam(':class_id', $class_id, PDO::PARAM_STR);

        $query_rank->execute();

        $stream_total = $query_rank->fetchAll();

        foreach($stream_total as $stream_total_item){
            $stream_overal_total = $stream_total_item['students_number'];
        }

        // ---------------------------------------------------------------------------------------------
        // Overall Position -----------------------------

        $overal_query = $dbh->prepare("SELECT COUNT(*) as stream_total_item FROM tblstudents s JOIN tblclasses c ON c.id = s.ClassId WHERE c.stream_id =:stream_id AND s.Status = 1");
        $overal_query->bindParam(':stream_id', $stream_id, PDO::PARAM_STR);

        $overal_query->execute();

        $total_overal_students;
        $stream_total = $overal_query->fetchAll();

        foreach($stream_total as $stream_total_item){
            $total_overal_students = $stream_total_item['stream_total_item'];
        }
        // ----------------------------------------------------------------------------------------

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
        // $pdf->Cell($width_cell[1], 5, 'Total',1,0,'C','B');
        $pdf->Cell(0, 10, "STUDENT'S EXAMINATION REPORT CARD ", 0, 1, 'C', 'B');

        $pdf->Cell(100, 10, "Exam: ". $exam_name. " " , 1, 0, 'C', 'B');
        $pdf->Cell(0, 10, "Academic Year: ". $year_name. " " , 1, 1, 'C', 'B');


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
        $pdf->Cell(30,0,  $student_name ." ". $other_name. " " . $last_name. " ~ " .$rollId   , 0, 1,'C', '', false, 'B', 'T');

        $pdf->Cell(165, 0, "Student's Name: ______________________________________________________________ ", 0,0,'',false);
        $pdf->setRTL(true);
        $pdf->Cell(0, 0, ' ‫اسم‬ الطالب‫ / الطالبة‬: ', 0,1, '',false);
       
        $pdf->setRTL(false);
        $pdf->Ln(3);
        $pdf->Cell(75, 0);

        $pdf->Cell(30,0,  $className,  0, 1,'C', '', false, 'C', 'C');
        $pdf->Cell(165, 0, 'Stream:__________________________________________________________________________________', 0,0,'',false);
        
        $pdf->setRTL(true);
        $pdf->Cell(0, 0, '‫الفصل‬: ', 0,1, '',false);
        $pdf->setRTL(false);
    
        $out_of = count($subject_ids) * $exam_out_of_value;
        $percentage =number_format((($sum_of_total /$out_of) * 100), 0);
        
        $pdf->Ln(3);
        // $pdf->SetFont('timesI', 'I', 12);
        $pdf->Cell(110,0,  $percentage ,  0, 1,'C', '', false, 'C', 'C');
        // $pdf->SetFont('aefurat', '', 12);
        $pdf->Cell(100, 0, 'Percentage(%):_______________________________(%) ', 0,0,'',false);
        $pdf->Cell(20, 0, ' النسبة ‫المئویة', 0,0,'',false);
    
        try{
            if($percentage >= 96){
                $grade = "Excellent";
            }elseif ( $percentage >= 86 && $percentage <= 95) {
                $grade = "Very Good";
            }elseif ($percentage >= 70 && $percentage <=85) {
                $grade = "Good";
            }elseif ($percentage >= 50 && $percentage <= 69) {
                $grade = "Pass";
            }else{
                $grade = "Fail";
            }
        }catch(Exception $e){
            echo 'Uncaught Exception' , $e->getMessage() , "\n";
        }
    
        // $pdf->SetFont('timesI', 'I', 12);
        $pdf->Cell(0, 5, '  Grade:______ '.$grade.' _____', 0,0,'',false);
        // $pdf->SetFont('aefurat', '', 12);
        $pdf->setRTL(true);
        $pdf->Cell(0, 5, '  ‫التقدیر‬: ',  0,1,'',false);
        $pdf->setRTL(false);
    
        $pdf->Cell(100, 12, 'Stream Position:  ____'. $students_stream_position.' ____  Out Of:   ___ '.$stream_overal_total.' ___ ', 0,0,'',false);
        
        $pdf->Cell(90, 12, '  ‫  _________________________‫من‬ ‫العدد‬:',  0,0,'',false);
      
        $pdf->setRTL(true);
        $pdf->Cell(90, 10, '  ‫ ا‫لترتیب  ‫الصفي‬ ‬',  0,1,'',false);
        $pdf->setRTL(false);
    
        $pdf->Cell(100, 10, 'Overal Position: ____'. $o_r. '_ Out Of: ___'. $total_overal_students .'___', 0,0,'',false);
        $pdf->Cell(90, 10, '  ‫  _________________________‫من‬ ‫العدد‬:',  0,0,'',false);
      
        $pdf->setRTL(true);
        $pdf->Cell(90, 10, '  ‫ ا‫لترتیب  ‫الصفي‬ ‬',  0,1,'',false);
        $pdf->setRTL(false); 
    }catch(Exception $e){
        echo "Uncaught Exception" , $e->getMessage(), "\n";
    }
    //Students Details

    // ------ Subjects Result Total --------------------------------------------------
    try{

        $pdf->Ln(2);

        $width_cell = array(50,20,60,40,15,8,30,25,10,54,24,22,9,);

        // $pdf->SetMargins(6, 2, 6);
        // $pdf->SetFont('aefurat', 'B', 12);
        $pdf->Cell($width_cell[9], 10, 'SUBJECTS',1,0,'C');
        $pdf->Cell($width_cell[6], 10, ' ‫المجموع ‬(١٠٠)',1,0,'C');
        $pdf->Cell($width_cell[6], 10, '‫  ا‫لفصل‬ الدراسي‬',1,0,'C');
        $pdf->Cell($width_cell[6], 10, ' ‫‫الفصل الدراسي‬ ‬',1,0,'C');
        $pdf->Cell($width_cell[9], 10, ' ‫‫المواد الدراسیة‬ ‬',1,1,'C');
        $count = 1;
        
        
        for($x=0; $x < count($subjects_names); $x++){
            for($i=0; $i < 1; $i++){
    
                $pdf->Cell(10, 7, $count, 1,0,'C');
                $pdf->Cell(44, 7, $subjects_names[$x],1,0,'L');
                $pdf->Cell($width_cell[6], 7, $marks[$x],1,0,'C');
                $pdf->Cell($width_cell[6], 7, $exam_out_of_value,1,0,'C');
                $pdf->Cell($width_cell[6], 7, $exam_out_of_value,1,0,'C');
                $pdf->Cell($width_cell[9], 7, $subjectAr[$x], 1,1,'R');
                
                $count++;
            }
        }
    }catch(Exception $e){
        echo 'Uncaught Exception' , $e->getMessage(), "\n";
    }

    // ------ Subjects Result Total -------------------------------------------------------
    $pdf->Ln(1);

    $subject_count = count($subjects_names);
    $overal_total = $subject_count * $exam_out_of_value;

    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 5, 'Total',1,0,'C','B');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($width_cell[11], 5, $sum_of_total,1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 5, 'Out Of',1,0,'C','B');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($width_cell[11], 5, $overal_total,1,0,'C');
    $pdf->SetTextColor(255,255,255);

    $pdf->Cell($width_cell[11], 5, '',1,0,'C', 'B');
    $pdf->SetTextColor(0,0,0);

    $pdf->Cell($width_cell[11], 5, $overal_total,1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 5, 'من ',1,0,'C','B');
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell($width_cell[11], 5, $sum_of_total,1,0,'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell($width_cell[11], 5, 'المجموع',1,1,'C','B');
    $pdf->SetTextColor(0,0,0);

    $pdf->Ln(1);

    // ----------------------------- Start Of Grade Section ----------------------------------------------------
    try{
        $pdf->Cell(74, 5, 'GRADES', 'LTB',0,'C',);
        $pdf->Cell(124, 5,'‫التقدیرات‬', 'TRB',1,'C');
    
        $pdf->Cell($width_cell[12], 5, '1', 1, 0, 'C');
        $pdf->Cell($width_cell[2], 5, 'Excellent', 1, 0, 'C');
        $pdf->Cell($width_cell[2], 5, '96 - 100', 1, 0, 'C');
        $pdf->Cell($width_cell[2], 5, '‫ممتاز‬', 1, 0, 'C');
        $pdf->Cell($width_cell[12], 5, '١', 1, 1, 'C');
    
        $pdf->Cell($width_cell[12], 5, '2', 1, 0, 'C');
        $pdf->Cell($width_cell[2], 5, 'Very Good', 1, 0, 'C');
        $pdf->Cell($width_cell[2], 5, '86 - 95', 1, 0, 'C');
        $pdf->Cell($width_cell[2], 5, ' ‫جید‬ ‫جدا‬ ', 1, 0, 'C');
        $pdf->Cell($width_cell[12], 5, '٢', 1, 1, 'C');
    
        $pdf->Cell($width_cell[12], 5, '3', 1, 0, 'C');
        $pdf->Cell($width_cell[2], 5, 'Good', 1, 0, 'C');
        $pdf->Cell($width_cell[2], 5, '70 - 85', 1, 0, 'C');
        $pdf->Cell($width_cell[2], 5, '‫جید‬', 1, 0, 'C');
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

    $pdf->Cell(147, 5, 'Class Teacher"s Remarks: ', 0,0);
    $pdf->Cell(0, 5, '‫ ملاحظات ‫مشرف‬ الفصل‬:  ‫‬', 0, 1 );   

    $pdf->Cell(0, 5, '___________________________________________________________________________________________', 0, 1);

    $pdf->Rect(10, 250, 60, 30);
    $pdf->Cell(10);

    // $pdf->Cell(10, 10, 'Official Stamp');
    $pdf->Cell(190, 5, '‫الختم‫الرسمي‬‬');
    $pdf->Ln(1);

    $pdf->Cell(70);
    $pdf->Cell(0, 10, '___________________________________________________', 0, 1);

    $pdf->Cell(70);
    $pdf->Cell(100, 5, '_________________________________:(Class Teacher)', 0, 0);
    $pdf->Cell(0, 5, ' ‫ مشرف الفصل‬ ‫‬', 0, 1);

    $pdf->Cell(70);
    $pdf->Cell(100, 10, '______________________________________:(Principal)', 0, 0);
    $pdf->Cell(0, 10, '‫المدیر‬', 0, 1);

    //Close and output PDF document
    $pdf->Output("SRMSS" .PDF_CREATOR." ", 'I');
