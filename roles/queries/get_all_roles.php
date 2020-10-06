<?php include_once "../../config/config.php";

$query = "SELECT role_name, role_id FROM roles";
$sql = $dbh->prepare($query);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);

?>