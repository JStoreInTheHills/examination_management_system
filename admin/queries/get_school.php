<?php

    require_once "../../config/config.php";

    $query = "SELECT school_name FROM school";

    $sql = $dbh->prepare($query);

    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);

?>