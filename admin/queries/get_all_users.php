<?php include '../../config/config.php';

$sql = "SELECT * FROM tbl_user JOIN roles on roles.role_id = tbl_user.role_id";
$query = $dbh->prepare($sql);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);