<?php

include '../../config/config.php';

$sql = 'SELECT * FROM exam';
$query = $dbh->prepare($sql);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);