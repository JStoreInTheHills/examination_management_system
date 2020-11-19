<?php

    include "../../../../config/config.php";

    $class_id = $_GET['class_id'];
    $term_id = $_GET['term_id'];
    $year_id = $_GET['year_id'];

    $query = "SELECT id, exam_name 
              FROM class_exams 
              JOIN exam 
              ON class_exams.exam_id = exam.exam_id 
              WHERE class_id =:class_id
              AND term_id =:term_id 
              AND year_id =:year_id";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":class_id", $class_id,PDO::PARAM_STR);
    $sql->bindParam(":term_id", $term_id,PDO::PARAM_STR);
    $sql->bindParam(":year_id ", $year_id,PDO::PARAM_STR);
    
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

?>