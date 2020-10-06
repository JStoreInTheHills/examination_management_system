<?php

session_start();

date_default_timezone_set('Africa/Nairobi');

// set some language dependent data:
$lg = Array();

$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';

// Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')

try{

        if(file_exists('../templates/tcpdf_template.php')){
            require('../../utils/configs/TCPDF-master/tcpdf.php');// Include the template file
        }else{
            throw new Exception("Error Processing Request. File Template not Found", 1);
        }

        if(file_exists('../../config/config.php')){
            include '../../config/config.php'; // Include the Database Config File. 
        }else{
            throw new Exception("Error Processing Request. Database File not Found", 1);
        }
}catch(Exception $e){
   echo 'Exception Caught ',  $e->getMessage() , "\n";
}

// Query to fetch all the students. 
try{
    $sql = "SELECT s.name as tname, id_no, email, phone,gender,address,s.created_at, SubjectName, cs.name as county
    FROM tblteachers s 
    LEFT JOIN tblsubjectcombination c 
    ON c.teachers_id = s.teacher_id 
    JOIN counties cs ON cs.id = s.county_id
    JOIN tbl_user ON tbl_user.id = s.user_id
    JOIN tblsubjects ON tblsubjects.subject_id = c.SubjectId
    ORDER BY tname asc";

    $query = $dbh->prepare("SELECT COUNT(DISTINCT teacher_id) AS TeachersCount FROM tblteachers");
    $query->execute();
    $student_count = $query->fetchAll();

   
    $ratio = "SELECT sum(CASE WHEN `Gender` = 'MALE' then 1 else 0 end)as male_ratio,
    sum(case when `Gender` = 'FEMALE' then 1 else 0 end) as female_ratio
    FROM tblteachers";

    $ratioQuery = $dbh->prepare($ratio);
    $ratioQuery->execute();

    $totalQuery = $ratioQuery->fetchAll();

}catch(Exception $e){
    echo "Uncaught Exception " , $e->getMessage() , "\n";
}


// Add page and utf-8 and pdf-page-orientation. 
try{
        $pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    
        $pdf->SetTitle('Teachers ~ Detailed  Report');
        $pdf->SetSubject("detailed teachers report");
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(5, 3, 3, $keepmargins=true);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);

        // set font
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->setCellHeightRatio(1);
        
        // add a page
        $pdf->AddPage();

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Munawara');

        // set some language-dependent strings (optional)
        $pdf->setLanguageArray($lg);

        $pdf->Rect(5, 2.5, 289, 35); // Rectangle Around the Header.


        $pdf->Image('../../src/img/favicon.jpeg', 7,3,35,30);
        
        $pdf->setRTL(false);
        // set font
        $pdf->SetFont('aefurat', '', 29);

        $pdf->Cell(0, 1, '‫المدرسة‬ ‫ا لمنورة الإسلامية‬ ‫‬ ',0,1, 'C');

        // $pdf->SetMargins(5, 3, 5, $keepmargins=true);
        $pdf->SetFont('aefurat', '', 17);
        $pdf->Cell(20);
        $pdf->Cell(0,10,'AL MADRASATUL MUNAWWARAH AL ISLAMIYA',$border=0,$ln=1,'C',$fill=false, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
            
        $pdf->SetFont('aefurat', 'B', 12);

        $pdf->Cell(35);
        $pdf->Cell(150,5,'P.O.Box: 98616-80100 Mombasa-Kenya', 0, 0, 'C');
        $pdf->Cell(0,5,'Email: info@almunawwarah.ac.ke', 0, 1, 'C');

        $pdf->Cell(35);
        $pdf->Cell(150,5,'Tel No: 0720 211 495/ 0733 806 60', 0, 0, 'C');
        $pdf->Cell(0,5,'Website : www.almunawwarah.ac.ke',$border=0,$ln=1,'C',$fill=false, $link='/index.php', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Ln(5);

        // Restore RTL direction
        $pdf->setRTL(false);

        $pdf->SetFillColor(193, 229, 252);

        $pdf->SetFont('aefurat', '', 12);

        $pdf->Cell(0, 8, "DETAILED TEACHER'S REPORTS",$border=1,$ln=1,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Cell(94, 8, "Total Number of Teachers: " .$student_count[0]['TeachersCount']. " " ,$border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Cell(90, 8, "Dated: " .date("F j, Y, g:i a").  "",$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Cell(0, 8, "Printed By: ". $_SESSION['alogin']. "",$border=1,$ln=1,'R',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');

        $pdf->Cell(150, 8, "Male Teachers: " . $totalQuery[0]['male_ratio'].  "",$border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');
        $pdf->Cell(0, 8, "Female Teachers: " .$totalQuery[0]['female_ratio']. "",$border=1,$ln=1,'R',$fill=true, $link='', $stretch=0, $ignore_min_height=true, $calign='T', $valign='B');

        $pdf->Ln(2);

}catch(Exception $e){
        echo "Uncaught Exception " , $e->getMessage() , "\n";
}

try{
    
    $width_cell = array(50,20,60,40,15,8,25,26,30, 65, 70);

    $pdf->SetFillColor(193, 229, 252);

    $pdf->SetFont('aefurat', 'B', 12);
    $pdf->Cell($width_cell[5], 10, '#', $border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='C');
    $pdf->Cell($width_cell[2], 10, 'TEACHERS NAME',$border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[7], 10, 'ID NO',$border=1,$ln=0,'L',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[10], 10, 'EMAIL ADDRESS',$border=1,$ln=0,'R',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[8], 10, 'PHONE',$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[4], 10, 'SEX',$border=1,$ln=0,'C',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[0], 10, 'ADDRESS',$border=1,$ln=0,'R',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    $pdf->Cell($width_cell[8], 10, 'SUBJECT',$border=1,$ln=1,'R',$fill=true, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
    
    $pdf->SetFont('aefurat', 'I', 11);
    $pdf->SetFillColor(235, 236, 236);
    $fill = false;

    $status = "";

    $cnt = 1;
    foreach ($dbh->query($sql) as $row) {
        $pdf->Cell($width_cell[5], 10, $cnt, $border=1,$ln=0,'C',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[2], 10, $row['tname'], $border=1,$ln=0,'L',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[7], 10, $row['id_no'],$border=1,$ln=0,'L',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[10], 10, $row['email'],$border=1,$ln=0,'R',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[8 ], 10, $row['phone'], $border=1,$ln=0,'C',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[4], 10, $row['gender'],$border=1,$ln=0,'C',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[0], 10, $row['address'] . ', ' . $row['county'] , $border=1,$ln=0,'R',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');
        $pdf->Cell($width_cell[8], 10, $row['SubjectName'], $border=1,$ln=1,'R',$fill=$fill, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='R');

        $fill = !$fill; $cnt = $cnt + 1; $count = $count + 1;
    }
}catch(Exception $e){
    echo "Uncaught Exception " , $e->getMessage() , "\n";
}


$pdf->Output('SUMMARY TEACHER REPORT '.time().".pdf", 'I');
?>