<?php
    require_once "../../config/config.php";

    $year_id = $_GET['year_id'];
    $term_id = $_GET['term_id'];

    $query = "SELECT name, year_name 
              FROM term_year 
              JOIN year ON year.year_id = term_year.year_id
              JOIN term ON term.id = term_year.term_id
              WHERE term_year.year_id =:year_id 
              AND term_year.term_year_id=:term_id";

    $sql_query = $dbh->prepare($query);

    $sql_query->bindParam(":year_id", $year_id, PDO::PARAM_STR);
    $sql_query->bindParam(":term_id", $term_id, PDO::PARAM_STR);

    $sql_query->execute();
    
    $result = $sql_query->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);
?>