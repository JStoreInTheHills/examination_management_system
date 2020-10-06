<?php require_once "../../../config/config.php";

$class_name = $_POST['edit_class_name'];
$code = $_POST['edit_class_code'];
$stream_id = $_POST['edit_stream'];
$date = $_POST['edit_date'];
$edit_teacher = $_POST['edit_teacher'];
$class_id = $_POST['class_id'];

$data = array();

$query = "UPDATE tblclasses SET ClassName=:class_name, ClassNameNumeric=:code, 
          stream_id=:stream_id, CreationDate=:creationdate, classTeacher=:class_teacher
          WHERE id =:class_id";

$sql = $dbh->prepare($query);

$sql->bindParam(":class_name", $class_name, PDO::PARAM_STR);
$sql->bindParam(":code", $code, PDO::PARAM_STR);
$sql->bindParam(":stream_id", $stream_id, PDO::PARAM_STR);
$sql->bindParam(":creationdate", $date, PDO::PARAM_STR);
$sql->bindParam(":class_teacher", $edit_teacher, PDO::PARAM_STR);
$sql->bindParam(":class_id", $class_id, PDO::PARAM_STR);

$result = $sql->execute();

$errors = $sql->errorInfo();

if($result){
    $data['success'] = true;
    $data['message'] = "Class Changed Successfully";
}else{
    $data['success'] = true;
    $data['message'] = $errors;
}

echo json_encode($data);


?>