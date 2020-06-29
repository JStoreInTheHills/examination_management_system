<?php


// Including the configuration file that will be used here.
include("../../config/config.php");

// Standard Query to select all students in the database.
$getStudentsQuery = "SELECT s.DOB,s.StudentName,s.RollId,s.RegDate,s.StudentId,s.Status,
                     c.ClassName,s2.name, TIMESTAMPDIFF(YEAR, s.DOB, CURDATE()) AS age
                     FROM tblstudents s JOIN tblclasses c on c.id=s.ClassId 
                     JOIN stream s2 on c.stream_id = s2.stream_id";

// Prepare query using procedure stataements
$query = $dbh->prepare($getStudentsQuery);
// Execute the prepared statement
$query->execute();

// Fetch all students as Objects.
$results = $query->fetchAll(PDO::FETCH_OBJ);


echo json_encode($results);
