$(function () {

    var stream_table = $('#stream_table').DataTable({
        ajax : {
            "url" : "./queries/get_all_streams.php",
            "type" : "GET",
            "dataSrc" : "",
        },
        "columnDefs" : [
            {
                "targets": 0,
                "data": "name",
            },
            {
                "targets": 1,
                "data": "created_at",
            },
            {
                "targets": 2,
                "data": "stream_id",
                orderable: false,
            },
        ]
    });
    setInterval(function () {
        stream_table.ajax.reload(null, false)
    },1000000);

    $('#add_stream').on('click', function (e) {
        e.preventDefault();
        $('#stream_add_card').show();
            $('#stream_main_content').toggle();
                stream_table.ajax.reload(null, false);
    });
    $('#stream_form').on('submit', function(e) {
        e.preventDefault();
            var formData = {
                'stream_name' : $('#stream_name').val()
            };
        $.ajax({
            'url' : './queries/add_stream.php',
            'method':'POST',
            data : formData,
        }).done(function (response) {
            var s = JSON.parse(response)
            if (s.success === true){
                iziToast.success({
                    title: 'Success',
                    position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
                    message: s.message,
                });
            }else {
                iziToast.error({
                    title: 'Error',
                    position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
                    message: s.message,
                });
            }
        })
    })
    $('#cancel_stream_form_add').on('click', function (e) {
        e.preventDefault()
            $('#stream_add_card').toggle();
            $('#stream_main_content').show();
    })
});