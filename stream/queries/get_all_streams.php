<?php

    include "../../config/config.php";
    
        $sql = "SELECT name, stream_id, created_at FROM stream";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        echo json_encode($result);