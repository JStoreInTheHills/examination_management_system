<?php 
    include "../../config/config.php";

    $class_id = $_GET['cid'];
    $class_exam_id = $_GET['ceid'];

    $query = "SELECT exam_name, exam_out_of 
              FROM exam 
              JOIN class_exams 
              ON class_exams.exam_id = exam.exam_id 
              WHERE class_id =:class_id 
              AND id =:class_exam_id";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
    $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);

    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
?>  