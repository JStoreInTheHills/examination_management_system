<?php include '../../config/config.php';

$user_id = $_GET['user_id'];

$status = 1;

$sql = "UPDATE admin set status = 1 WHERE id =:user_id";
$query = $dbh->prepare($sql);

$query->bindParam(':user_id', $user_id, PDO::PARAM_STR);

$query->execute();

$data = array();

$data['success'] = true;
$data['message'] = "Updated Successfully! User is Now Active";

echo json_encode($data);

