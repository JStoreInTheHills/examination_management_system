<?php

    include "../../config/config.php";

    if(!isset($_POST['searchTerm'])){
        $sql = "SELECT teacher_id, name from tblteachers";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $teachers_name = $_POST['searchTerm'];

        $query = "SELECT teacher_id, name from tblteachers WHERE name LIKE :teachers_name";
        $sql = $dbh->prepare($query);
        $sql->bindValue(":teachers_name", '%'.$teachers_name.'%', PDO::PARAM_STR);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    $data [] = array();

        foreach ($result as $r) {
            $data [] = array (
                "id" => $r['teacher_id'],
                "text" => $r['name']
            );
        };

        echo json_encode($data);
    exit();
?>