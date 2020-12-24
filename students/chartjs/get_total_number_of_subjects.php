<?php 

    include "../../config/config.php";

    $class_id = $_GET['cid'];

    $query = "SELECT COUNT(id) subjects 
              FROM tblsubjectcombination 
              WHERE ClassId=:class_id";

    $sql = $dbh->prepare($query);
    $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
    $sql->execute();
    $result = $sql->fetchColumn();

    echo json_encode($result);
    exit();

?>