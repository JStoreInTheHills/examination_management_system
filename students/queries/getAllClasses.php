<?php
      
      include '../../config/config.php';

    if(!isset($_POST['searchTerm'])){
        $query = "SELECT id, ClassName from tblclasses";
        $sql = $dbh->prepare($query);
        $sql->execute();
        $ClassList = $sql->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $searchTerm = $_POST['searchTerm'];

        $query = "SELECT id, ClassName from tblclasses
                  WHERE ClassName LIKE :ClassName";
        
        $sql = $dbh->prepare($query);
        $sql->bindValue(':ClassName', '%'.$searchTerm.'%', PDO::PARAM_STR);
        $sql->execute();
        $ClassList = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $data = array();

    foreach ($ClassList as $Class) {
        $data[] = array(
            "id" => $Class['id'],
            "text" => $Class['ClassName'],
        );
    }
    echo json_encode($data);

 exit();