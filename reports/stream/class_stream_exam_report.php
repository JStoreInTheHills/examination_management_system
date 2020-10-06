<?php

//start of the session.
session_start();

// set the default timezone to Africa/Nairobi. 
date_default_timezone_set('Africa/Nairobi');


$classId = $_GET['class_id'];
$classExamId = $_GET['eid'];


// Associating every thing and adding configuration files. 
// Using the TCPDF file package. 
try{

    if(file_exists('../templates/tcpdf_template.php')){
        require('../../utils/configs/TCPDF-master/tcpdf.php');// Include the template file
    }else{
        throw new Exception("Error Processing Request. File Template not Found", 1);
    }

    if(file_exists('../../config/config.php')){
        include '../../config/config.php'; // Include the Database Config File. 
    }else{
        throw new Exception("Error Processing Request. Database File not Found", 1);
    }
}catch(Exception $e){
    echo 'Exception Caught ',  $e->getMessage() , "\n";
}
