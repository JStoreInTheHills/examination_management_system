<?php  include "../../config/config.php";

$teachers_id = $_GET['teachers_id'];

$query = "SELECT SubjectName, SubjectCode, ClassName, ClassNameNumeric, c.id, tc.id as SubjectId
          FROM tblsubjectcombination tc
          JOIN tblsubjects ts 
          ON tc.SubjectId = ts.subject_id 
          JOIN tblclasses c ON c.id = tc.ClassId
          WHERE teachers_id =:teachers_id";

$sql = $dbh->prepare($query);

$sql->bindParam(":teachers_id", $teachers_id, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);

?>