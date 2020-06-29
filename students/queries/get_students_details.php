<?php require_once('../../config/config.php');

$sid = $_GET['sid'];

$query = "SELECT StudentName, c.ClassName, st.name, Status, RollId, RegDate, DOB, Gender,TIMESTAMPDIFF(YEAR, DOB, CURDATE()) AS age
          FROM tblstudents s JOIN tblclasses c ON s.ClassId = c.id JOIN stream st 
          ON c.stream_id = st.stream_id
          WHERE StudentId =:sid";
$sql = $dbh->prepare($query);
$sql->bindParam(":sid", $sid, PDO::PARAM_STR);

$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_OBJ);

echo json_encode($result);

