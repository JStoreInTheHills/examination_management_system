<?php include "../../config/config.php";

    $year_id = $_POST['year_id'];
    $status = $_POST['status'];

    $data = array();

    $sql = "UPDATE year SET status=:status 
            WHERE year_id =:year_id";

    $query = $dbh->prepare($sql);
    
    $query->bindParam(":status", $status, PDO::PARAM_STR);
    $query->bindParam(":year_id", $year_id, PDO::PARAM_STR);

    $result = $query->execute();

    $err = $query->errorInfo();

    if($result){
        $data['success'] = true;
        $data['message'] = "Updated Successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $err;
    }

    echo json_encode($data);


?>