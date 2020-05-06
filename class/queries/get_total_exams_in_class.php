<?php include '../../config/config.php';

$class_id = $_GET['class_id'];

$sql = "SELECT count(*) AS exams FROM class_exams WHERE class_id =:class_id";
$query = $dbh->prepare($sql);
$query->bindParam(':class_id', $class_id, PDO::PARAM_STR);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);