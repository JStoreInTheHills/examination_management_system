<?php 
    require_once "../../config/config.php";

    $year_id = $_GET['year_id'];

    $query = "SELECT name, term_year_id FROM `term_year` 
              JOIN term ON term_year.term_id = term.id 
              WHERE year_id =:year_id 
              AND term_year.status = 1";

    $sql = $dbh->prepare($query);

    $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
    
    $sql->execute();

    $result = $sql->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);
    

?>