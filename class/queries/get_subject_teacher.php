<?php 

    include '../../config/config.php';

    $teacher_subject = $_GET['subject_id'];

    $sql = "SELECT * FROM tblteachers WHERE teacher_subject =:teacher_subject";
    $query = $dbh->prepare($sql);

    $query->bindParam(':teacher_subject', $teacher_subject, PDO::PARAM_STR);

    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);