<?php 
    include "../../config/config.php";

    $searchTerm = $_POST['searchTerm'];
  
    if(empty($searchTerm)){
        $query = "SELECT teacher_id, name FROM tblteachers";
        $sql = $dbh->prepare($query);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }else {
        $query = "SELECT teacher_id, name 
                  FROM tblteachers 
                  WHERE name 
                  LIKE :name";

        $sql = $dbh->prepare($query);
        $sql->bindValue(':name', '%'.$searchTerm.'%', PDO::PARAM_STR);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    $data = array();

    foreach ($result as  $teacher) {
        $data[] = array(
            "id" => $teacher['teacher_id'],
            "text" => $teacher['name']
        );
    }

    echo json_encode($data);




    