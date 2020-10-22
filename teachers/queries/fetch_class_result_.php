<?php       
    
    include "../../config/config.php";
    
    $class_id = $_GET['class_id'];
    $subject_id = $_GET['subject_id'];
    $status = 1;

    $query = "SELECT exam.exam_out_of, result.created_at, class_exams.id as exam_id, exam_name, result.subject_id, tblstudents.RollId,result.result_id, students_id, tblstudents.FirstName, tblstudents.OtherNames, tblstudents.LastName, marks 
              FROM `result` 
              JOIN class_exams ON result.class_exam_id = class_exams.id 
              JOIN tblstudents ON tblstudents.StudentId = students_id
              LEFT JOIN exam ON exam.exam_id = class_exams.exam_id
              WHERE result.class_id =:class_id
              AND class_exams.status =:status
              AND subject_id =:subject_id";
    
    $sql = $dbh->prepare($query);

    $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
    $sql->bindParam(":status", $status, PDO::PARAM_STR);
    $sql->bindParam(":subject_id", $subject_id, PDO::PARAM_STR);

    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);


    

