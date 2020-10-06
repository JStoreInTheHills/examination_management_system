<?php include '../../config/config.php';

$sql = "SELECT year_id, year_name, created_at 
        FROM year ORDER BY year_name DESC";
$query = $dbh->prepare($sql);

$query->execute();
$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);