<?php

    include "../../config/config.php";

    $status = $_POST['status'];
    $term_year_id = $_POST['term_year_id'];

    $data = array();
    
    $query = "UPDATE term_year SET status =:status 
              WHERE term_year_id=:term_year_id";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":status", $status, PDO::PARAM_STR);
    $sql->bindParam(":term_year_id", $term_year_id, PDO::PARAM_STR);

    $result = $sql->execute();
    
    $er = $sql->errorInfo();

    if($result){
        $data['success'] = true;
        $data['message'] = "Updated Successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $er;
    }

    echo json_encode($data);





?>  