<?php 

    include '../../config/config.php';

    $errors = array(); // holds the error values from the form
    $data = array(); // holds the data values from the form data. 

    if(empty($_POST['teacherName'])){ 
        $errors['Teacher Name'] = "Name cannot be empty";
    }
    if(empty($_POST['teacherID'])){
        $errors['Teachers ID'] = "Teachers ID cannot be empty";
    }
    if(empty($_POST['teachers_email'])){
        $errors['email'] = "Email Address cannot be null";
    }
    if(empty($_POST['teachers_phoneNumber'])){
        $errors['phone']  = "Phone Number cannot be Null";
    }
    if(empty($_POST['gender'])){
        $errors['Gender']  = "Gender cannot be Null";
    }

    if(!empty($errors)){
        $data['success'] = false;
        $data['message'] = $errors;
    }else {

        $name = $_POST['teacherName'];
        $id_no = $_POST['teacherID'];
        $email = $_POST['teachers_email'];
        $phone = $_POST['teachers_phoneNumber'];
        $gender = $_POST['gender'];

        $physicalAddress = $_POST['physicalAddress'];
        $county_id = $_POST['county_id'];

        $teachers_spec = $_POST['teachers_spec'];

    
        $sql = "INSERT INTO tblteachers (name, id_no, email, phone, gender, address, county_id, teacher_subject) 
                VALUES (:name,:id_no,:email,:phone, :gender, :physicalAddress, :county_id, :teacher_subject)";
        $query = $dbh->prepare($sql);

        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':id_no', $id_no, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);

        $query->bindParam(':physicalAddress', $physicalAddress, PDO::PARAM_STR);
        $query->bindParam(':county_id', $county_id, PDO::PARAM_STR);

        $query->bindParam(':teacher_subject', $teachers_spec, PDO::PARAM_STR);


        $query->execute();
        $sqlError = $query->errorInfo();
        
        $lastInsertId = $dbh->lastInsertId();

        if($lastInsertId){
            $data['success'] = true;
            $data['message'] = "Teacher Added Successfully";
        }else{
            $data['success'] = false;
            $data['message'] = $sqlError[2];
        }

    }
    echo json_encode($data);
