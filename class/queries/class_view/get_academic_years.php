<?php
    
    require_once "../../../config/config.php";

    $sql = "SELECT year_id, year_name FROM year ORDER BY year_name DESC";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($results);
?>
