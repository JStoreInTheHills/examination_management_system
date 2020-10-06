<?php 
include "../../config/config.php";

$query = "SELECT id, firstname, lastname, email 
          FROM tbl_user JOIN roles 
          ON roles.role_id = tbl_user.role_id 
          WHERE roles.role_id != 1 
          AND status = 1";

$sql = $dbh->prepare($query);

$sql->execute();

$result = $sql->fetchAll(PDO::PARAM_STR);

echo json_encode($result);

?>