<?php 

    include '../../config/config.php';

    $sql = "SELECT COUNT(DISTINCT teacher_id) as teachers_id FROM tblteachers";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetchColumn();

    echo json_encode($result);