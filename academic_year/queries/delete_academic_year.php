<?php include '../../config/config.php';

$year_id = $_POST['year_id'];

$data = array();
$error = array();

$sql = 'DELETE FROM year WHERE year_id=:year_id';
$query=$dbh->prepare($sql);
$query->bindParam(':year_id', $year_id, PDO::PARAM_STR);

$result = $query->execute();

if($result){
    $data['success'] = true;
    $data['message'] = "Academic Year Deleted Successfully";
}else{
    $data['message'] = "Error Caught";
    $data['success'] = false;
}

echo json_encode($data);
