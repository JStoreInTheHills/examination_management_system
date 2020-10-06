<?php require_once("../../config/config.php");

session_start();

$term_name = $_POST['term_name'];

$errors = array();
$data = array();

if(empty($term_name)){
    $errors['Term'] = "Term Name cannot be NULL";
}

if(!empty($errors)){
    $data['success'] = false;
    $data['message'] = $errors;
}
else {
    $user = $_SESSION['alogin'];

    $sql = "INSERT INTO `term`(`name`, `created_at`, `created_by`) 
            VALUES (:term_name, CURRENT_TIMESTAMP, :user)";

    $query = $dbh->prepare($sql);
    $query->bindParam(":term_name", $term_name, PDO::PARAM_STR);
    $query->bindParam(":user", $user, PDO::PARAM_STR);

    $query->execute();

    $er = $query->errorInfo();

    $lastInsertId = $dbh->lastInsertId();

    if($lastInsertId){
        $data['success'] = true;
        $data['message'] = "Term Added Successfully";
    }else{
        $data['success'] = false;
        $data['message'] = $er[2];
    }
}

echo json_encode($data);
