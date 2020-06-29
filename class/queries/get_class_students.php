<?php

include '../../config/config.php';

    $class_id = $_GET['class_id'];

    $sql = "SELECT StudentName,RollId,RegDate,Gender,Status,StudentId FROM tblstudents WHERE ClassId =:class_id";

    $query = $dbh->prepare($sql);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_STR);

    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);