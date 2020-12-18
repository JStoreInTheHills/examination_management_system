<?php
    include "../../config/config.php";

    $query = "SELECT COUNT(*) male
                FROM tblstudents 
                WHERE Gender = 'Male'";

    $sql = $dbh->prepare($query);
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

?>