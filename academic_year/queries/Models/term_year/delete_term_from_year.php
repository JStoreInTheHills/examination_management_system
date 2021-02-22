<?php

    include "../../../../config/config.php";

    $id = $_POST['id'];

    $error = array();
    $data = array();

    if(empty($id))  
        $error['year_id'] = "Year_id cannot be null";

    if(!empty($error)){
        $data['success'] = false;
        $data['message'] = $error;
    }else{
        $query = "DELETE FROM term_year 
                  WHERE term_year_id=:term_year_id";

        $stmt = $dbh->prepare($query);
        $stmt->bindParam(":term_year_id", $id, PDO::PARAM_STR);
        $result = $stmt->execute();
    
        $sql_error = $stmt->errorInfo();
    
        if($result){
            $data['success'] = true;
            $data['message'] = "Deleted successfully";
        }else{
            $data['success'] = false;
            $data['message'] = $sql_error[2];
        }
    }
    
    echo json_encode($data);
    exit();