<?php include "../../config/config.php";

$query = "SELECT subject_id,SubjectName,SubjectCode 
          FROM tblsubjects 
          ORDER BY SubjectName DESC";

$sql = $dbh->prepare($query);

$sql->execute();

$result = $sql->fetchAll(PDO::PARAM_STR);

echo json_encode($result);

?>