<?php

    include '../../config/config.php';

    $class_id = $_GET['class_id'];

    $sql = "SELECT year_name,class_exams.id,exam_name,class_exams.year_id,class_exams.created_at, created_by,class_id, ClassName 
    FROM exam JOIN class_exams ON exam.exam_id = class_exams.exam_id 
    JOIN year ON year.year_id = class_exams.year_id  
    JOIN tblclasses ON class_exams.class_id = tblclasses.id WHERE class_id = :class_id";

    $query = $dbh->prepare($sql);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);

    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);
