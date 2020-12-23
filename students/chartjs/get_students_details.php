<?php   
    
    include "../../config/config.php";

    $students_id = $_GET['stdid'];

    $query = "SELECT FirstName, OtherNames, LastName, RollId
              FROM tblstudents 
              WHERE StudentId =:students_id";
    
    $sql = $dbh->prepare($query);

    $sql->bindParam(":students_id", $students_id, PDO::PARAM_STR);
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

?>