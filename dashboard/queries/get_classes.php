<?php 
    include '../../config/config.php';
    $sql = "SELECT COUNT(DISTINCT id) as classes FROM tblclasses"; 
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);
