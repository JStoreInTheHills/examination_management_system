<?php
    include "../../config/config.php";

    $query = "SELECT FirstName, OtherNames, LastName, RollId, RegDate, StudentId, Status, ClassName
                FROM tblstudents 
                LEFT JOIN tblclasses 
                ON tblclasses.id = tblstudents.ClassId
                ORDER BY 
                RegDate DESC limit 5";

    $sql = $dbh->prepare($query);
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
?>