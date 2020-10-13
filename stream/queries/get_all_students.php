<?php include "../../config/config.php";

$class_id = $_GET['class_id'];

$sql = "SELECT StudentId, FirstName, OtherNames, LastName, RollId,RegDate,DOB, tblstudents.Status
        FROM tblclasses JOIN tblstudents 
        ON tblclasses.id = tblstudents.ClassId 
        JOIN stream ON stream.stream_id = tblclasses.stream_id 
        WHERE stream.stream_id =:class_id";

$query = $dbh->prepare($sql);
$query->bindParam(":class_id", $class_id, PDO::PARAM_STR);

$query->execute();

$results = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($results);
