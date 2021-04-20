<?php

    include "../../config/config.php";

    $query = "SELECT year_id, year_name, created_at
              FROM year";
    
    $sql = $dbh->prepare($query);

    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

    exit();