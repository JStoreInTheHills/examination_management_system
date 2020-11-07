<?php

    include "../../config/config.php";

    $status = $_POST['status'];
    $exam_id = $_POST['exam_id'];

    $query = "UPDATE exam SET closed=:status
             WHERE exam_id=:exam_id";

    $sql = $dbh->prepare($query);
    $sql->bindParam(":status", $status, PDO::PARAM_STR);
    $sql->bindParam(":exam_id", $exam_id, PDO::PARAM_STR);

    $result = $sql->execute();

    $error = $sql->errorInfo();

    $data = array();

    if($result){
        $data['success'] = true;
        $data['message'] = "Updated Successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $error[2];
    }

    echo json_encode($data);

?>