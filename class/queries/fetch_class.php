<?php 
include '../../config/config.php';

$class_id = $_GET['cid'];

$sql = "SELECT id, ClassName FROM tblclasses WHERE id =:cid";
$query = $dbh->prepare($sql);
$query->bindParam(':cid', $class_id, PDO::PARAM_STR);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);
echo json_encode($result);