<?php

    include '../../config/config.php';
    
    $sql = "SELECT name,teacher_id,id_no,gender,email,phone,SubjectName 
            FROM tblteachers 
            JOIN tblsubjects 
            ON tblteachers.teacher_subject = tblsubjects.subject_id";
    $query = $dbh->prepare($sql);
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);