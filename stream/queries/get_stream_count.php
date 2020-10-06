<?php require_once("../../config/config.php");

$class_id = $_GET['class_id'];

$sql = "SELECT COUNT(tblclasses.stream_id) AS stream_count 
        FROM tblclasses 
        JOIN stream ON stream.stream_id = tblclasses.stream_id
        WHERE stream.stream_id =:class_id";

$query = $dbh->prepare($sql);

$query->bindParam(":class_id", $class_id, PDO::PARAM_STR);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);