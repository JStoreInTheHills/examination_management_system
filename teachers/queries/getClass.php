<?php include "../../config/config.php";

$query = "SELECT id, ClassName, ClassNameNumeric 
          FROM tblclasses 
          ORDER BY ClassName ASC";

$sql = $dbh->prepare($query);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);