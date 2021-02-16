<?php
    include "../../config/config.php";

    $query = "SELECT COUNT(*) male
                FROM tblstudents 
                WHERE Gender = 'Male'";

    $sql = $dbh->prepare($query);
    $sql->execute();

    $result = $sql->fetchColumn();

    echo json_encode($result);

?>