<?php
    require_once "../../../config/config.php";

    $class_exam_id = $_GET['class_exam_id'];

    $query = "SELECT exam_out_of 
              FROM exam 
              JOIN class_exams 
              ON exam.exam_id = class_exams.exam_id 
              WHERE id = :class_exam_id";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);

    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);
    
?>