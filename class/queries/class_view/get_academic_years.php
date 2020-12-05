<?php
    
    require_once "../../../config/config.php";

    if(empty($_POST['searchTerm'])){
        $sql = "SELECT year_id, year_name 
                FROM year 
                ORDER BY year_name DESC";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $year_name = $_POST['searchTerm'];

        $sql = "SELECT year_id, year_name 
                FROM year 
                WHERE year_name 
                LIKE :year_name
                ORDER BY year_name DESC";
        $query = $dbh->prepare($sql);
        $query->bindValue(":year_name", '%'.$year_name.'%', PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    $data = array();

    foreach ($results as $r) {
        $data [] = array (
            "id" => $r['year_id'],
            "text" => $r['year_name'],
        );
    };

    echo json_encode($data);
    exit();

