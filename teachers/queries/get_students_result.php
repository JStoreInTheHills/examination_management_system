<?php   
    include "../../config/config.php";

    $result_id = $_GET['result_id'];
    $students_id = $_GET['students_id'];
    $exam_id = $_GET['exam_id'];

    $query = "SELECT result_id, RollId, students_id, class_exam_id, FirstName, OtherNames, LastName, marks 
              FROM result 
              JOIN tblstudents 
              ON result.students_id = tblstudents.StudentId
              WHERE result.result_id =:result_id
              AND result.students_id =:students_id
              AND class_exam_id =:exam_id";
    
    $sql = $dbh->prepare($query);

    $sql->bindParam(":result_id", $result_id, PDO::PARAM_STR);
    $sql->bindParam(":students_id", $students_id, PDO::PARAM_STR);
    $sql->bindParam(":exam_id", $exam_id, PDO::PARAM_STR);

    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);