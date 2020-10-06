<?php

// Including the configuration file that will be used here.
include("../../config/config.php");

// Standard Query to select all students in the database.
$getStudentsQuery = "SELECT SubjectNameAr, SubjectName,subject_id,SubjectCode,Creationdate 
                     FROM tblsubjects";

// Prepare query using procedure stataements
$query = $dbh->prepare($getStudentsQuery);
// Execute the prepared statement
$query->execute();

// Fetch all students as Objects.
$results = $query->fetchAll(PDO::FETCH_OBJ);


echo json_encode($results);
