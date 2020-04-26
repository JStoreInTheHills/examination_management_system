$(function () {

   var exam_table = $('#exam_table').DataTable({
        ajax : {
            'url' : './queries/get_all_exams.php',
            'dataSrc' : '',
            "type": "GET",
        },
        "columnDefs" : [
            {
                "targets": 0,
                "data": "exam_name",
            }, {
                "targets": 1,
                "data": "created_at",
            }, {
                "targets": 2,
                "data": "created_by",
            },
            {
                "targets": 3,
                "data": "exam_id",
                "render" : function (data) {
                    return '<div class="dropdown">'+
                        ' <a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                        +'<i class="icon-menu9"></i>' + '</a> <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' + '' +
                        '<a class="dropdown-item" id="view" href="#">View</a><a class="dropdown-item" href="#">Delete</a>' + '</div></div>' + ''
                        ;
                }
            },

        ]
    });

     setInterval(function () {
        exam_table.ajax.reload(null, false)
    }, 100000);

    $('#add_exam').on('click', function (e) {
        e.preventDefault();
            $('#exam_main_content').toggle();
                $('#exam_add_card').show();
    });

    $('#exam_form').on('submit', function (e) {
        e.preventDefault();
            var formData = {
                'exam_name' : $('#exam_name').val(),
            };
            $.ajax({
                url : './queries/add_exam.php',
                method: "POST",
                data : formData,
            }).done(function (response) {
                var arr = JSON.parse(response);
                if (arr.success === true) {
                    iziToast.success({
                        title: 'Success',
                        position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
                        message: arr.message,
                    });
                } else {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: arr.message
                    });
                }

            })
    });

   $('#cancel_exam_form_add').on('click', function (e) {
       e.preventDefault()
        $('#exam_main_content').show();
        $('#exam_add_card').toggle();
   })

});
