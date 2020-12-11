<?php require_once "../../../config/config.php";

$class_id = $_GET['class_id'];

$query = " SELECT  ClassName,ClassNameNumeric, stream.name as sname,
           tblclasses.stream_id, CreationDate, tblteachers.name as tname, classTeacher, tblteachers.teacher_id
            FROM  tblclasses 
            LEFT JOIN tblteachers 
            ON tblclasses.classTeacher = tblteachers.teacher_id
            JOIN stream ON tblclasses.stream_id = stream.stream_id
            WHERE tblclasses.id=:class_id";

$sql = $dbh->prepare($query);

$sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

$sql->execute();

$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);
?>