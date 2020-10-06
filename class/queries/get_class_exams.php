<?php
    include '../../config/config.php';

    $class_id = $_GET['class_id'];

    $sql = "SELECT year_name, class_exams.id, exam_name, class_exams.year_id,
            class_exams.created_at, class_id,
            class_exams.status, term.name as t_name
            FROM exam 
            JOIN class_exams ON exam.exam_id = class_exams.exam_id 
            JOIN year ON year.year_id = class_exams.year_id  
            JOIN tblclasses ON class_exams.class_id = tblclasses.id 
            LEFT JOIN term_year ON class_exams.term_id = term_year.term_year_id
            LEFT JOIN term ON term.id = term_year.term_id
            WHERE class_id = :class_id";

    $query = $dbh->prepare($sql);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);

    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);
