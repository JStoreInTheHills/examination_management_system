<?php

    require_once "../../config/config.php";

    if(!isset($_GET['searchTerm'])){
        $query = "SELECT year_id, year_name 
                  FROM year WHERE status = 1
                  ORDER BY year_name DESC";
        $sql = $dbh->prepare($query);
        $sql->execute();
        $years = $sql->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $searchTerm = $_GET['searchTerm'];
        $query = "SELECT year_id, year_name 
                  FROM year WHERE year_name 
                  LIKE :year_name AND status = 1
                  ORDER BY year_name DESC";
        $sql = $dbh->prepare($query);
        $sql->bindValue(":year_name", "%".$searchTerm."%", PDO::PARAM_STR);
        $sql->execute();
        $years = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $data = array();

    foreach ($years as $year) {     
        $data [] = array (
            "id" => $year['year_id'],
            "text" => $year['year_name']
        );
    }

    echo json_encode($data);






?>