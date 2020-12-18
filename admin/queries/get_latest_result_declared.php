<?php
    include "../../config/config.php";

    $query = "SELECT created_at, FirstName, OtherNames, LastName, students_id, ClassName, SubjectName, marks 
              FROM result LEFT JOIN tblstudents ON tblstudents.StudentId = result.students_id 
              LEFT JOIN tblclasses ON tblclasses.id = result.class_id 
              LEFT JOIN tblsubjectcombination ON result.subject_id = tblsubjectcombination.id 
              LEFT JOIN tblsubjects ON tblsubjects.subject_id = tblsubjectcombination.SubjectId 
              ORDER BY created_at DESC LIMIT 5";

    $sql = $dbh->prepare($query);
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
?>