<?php

include ("../../config/config.php");

$errors = array();      // array to hold validation errors
$data = array();      // array to pass back data

$first_name = $_POST['firstname'];
$last_name = $_POST['lastname'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = password_hash(htmlentities($_POST['password']), PASSWORD_DEFAULT);

$status = 1;
$role_id = $_POST['role_id'];

if (empty($first_name))
    $errors['First Name'] = 'First Name is required.';

if (empty($last_name))
    $errors['Last Name'] = 'Last Name is required.';

if (empty($email))
    $errors['Email'] = 'Email is required.';

if (empty($username))
    $errors['User Name'] = 'User Name is required.';

if (empty($password))
    $errors['password'] = 'Password is required.';

// if there are any errors in our errors array, return a success boolean of false
if (!empty($errors)) {

    $data['success'] = false;
    $data['errors'] = $errors;
}else{

    $sql = "INSERT INTO tbl_user(username, firstname, email, lastname, password, created_at, status, role_id)
    VALUES(:username, :first_name, :email, :last_name, :password, CURRENT_TIMESTAMP(), :status, :role_id)";

    $query = $dbh->prepare($sql);

    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $query->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $query->bindParam(':role_id', $role_id, PDO::PARAM_STR);

    $query->execute();
    $er = $query->errorInfo();

    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        $data['success'] = true;
        $data['message'] = 'User Added Successfully';
    } else {
        $data['success'] = false;
        $data['message'] = $er[2];
    }

}
echo json_encode($data);
