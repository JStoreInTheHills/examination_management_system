<?php

    include "../../../../config/config.php";

    $class_id = $_GET['class_id'];


    $query = "SELECT id, ClassName, ClassNameNumeric, name, teacher_id
              FROM tblclasses 
              JOIN tblteachers 
              ON tblteachers.teacher_id = tblclasses.classTeacher
              WHERE id =:class_id";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":class_id", $class_id,PDO::PARAM_STR);
    
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

?>