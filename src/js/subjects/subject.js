$(function() {

    var subject_table = $('#subject_table').DataTable({
        autoWidth: false,
        ajax : {
            'url':'queries/get_all_subjects.php',
            "type": "GET",
            "dataSrc": "",
        },
        "columnDefs" : [
            {
                "targets": 0,
                "data": "SubjectName",
            },
            {
                "targets": 1,
                "data": "SubjectCode",
            },

            {
                "targets" : 2,
                orderable: false,
                "data" : "subject_id",
                "render" : function (data) {
                    return '<div class="dropdown">'+
                        ' <a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                        +'<i class="icon-menu9"></i>' + '</a> <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' + '' +
                        '<a class="dropdown-item" id="view" href="pg/class_exams.php?cid='+data+'">View</a>' +
                        '<a class="dropdown-item" href="queries/delete_class.php?classid='+data+'">Delete</a>' +
                        '</div></div>' + ''
                        ;
                }
            }
        ]
    });
    setInterval(function () {
        subject_table.ajax.reload(null, false);
    }, 100000);

    $('#add_subject').on('click', function (e) {
        e.preventDefault();
            $('#subject_main_content').toggle();
                $('#subject_add_card').show();
    });

    $('#subject_form').on('submit', function (e) {
        e.preventDefault();

         var formData = {
             'subject_name' : $('#subject_name').val(),
             'subject_code' : $('#subject_code').val()
         };
            $.ajax({
                "url" : "./queries/add_subject.php",
                "type" : "POST",
                data : formData,
            }).done(function (response) {
                var s = JSON.parse(response);
                if (s.success === true){
                    iziToast.success({
                        type : 'Success',
                        position: 'topRight',
                        message: s.message
                    });
                }else{
                    iziToast.error({
                        type: 'Error',
                        position: 'topRight',
                        message: s.message,
                    })
                }
            })
    });

    $('#cancel_subject_form_add').on('click', function (e) {
        e.preventDefault();
        $('#subject_main_content').show();
             $('#subject_add_card').toggle();
    })
});