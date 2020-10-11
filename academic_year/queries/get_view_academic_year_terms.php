<?php include "../../config/config.php";

$year_id = $_GET['year_id'];

$query = "SELECT ty.term_year_id, t.name, ty.created_at, tbl_user.username as created_by, ty.status
          FROM term_year ty 
          JOIN term t ON t.id = ty.term_id
          LEFT JOIN tbl_user ON tbl_user.id = ty.created_by
          WHERE year_id=:year_id";


$sql = $dbh->prepare($query);

$sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);

?>