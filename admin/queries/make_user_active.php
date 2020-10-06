<?php include '../../config/config.php';

$user_id = $_GET['user_id'];
$status = $_GET['status'];

$data = array();

if($status == 1){
    $sql = "UPDATE tbl_user SET status = 0 WHERE id =:user_id";
}else{
    $sql = "UPDATE tbl_user SET status = 1 WHERE id =:user_id";
}

$query = $dbh->prepare($sql);

$query->bindParam(':user_id', $user_id, PDO::PARAM_STR);

$result = $query->execute();

$error = $query->errorInfo();

if($result){
    $data['success'] = true;
    if($status == 1){
        $data['message'] = "Updated Successfully! User is Now Inactive";
    }else{
        $data['message'] = "Updated Successfully! User is Now Active";
    }
}else{
    $data['success'] = false;
    $data['message'] = $error[2];  
}

echo json_encode($data);

