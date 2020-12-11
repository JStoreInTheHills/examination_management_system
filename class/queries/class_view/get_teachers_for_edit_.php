<?php
     
    include '../../../config/config.php';

    $searchTerm = $_POST['searchTerm'];

    if(empty($searchTerm)){
        $sql = "SELECT teacher_id, name 
                FROM tblteachers 
                ORDER BY name ASC";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $sql = "SELECT teacher_id, name 
                FROM tblteachers
                WHERE name LIKE :name
                ORDER BY name ASC";
        $query = $dbh->prepare($sql);
        $query->bindValue(":name", '%'.$searchTerm .'%', PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    $data = array();

    foreach($results as $result){
        $data [] = array(
            "id" => $result['teacher_id'],
            "text" => $result['name'],
        );
    }
    
    echo json_encode($data);
    exit();