<?php require_once('../../../config/config.php');

$subjects_array_name = array();

$subjects_array_ids = array();

$class_id = 295;

$subject_query = "SELECT DISTINCT sum(marks) AS total_subject_marks, 
r.subject_id, SubjectName, SubjectCode 
FROM result r JOIN tblsubjectcombination sc 
ON r.subject_id = sc.id JOIN tblsubjects s 
ON s.subject_id = sc.SubjectId 
WHERE r.class_id =:class_id GROUP BY r.subject_id
ORDER BY r.subject_id DESC";

$sql = $dbh->prepare($subject_query);
$sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

$sql->execute();
$subject_result = $sql->fetchAll();
foreach($subject_result as $subject_item){
    array_push($subjects_array_name, $subject_item['SubjectName']);
    array_push($subjects_array_ids,  $subject_item['subject_id']);
}

  var_dump($subjects_array_name);
  var_dump($subjects_array_name);