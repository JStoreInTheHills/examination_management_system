<?php 
    include "../../config/config.php";

    $students_id = $_GET['sid'];
    $class_exam_id = $_GET['ceid'];

    $query = "SELECT SUM(marks) marks 
              FROM result 
              WHERE students_id=:students_id
              AND class_exam_id =:class_exam_id";
    
    $sql = $dbh->prepare($query);   
    
    $sql->bindParam(":students_id", $students_id, PDO::PARAM_STR);
    $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);

    $sql->execute();
    $result = $sql->fetchColumn();

    echo json_encode($result);
    exit();
