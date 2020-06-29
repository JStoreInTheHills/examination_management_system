<?php include '../../config/config.php';

$year_name = $_GET['year_name'];

$sql = "SELECT id, ClassName, ClassNameNumeric,s.name,
          ( SELECT sum(marks) FROM result WHERE class_id = id
                  ) AS class_result
         FROM tblclasses AS c, stream AS s 
        WHERE c.stream_id = s.stream_id";

$query = $dbh->prepare($sql);

$query->execute();
$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);