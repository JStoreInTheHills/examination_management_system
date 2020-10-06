<?php include "../../config/config.php";

$class_id = $_GET['class_id'];

$query = "SELECT * FROM tblclasses 
          WHERE tblclasses.id =:class_id";

$sql = $dbh->prepare($query);

$sql->bindParam(":class_id", $class_id,PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);


?>