<?php require_once("../../config/config.php");

$subjectId = $_GET['subjectId'];
$classId = $_GET['class_id'];

$data = array();

$query = "DELETE FROM tblsubjectcombination 
          WHERE id=:subjectId AND ClassId =:classId";

$sql = $dbh->prepare($query);

$sql->bindParam(":subjectId", $subjectId, PDO::PARAM_STR);
$sql->bindParam(":classId", $classId, PDO::PARAM_STR);

$result = $sql->execute();

$error = $sql->errorInfo();


if($result){    
    $data['success'] = true;
    $data['message'] = "Subject Deleted Successfully";
}else{
    $data['success'] = false;
    $data['message'] = $error[2];
}

echo json_encode($data);