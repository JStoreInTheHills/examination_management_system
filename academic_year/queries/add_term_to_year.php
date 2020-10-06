<?php 
    
        require_once "../../config/config.php";
        session_start();
        $term_id = $_GET['term_id'];
        $year_id = $_GET['year_id'];
        $created_by = $_SESSION['uuid'];

        $data = array();
        $er = array();

        if(empty($term_id)){
            $er['Term Id'] = "Term cannot be empty";
        }
        if(empty($year_id)){
            $er['Year Id'] = "Year cannot be empty";
        }

        if(!empty($er)){
            $data['success'] = false;
            $data['message'] = $er;
        }else{

            $query = "INSERT INTO term_year(term_id, year_id, created_by,created_at)
                      VALUES(:term_id, :year_id, :created_by, CURRENT_TIMESTAMP)";

            $sql = $dbh->prepare($query);
            $sql->bindParam(":term_id", $term_id, PDO::PARAM_STR);
            $sql->bindParam(":year_id", $year_id, PDO::PARAM_STR);
            $sql->bindParam(":created_by", $created_by, PDO::PARAM_STR);

            $result = $sql->execute();
            $error = $sql->errorInfo();

            if($result){
                $data['success'] = true;
                $data['message'] = "Term Added to Year Successfully";
            }else{
                $data['success'] = false;
                $data['message'] = $error[2];
            }   
        }
    echo json_encode($data);


?>