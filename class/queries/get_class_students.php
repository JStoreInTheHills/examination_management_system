<?php

include '../../config/config.php';

    $class_id = $_GET['class_id'];
    $status = 1; 

    $sql = "SELECT FirstName,OtherNames,LastName,RollId,RegDate,Gender,Status,StudentId 
            FROM tblstudents 
            WHERE ClassId =:class_id 
            ORDER BY FirstName ASC ";

    $query = $dbh->prepare($sql);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);
//     $query->bindParam(":status", $status, PDO::PARAM_STR);

    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);