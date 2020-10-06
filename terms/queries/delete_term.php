<?php require_once("../../config/config.php");

$term_id = $_POST['term_id'];
$data = array();

$sql = "DELETE FROM term WHERE id =:term_id";
$query = $dbh->prepare($sql);

$query->bindParam(":term_id", $term_id, PDO::PARAM_STR);
$e = $query->execute();

$error = $query->errorInfo();


if($e){
    $data['success'] = true;
    $data['message'] = "Term Deleted Successfully";
}else{
    $data['success'] = false;
    $data['message'] = $e;
}

echo json_encode($data);