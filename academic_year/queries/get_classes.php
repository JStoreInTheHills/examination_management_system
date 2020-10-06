<?php

    include_once "../../config/config.php";

    $query = "SELECT ClassName, ClassNameNumeric, id 
              FROM tblclasses";
    
    $sql = $dbh->prepare($query);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);


?>