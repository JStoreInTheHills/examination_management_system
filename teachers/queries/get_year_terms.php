<?php 

    require_once "../../config/config.php";

    $year_id = $_POST['year_id'];

    if(!isset($_POST['searchTerm'])){
        $query = "SELECT name, term_year_id FROM `term_year` 
                  JOIN term ON term_year.term_id = term.id 
                  WHERE year_id =:year_id 
                  AND term_year.status = 1";
         $sql = $dbh->prepare($query);
         $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
         $sql->execute();
         $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $term_name = $_POST['searchTerm'];

        $query = "SELECT name, term_year_id FROM `term_year` 
                  JOIN term ON term_year.term_id = term.id 
                  WHERE year_id =:year_id AND name LIKE :term_name
                  AND term_year.status = 1";
         $sql = $dbh->prepare($query);
         $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
         $sql->bindValue(":term_name", '%'.$term_name.'%', PDO::PARAM_STR);
         $sql->execute();
         $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    

    $data [] = array();

    foreach ($result as $r) {
        $data [] = array (
            "id" => $r['term_year_id'],
            "text" => $r['name']
        );
    };

    echo json_encode($data);
    exit();

?>