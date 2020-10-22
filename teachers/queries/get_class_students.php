<?php

    include '../../config/config.php';

    $class_id = $_POST['class_id'];

    if(!isset($_POST['searchTerm'])){
        $query = "SELECT StudentId, FirstName, OtherNames,LastName, RollId
                  FROM tblstudents
                  WHERE ClassId =:class_id
                  ORDER BY FirstName ASC";
        
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->execute();
        $studentsList = $sql->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $searchTerm = $_POST['searchTerm'];

        $query = "SELECT StudentId, FirstName, OtherNames, LastName, RollId 
                  FROM tblstudents 
                  WHERE ClassId =:class_id 
                  AND FirstName LIKE :firstname OR RollId LIKE :rollid
                  ORDER BY FirstName ASC";
        
        $sql = $dbh->prepare($query);
        $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
        $sql->bindValue(':firstname', '%'.$searchTerm.'%', PDO::PARAM_STR);
        $sql->bindValue(':rollid', '%'. $searchTerm. '%', PDO::PARAM_STR);
        $sql->execute();
        $studentsList = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $data = array();

    foreach ($studentsList as $students) {
        $data[] = array(
            "id" => $students['StudentId'],
            "text" => $students['FirstName'] . " " . $students['OtherNames'] . " " . $students['LastName'] . " (" . $students['RollId'] . " )",
        );
    }
    echo json_encode($data);

    exit();