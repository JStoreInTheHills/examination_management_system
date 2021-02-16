<?php 
    include '../../config/config.php';

    $sql = "SELECT COUNT(DISTINCT StudentId) as students FROM tblstudents"; 

    $query = $dbh->prepare($sql);
    
    $query->execute();
    $result = $query->fetchColumn();

    echo json_encode($result);
