<?php

try{
    if(file_exists('/config/config.php')){
        require('/config/config.php');// Include the template file
    }else{
        throw new Exception("Error Processing Request. Database Connection Failed", 1);
    }

}catch(Exception $e){
   echo 'Exception Caught ',  $e->getMessage() , "\n";
}

function getActiveStudents(){

    $sql = "SELECT COUNT(DISTINCT StudentId) FROM tblstudents WHERE Status =1";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetchAll();

    // return $result;
}
