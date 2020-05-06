<?php include '../../config/config.php';

$student_id = $_POST['student_id'];

$data = array();

$sql = 'DELETE FROM tblstudents WHERE StudentId =:student_id';
$query = $dbh->prepare($sql);

$query->bindParam(':student_id', $student_id, PDO::PARAM_STR);

$result = $query->execute();

if($result){
    $data['success'] = true;
    $data['message'] =  "Student Deleted Successful";
}else{
    $data['success'] = true;
    $data['message'] = "Error Occured";
}

echo json_encode($data);