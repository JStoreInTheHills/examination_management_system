<?php require_once("../../config/config.php");

$studentId  = $_GET['studentId'];

$data = array();

$sql = "DELETE FROM tblstudents WHERE StudentId =:studentId";

$query = $dbh->prepare($sql);
$query->bindParam(':studentId', $studentId, PDO::PARAM_STR);

$error = $query->errorInfo();

$result = $query->execute();

if($result){
    $data['success'] = true;
    $data['message'] = "Student Deleted From Class Successfully";
}else{
    $data['success'] = false;
    $data['message'] = $error[2];
}

echo json_encode($data);


