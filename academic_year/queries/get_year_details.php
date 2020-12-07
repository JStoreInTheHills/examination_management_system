<?php require_once "../../config/config.php";

$year_id = $_GET['year_id'];

$query = "SELECT year_name, created_at, year_id FROM year WHERE year_id =:year_id";

$sql = $dbh->prepare($query);

$sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);

?>