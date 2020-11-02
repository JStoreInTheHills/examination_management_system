<?php

    include "../../config/config.php";

    $student_id =$_POST['student_id'];
    $status = $_POST['status'];

    $query = "UPDATE tblstudents SET status=:status
              WHERE StudentId=:students_id";
    
    $data = array();

    $sql = $dbh->prepare($query);
    $sql->bindParam(":status", $status, PDO::PARAM_STR);
    $sql->bindParam(":students_id", $student_id, PDO::PARAM_STR);

    $sql->execute();
    $sqlerror = $sql->errorInfo();

    $lastInsertId = $dbh->lastInsertId();

        $data["success"] = "true";
        $data["message"] = "Updated Successfully.";


echo json_encode($data);

?>