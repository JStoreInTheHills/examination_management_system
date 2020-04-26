<?php

include '../../config/config.php';

    $exam_id = $_GET['exam_id'];

    $sql = "SELECT * FROM result JOIN class_exams ON class_exams.id = result.class_exam_id 
            WHERE exam_id = :exam_id"

    $query=$dbh->prepare($sql);
    $query->bindParam(':exam_id', $exam_id, PDO::PARAM_STR);

    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);
