<?php

    require_once "../../../config/config.php";

    $year_id = $_GET['year_id'];

       $sql = "SELECT term_year_id, name
               FROM term_year
               JOIN term 
               ON term_year.term_id = term.id
               WHERE year_id =:year_id";
               
       $query = $dbh->prepare($sql);
       $query->bindParam(":year_id", $year_id, PDO::PARAM_STR);
       $query->execute();
       $results = $query->fetchAll(PDO::FETCH_OBJ);

       echo json_encode($results);
                                                    
?>