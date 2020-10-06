<?php require_once("../../config/config.php");

$class_id = $_GET['class_id'];

$sql = "SELECT COUNT(DISTINCT teachers_id) as teacher_count FROM tblsubjectcombination s
        JOIN tblclasses c ON c.id = s.ClassId
        WHERE c.stream_id =:class_id";

$query = $dbh->prepare($sql);
$query->bindParam(":class_id", $class_id, PDO::PARAM_STR);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);


