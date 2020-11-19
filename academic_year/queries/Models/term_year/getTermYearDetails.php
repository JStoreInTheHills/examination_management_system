<?php

    include "../../../../config/config.php";

    $term_id = $_GET['term_id'];
    $year_id = $_GET['year_id'];
    $data = array();

    $query = "SELECT ty.year_id, year_name, term.name, ty.term_year_id
              FROM term_year ty 
              LEFT JOIN year 
              ON ty.year_id = year.year_id
              LEFT JOIN term 
              ON term.id = ty.term_id
              WHERE ty.term_year_id =:term_id
              AND ty.year_id=:year_id";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":term_id", $term_id,PDO::PARAM_STR);
    $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
    
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

?>