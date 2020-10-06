<?php require_once('../../config/config.php');

$class_exam_id = $_GET['class_exam_id'];
$class_id = $_GET['class_id'];
$status = $_GET['status'];

$data = array();

$query = "UPDATE class_exams SET status =:status 
          WHERE class_id =:class_id AND id =:class_exam_id";

$sql = $dbh->prepare($query);
$sql->bindParam(":status", $status, PDO::PARAM_STR);
$sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
$sql->bindParam(":class_exam_id", $class_exam_id, PDO::PARAM_STR);

$sql->execute();
$sqlerror = $sql->errorInfo();

$lastInsertId = $dbh->lastInsertId();

  $data["success"] = "true";
  $data["message"] = "Updated Successfully.";


echo json_encode($data);

