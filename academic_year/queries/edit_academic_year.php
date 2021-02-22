<?php 

include '../../config/config.php';

$time = "SELECT DATE(NOW())";
$stmt = $dbh->prepare($time);
$stmt->execute();
$time_result = $stmt->fetchColumn();

if($time_result){
    $year_id = $_POST['year_id'];
    $year_name = $_POST['heading'];

    $error = array();
    $data = array();

    if(empty($year_id))
    $error['year_id'] = "Year ID cannot be null";

    if(empty($year_name))
        $error['year_name'] = "Year Name cannot be null";

    if(!empty($error)){
        $data['success'] = false;
        $data['message'] = $error;
    }

    $query = "UPDATE year SET year_name =:year_name, updation_date =:time 
          WHERE year_id =:year_id";

    $sql = $dbh->prepare($query);
    $sql->bindParam(":year_name", $year_name, PDO::PARAM_STR);
    $sql->bindValue(':time', $time_result,  PDO::PARAM_STR);
    $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);

    $flag = $sql->execute();

    $sql_errr = $sql->errorInfo();

    if($flag){
        $data['success'] = true;
        $data['message'] = "Updated successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $sql_errr[2];
    }
    echo json_encode($data);
}else{
    echo json_encode($time_result);
}
    exit();
