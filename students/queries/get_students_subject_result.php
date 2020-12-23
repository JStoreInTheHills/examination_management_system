<?php

    include "../../config/config.php";

    $students_id = $_GET['stdid'];
    $class_exam_id = $_GET['ceid'];
    $class_id = $_GET['cid'];

    $query = "SELECT name, SubjectName, marks 
             FROM result r
             JOIN tblsubjectcombination tsc ON r.subject_id = tsc.id 
             JOIN tblsubjects t ON t.subject_id = tsc.SubjectId 
             JOIN tblteachers te ON te.teacher_id = tsc.teachers_id 
             WHERE r.students_id =:students_id
             AND class_exam_id =:class_exam_id
             AND r.class_id =:class_id";
    
    $sql = $dbh->prepare($query);

    $sql->bindParam(":students_id", $students_id, PDO::PARAM_STR);
    $sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);
    $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);






?>