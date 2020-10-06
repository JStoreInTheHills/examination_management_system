<?php require_once("../../config/config.php");

$class_id = $_GET['class_id'];

$query = "SELECT COUNT(*) AS students_count 
          FROM tblstudents s 
          JOIN tblclasses c ON s.ClassId = c.id 
          WHERE c.stream_id =:class_id";

$sql = $dbh->prepare($query);
$sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);