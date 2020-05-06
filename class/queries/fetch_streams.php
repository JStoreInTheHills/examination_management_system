<?php include '../../config/config.php';

$sql = 'SELECT stream_id, name FROM stream';

$query = $dbh->prepare($sql);
$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);