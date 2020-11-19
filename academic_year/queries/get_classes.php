<?php

    include_once "../../config/config.php";

    $query = "SELECT ClassName, ClassNameNumeric, id, name
              FROM tblclasses 
              LEFT JOIN tblteachers
              ON tblteachers.teacher_id = tblclasses.classTeacher";
    
    $sql = $dbh->prepare($query);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);


?>