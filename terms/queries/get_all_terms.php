<?php require_once("../../config/config.php");

$sql = "SELECT id, name, created_at, created_by 
        FROM term";
$query = $dbh->prepare($sql);
$query->execute();

$result_set = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result_set);
