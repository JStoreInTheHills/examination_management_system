<?php
    require_once "../../config/config.php";

    $query = "SELECT name, year_name, term_year.year_id, term_year.term_year_id 
              FROM term_year 
              JOIN term 
              ON term_year.term_id = term.id  
              LEFT JOIN year 
              ON year.year_id = term_year.year_id";
    $sql = $dbh->prepare($query);
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);


?>