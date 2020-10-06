<?php

    include "../config/config.php";

    $data = array(); 
    $error = array();

    if(empty($_GET['id']))
        $error['Email'] = 'Email Address cannot be empty';

    if(empty($_GET['password']))
        $error['password'] = 'Password cannot be empty.';

    if(!empty($error)){
        $data['success'] = false;
        $data['message'] = $error;
    }else{

        $id = $_GET['id'];
        $password = $_GET['password'];

        $sql = "";

        $query = $dbh->prepare($sql);

        $query->bindParam(':email', $id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        $hash = $result['Password'];
        
        if (password_verify($password, $hash)) {

            $_SESSION['alogin'] = $id;
            $_SESSION['uuid'] = $result['id'];
            $_SESSION['last_login_timestamp'] = time();

            $data['success'] = true;
            $data['role'] = $result['role_name'];
            $data['message'] = 'Login Success!! Redirecting to Dashboard. Please Wait.';
            
        } else {
            $data['success'] = false;
            $data['message'] = 'User Invalid!! Check the name or If you dont have an account. Register One.';
        }

    }
    echo json_encode($data);
