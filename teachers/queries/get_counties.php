<?php

    include '../../config/config.php';

    $query = $dbh->prepare("SELECT * FROM counties");
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);
    