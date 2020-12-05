<?php

    require_once "../../../config/config.php";

        $year_id = $_POST['year_id'];

        if(empty($_POST['searchTerm'])){
                $sql = "SELECT term_year_id, name
                        FROM term_year
                        JOIN term 
                        ON term_year.term_id = term.id
                        WHERE year_id =:year_id 
                        AND term_year.status = 1";
                
                $query = $dbh->prepare($sql);
                $query->bindParam(":year_id", $year_id, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
        }else{
                $searchTerm = $_POST['searchTerm'];

                $sql = "SELECT term_year_id, name
                        FROM term_year
                        JOIN term 
                        ON term_year.term_id = term.id
                        WHERE year_id =:year_id 
                        AND name LIKE :name
                        AND term_year.status = 1";
                
                $query = $dbh->prepare($sql);
                $query->bindParam(":year_id", $year_id, PDO::PARAM_STR);
                $query->bindValue(":name", '%'.$searchTerm.'%', PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        $data = array();

        foreach ($results as $r) {
                $data [] = array(
                        "id" => $r['term_year_id'],
                        "text" =>$r['name'],
                );
        }

       echo json_encode($data);
       exit();
                                                    
?>