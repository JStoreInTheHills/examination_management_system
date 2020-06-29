<?php require_once '../../config/config.php';

$sql = "SELECT COUNT(teacher_id) as teachers  FROM tblteachers";

$query = $dbh->prepare($sql);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);