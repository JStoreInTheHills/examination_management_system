<?php
    include "../../config/config.php";

    $class_id = $_GET['class_id'];

    $query = "SELECT StudentId, FirstName, RollId, OtherNames, LastName,
             Gender, RegDate,Status 
             FROM result 
             LEFT JOIN tblstudents 
             ON tblstudents.StudentId = result.students_id
             WHERE ClassId =:class_id 
             GROUP BY StudentId";
    
    $sql = $dbh->prepare($query);
    
    $sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

exit();
?>