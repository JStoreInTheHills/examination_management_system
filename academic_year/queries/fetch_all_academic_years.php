<?php 

include '../../config/config.php';

$sql = "SELECT y.year_id, year_name, count(y.year_id) term_count, y.status, y.created_at
        FROM year y 
        LEFT JOIN term_year ty 
        ON y.year_id = ty.year_id 
        GROUP BY y.year_id";
        
$query = $dbh->prepare($sql);

$query->execute();
$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);
?>