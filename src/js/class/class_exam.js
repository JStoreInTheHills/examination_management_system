$(function(){
    $('#class_exam_result_table').DataTable({
        ajax: {
            url: "../queries/get_students_result.php",
            type: "GET",
            // data : {
            //     "exam_id" : exam_id,
            // },
            dataSrc: "",
          },
          
    })
})