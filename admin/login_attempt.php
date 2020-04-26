<?php

    include "../config/config.php"; 

    $data = array();
    $error = array();

    if(empty($_POST['email_address']))
        $error['Email'] = 'Email Address cannot be empty';
    
    if(empty($_POST['password']))
        $error['password'] = 'Password cannot be empty.';

    if(!empty($error)){
        $data['success'] = false;
        $data['message'] = $error;
    }else{

        $email_address = $_POST['email_address'];
        $password = md5($_POST['password']);

        $sql = "SELECT * FROM admin WHERE email = :email AND Password = :password";

        $query = $dbh->prepare($sql);
        
        $query->bindParam(':email', $email_address, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() > 0) {
            $data['success'] = true;
            $data['message'] = 'Login Success!! Redirecting to Dashboard. Please Wait.';
        } else {
            $data['success'] = false;
            $data['message'] = 'User Invalid!! Check the name or If you dont have an account. Register One.';
        }

    }
    echo json_encode($data);