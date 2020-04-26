var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);

var class_exam_id = urlParams.get('class_exam_id');
var cid = urlParams.get('cid');

$(function(){


    var result_table =  $('#result_table').DataTable({

        ajax: {
            'url': './queries/get_all_results.php',
            "type": "GET",
            "dataSrc": "",
            
        },
        "columnDefs": [
            {
                "targets": 0,
                "data": "StudentName",
            }, {
                "targets": 1,
                "data": "RollId",
            }, {
                "targets": 2,
                "data": "ClassName",
            }, {
                "targets": 3,
                "data": "score",
            }, {
                "targets": 4,
                "data": "score",
                "render": function(data){
                    if (data === 1) {
                        return 'A'
                      } else {
                        return 'B'
                      }
                }
            },{
                "targets" : 5,
                "data" : "StudentId",
                
                   
            }
        ],
    });

    $('#result_form').on('submit', function (e) {
        
        e.preventDefault();

        var l = $('.marks').length; // getting the length of the class element marks
        var result = []; // creating an empty array. 

        for(var i = 0; i < l; i++){
            result.push($('.marks').eq(i).val());
        }
            var formData = {
                class : $('#class').val(),
                studentid : $('#studentid').val(),
                marks : result,
                class_exam_id : 70,
            };

        $.ajax({
            'url' : './queries/add_results.php',
            data : formData,
            'method':'POST',
        }).done(function (response) {
            var s = JSON.parse(response);

            console.log(response);
            console.log(s);
            // if (s.success === true) {
            //     iziToast.success({
            //         title: 'Success',
            //         position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
            //         message: s.message,
            //     });
            // }else{
            //     iziToast.error({
            //         title: 'Error',
            //         position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
            //         message: s.message,
            //     });
            // }
        })
    })

    $('#add_result').on('click', function(){
        $('#main_content').toggle();
            $('#result_add_card').show();
    });

    setInterval(function(){
        result_table.ajax.reload(null, false);
    },100000);

    $('#cancel_form').on('click', function (e) {
        e.preventDefault();

        $('#main_content').show();
        $('#result_add_card').toggle();
            result_table.ajax.reload(null, false);
    })
    
});
function getStudent(val) {
    $.ajax({
        type: "POST",
        url: "./queries/get_student.php",
        data: 'classid=' + val,
        success: function(data) {
            $("#studentid").html(data);

        }
    });
    $.ajax({
        type: "POST",
        url: "./queries/get_student.php",
        data: 'classid1=' + val,
        success: function(data) {
            $("#subject").html(data);

        }
    });
}

function getresult(val, clid) {

    var clid = $(".clid").val();
    var val = $(".stid").val();;
    var abh = clid + '$' + val;
    //alert(abh);
    $.ajax({
        type: "POST",
        url: "./queries/get_student.php",
        data: 'studclass=' + abh,
        success: function(data) {
            $("#reslt").html(data);

        }
    });
}