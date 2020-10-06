<?php

    include '../../config/config.php';
    
    $sql = "SELECT name,teacher_id,id_no,gender,tbl_user.email,phone 
            FROM tblteachers 
            JOIN tbl_user 
            ON tbl_user.id = tblteachers.user_id";

    $query = $dbh->prepare($sql);
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);