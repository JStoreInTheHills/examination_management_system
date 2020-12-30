<?php 

    include "../../config/config.php";

    $class_id = $_GET['cid'];
    $class_exam_id = $_GET['ceid'];

    $query = "SELECT COUNT(DISTINCT students_id) c 
              FROM result
              WHERE class_id =:cid 
              AND class_exam_id =:ceid";
    
    $sql = $dbh->prepare($query);

    $sql->bindParam(":cid", $class_id, PDO::PARAM_STR);
    $sql->bindParam(":ceid", $class_exam_id, PDO::PARAM_STR);

    $sql->execute();

    $result = $sql->fetchColumn();

    echo json_encode($result);

    exit();




