<?php include '../../config/config.php';

$stream_id = $_POST['stream_id'];

$data = array();
$error = array();

if(empty($stream_id))
    $error['stream_id'] = 'Stream cannot be Empty';


if (!empty($error)) {
        $data['success']  = false;
        $data['message'] = $error;
}else{

    $sql = "DELETE FROM stream WHERE stream_id = :stream_id";
    $query=$dbh->prepare($sql);
    $query->bindParam(':stream_id', $stream_id, PDO::PARAM_STR);
    
    $result = $query->execute();

    $er = $query->errorInfo();

    if($result){
        $data['success'] = true;
        $data['message'] = 'Stream Deleted Successfully';
    }else{
        $data['success'] = false;
        $data['message'] =$er[2] ;
    }

    
}

echo json_encode($data);