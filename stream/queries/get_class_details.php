<?php require_once("../../config/config.php");

$class_id = $_GET['class_id'];

$query = $dbh->prepare("SELECT * FROM stream WHERE stream_id =:class_id");
$query->bindParam(":class_id", $class_id, PDO::PARAM_STR);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);
