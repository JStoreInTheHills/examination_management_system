<?php  

    include "../../config/config.php";

    $subject_id = $_GET['subject_id'];
    $teachers_id = $_GET['teacher_id'];
    $class_id = $_GET['class_id'];

    $query  = "SELECT SubjectName, tblsubjectcombination.CreationDate, tblsubjectcombination.status
               FROM tblsubjectcombination 
               LEFT JOIN tblsubjects 
               ON tblsubjectcombination.SubjectId = tblsubjects.subject_id
               WHERE teachers_id =:teachers_id 
               AND ClassId =:class_id 
               AND id =:subject_id";
        
$sql = $dbh->prepare($query);

$sql->bindParam(":teachers_id", $teachers_id, PDO::PARAM_STR);
$sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);
$sql->bindParam(":subject_id", $subject_id, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);
exit();