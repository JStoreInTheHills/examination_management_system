<?php 

    include "../../config/config.php";

    $email = $_POST['email_address_auth'];
    $password = $_POST['password_auth'];

    $data = array();
    $error = array();

    if(empty($email))
        $error['email'] = "Email Address cannot be null";
    if(empty($password))
        $error['password'] = "Password cannot be null";

    if(!empty($error)){
        $data['success'] = false;
        $data['message'] = $error;
    }else{
        $query = "SELECT id, password
                  FROM tbl_user 
                  WHERE email =:email 
                  AND role_id = 1";

        $stmt = $dbh->prepare($query);
        
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $err = $stmt->errorInfo();
        $hash = $result['password'];

        if(password_verify($password, $hash)){
            $data['success'] = true;
        }else{
            $data['success'] = false;
            $data['message'] = "You are not eligible to transfer subjects. Contact the Exam Manager.";
        }
    }

    echo json_encode($data);
    exit();


