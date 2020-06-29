<?php

    include "../../config/config.php";
    
        $sql = "SELECT name, stream_id, created_at,
                (SELECT COUNT(DISTINCT id)FROM tblclasses 
                WHERE stream_id = s.stream_id)AS number_of_classes 
                FROM stream s";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        echo json_encode($result);