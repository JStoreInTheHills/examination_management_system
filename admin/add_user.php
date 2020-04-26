<?php

include "../config/config.php";


$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data


$full_name = $_POST['full_name'];
$email = $_POST['email'];
$password = md5($_POST['password']);
$updationDate = '1990.09.09';

if (empty($full_name))
    $errors['Full_name'] = 'Full Name is required.';

if (empty($email))
    $errors['email'] = 'Email is required.';

if (empty($password))
    $errors['password'] = 'Password is required.';



// if there are any errors in our errors array, return a success boolean of false
if (!empty($errors)) {

    $data['success'] = false;
    $data['errors'] = $errors;
}else{

    $sql = "INSERT INTO  admin(Username,Password, updationDate, email)
    VALUES(:username,:password,:updationDate,:email)";

    $query = $dbh->prepare($sql);

    $query->bindParam(':username', $full_name, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':updationDate', $updationDate, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);

    $query->execute();

    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        $data['success'] = true;
        $data['message'] = 'User Added Successfully';
    } else {
        $data['success'] = false;
        $data['message'] = 'Class Already Exists!! Check The Name and Try Again!!';

    }

}
echo json_encode($data);
