<?php 

    include '../../config/config.php';

    $start = $_GET['start'];
    $end = $_GET['end'];

    $query = "SELECT COUNT(DISTINCT StudentId) 
              FROM tblstudents 
              WHERE YEAR(`RegDate`) 
              BETWEEN :start 
              AND :end";
    
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(":start", $start, PDO::PARAM_STR);
    $stmt->bindParam(":end", $end, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    echo json_encode($result);
