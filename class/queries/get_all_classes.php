<?php

include '../../config/config.php';

$sql = "SELECT c.id, ClassName, ClassNameNumeric, CreationDate, s.name, (SELECT COUNT(*) FROM tblstudents WHERE ClassId = c.id) as number_of_students,(SELECT COUNT(*) FROM tblsubjectcombination WHERE ClassId = c.id) as number_of_subjects
          from tblclasses c JOIN stream s on c.stream_id = s.stream_id";

$query = $dbh->prepare($sql);

$query->execute();

$results = $query->fetchAll(PDO::FETCH_OBJ);

echo  json_encode($results);




