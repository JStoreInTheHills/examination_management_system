<?php include '../../config/config.php';

$year_name = $_POST['year_name'];

$errors = array();
$data  = array();

if(empty($year_name))
    $errors['Year_Name'] = "Year Name Cannot be Blank";

if(!empty($errors)){
    $data['success'] = false;
    $data['message'] = $errors;
}else{
    $sql = "INSERT INTO year(year_name, created_at)VALUES(:year_name, CURRENT_TIMESTAMP)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':year_name', $year_name, PDO::PARAM_STR);

    $query->execute();
    $er = $query->errorInfo(); //errorInfo returns an array 
    $lastInsertId = $dbh->lastInsertId();

    if($lastInsertId){
        $data['success'] = true;
        $data['message'] = "Academic Year Added Successfully";
    }else{
        $data['success'] = true;
        $data['message'] = $er[2];
    }
}
echo json_encode($data);
