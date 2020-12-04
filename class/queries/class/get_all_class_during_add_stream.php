<?php
    include "../../config/config.php";

    if(!isset($_POST['searchTerm'])){
            $sql = "SELECT stream_id, name FROM stream
                    WHERE status = 1";
            $query = $dbh->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);            
    }else{
        $class_name = $_POST['searchTerm'];

        $query = "SELECT stream_id, name FROM stream WHERE name LIKE :class_name
                  AND status = 1";
         $sql = $dbh->prepare($query);
         $sql->bindValue(":class_name", '%'.$class_name.'%', PDO::PARAM_STR);
         $sql->execute();
         $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    $data [] = array();

    foreach ($result as $r) {
        $data [] = array (
            "id" => $r['stream_id'],
            "text" => $r['name']
        );
    };

    echo json_encode($data);
    exit();

?>