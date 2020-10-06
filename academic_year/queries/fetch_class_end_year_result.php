<?php include '../../config/config.php';

$year_id = $_GET['year_id'];

$sql = "SELECT id, ClassName, ClassNameNumeric,s.name,
          ( SELECT sum(marks) FROM result JOIN class_exams 
           ON result.class_exam_id = class_exams.id 
                WHERE result.class_id = id AND year_id =:year_id
                  ) AS class_result
         FROM tblclasses AS c, stream AS s 
        WHERE c.stream_id = s.stream_id";

$query = $dbh->prepare($sql);

$query->bindParam(":year_id", $year_id, PDO::PARAM_STR);

$query->execute();
$result = $query->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);