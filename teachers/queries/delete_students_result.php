<?php
    
    require_once("../../config/config.php");

    $result_id = $_POST['result_id'];

    $data = array();

    $query = "DELETE FROM result WHERE result_id =:result_id";

    $sql = $dbh->prepare($query);
    $sql->bindParam(":result_id", $result_id, PDO::PARAM_STR);
    
    $result = $sql->execute();
    $err = $sql->errorInfo();

    if($result){
        $data['success'] = true;
        $data['message'] = "Deleted Successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $err[2];
    }
    echo json_encode($data);
?>