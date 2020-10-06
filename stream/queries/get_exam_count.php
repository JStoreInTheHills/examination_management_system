<?php require_once("../../config/config.php");

$class_id = $_GET['class_id'];

$query = "SELECT COUNT(ce.exam_id) AS exam_count
          FROM class_exams ce 
          JOIN tblclasses c ON c.id = ce.class_id
          JOIN stream s ON s.stream_id = c.stream_id
          WHERE c.stream_id =:stream_id";

$sql = $dbh->prepare($query);
$sql->bindParam(":stream_id", $class_id, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);
