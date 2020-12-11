<?php

    include '../../../config/config.php';

    $searchTerm = $_POST['searchTerm'];

    if(empty($searchTerm)){
        $sql = "SELECT stream_id, name 
                FROM stream";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $sql = "SELECT stream_id, name 
                FROM stream
                WHERE name 
                LIKE :name";
        $query = $dbh->prepare($sql);
        $query->bindValue(":name", '%'.$searchTerm .'%', PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    $data = array();
    
    foreach ($results as $r) {
        $data[] = array(
            "id" => $r['stream_id'],
            "text" => $r['name']
        );
    }
    echo json_encode($data);
    exit();
?>