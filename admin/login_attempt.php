<?php

    /**
     * Official login page for a user to the system. 
     */

    include "../config/config.php";

    // Array to hold the data 
    $data = array(); 

    // Array to hold the error caught. 
    $error = array();

//    // Check to see if the email input field is empty, if true add item to the
//    // error array.
//    if(empty($_GET['email_address']))
//        $error['Email'] = 'Email Address cannot be empty';
//
//    // Check to see if the password input field is empty, if true add item to the
//    // error array.
//    if(empty($_GET['password']))
//        $error['password'] = 'Password cannot be empty.';
//
//    // Is the error array not empty? Save your result to the data array.
//    if(!empty($error)){
//        $data['success'] = false;
//        $data['message'] = $error;
//
//    // Other wise get the values being passed to the page using the
//    // Asynchronous call and store them in a local variable for execution.
//    }else{

        $email_address = $_POST['email_address'];
        $password = $_POST['password'];

        // Get the id, Password, UserName, role_name of the user trying to login to the
        // System. This data can be useful in the log files. 
        $sql = "SELECT id, password, username, role_name, r.role_id
                FROM tbl_user a 
                JOIN roles r 
                ON r.role_id = a.role_id
                WHERE email=:email 
                AND status = 1";
        
        // Prepare the sql query takes the sql as an argurment. 
        $query = $dbh->prepare($sql);

        // bind the param being passed. 
        $query->bindParam(':email', $email_address, PDO::PARAM_STR);
        
        // Execute the PDO query 
        $query->execute();

        // Fetch the result and place the value on a local variable. 
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $err = $query->errorInfo();

        // Store the results of the password on a local variable. 
        $hash = $result['password'];

        // Verify the password if they match. If true set the GLOBAL sessions 
        // then Update the data array.

        if (password_verify($password, $hash)) {

            session_start(); // start a session
            
            $_SESSION['alogin'] = $result['username'];
            $_SESSION['role_id'] = $result['role_id'];
            $_SESSION['uuid'] = $result['id'];
            $_SESSION['last_login_timestamp'] = time();

            $data['success'] = true;
            $data['role'] = $result['role_name'];
            $data['uuid'] = $result['id'];
            $data['message'] = 'Login Success!! Redirecting to Dashboard.';

        }
        // otherwise update the data array to false and change the message to negative.
        else {
            $data['success'] = false;
            $data['message'] = $err[2];
        }

    // echo out the results of the data array.
 echo json_encode($data);
