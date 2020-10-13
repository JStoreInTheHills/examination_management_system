<?php
    require_once "../../config/config.php";

    $status = $_POST['status'];
    $class_id = $_POST['class_id'];

    $query = "UPDATE stream SET status =:status WHERE stream_id=:class_id";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":status", $status, PDO::PARAM_STR);
    $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

    $results = $sql->execute();
    $error = $sql->errorInfo();
    $data = array();

    if($results){
        $data['success'] = true;
        $data['message'] = "Updated Successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $error[2];
    }

    echo json_encode($data);

?>