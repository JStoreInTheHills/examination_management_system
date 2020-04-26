$(function(){
  var student_table = $('#dataTable').DataTable({
    ajax : {
      'url': './queries/get_all_students.php',  
      "type": "GET",
      "dataSrc": "",
    },
    cache: true,
    "columnDefs": [
      {
        "targets": 0,
        "data": "StudentName",
      }, {
        "targets": 1,
        "data": "RollId",
      }, {
        "targets": 2,
        "data": "RegDate",
      }, {
        "targets": 3,
        "data": "ClassName",
        "render": function (data) {
          return '<a href="../class/pg/class_exams.php">' + data + '</a>'
        }
      }, {
        "targets": 4,
        "data": "age",

      }, {
        "targets": 5,
        "data": "Status",
        'render': function (data) {
          if (data === 1) {
            return '<span class="label label-flat border-success text-success-600">Active</span>'
          } else {
            return '<span class="label label-flat border-danger text-danger-600">InActive</span>'
          }
        }
      }, {
        "targets": 6,
        orderable: false,
        "data": "StudentId",

        "render": function (data, type, row, meta) {

          return '<div class="dropdown">'+
                  ' <a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                  +'<i class="icon-menu9"></i>' + '</a> <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' + '' +
                  '<a class="dropdown-item" id="view" href="#">View</a><a class="dropdown-item" href="#">Delete</a>' + '</div></div>' + ''
              ;
        },

      }
    ],
  });

  $('#form').on('submit', function (event) {

    var formData = {
      'fullanme': $('#fullanme').val(),
      'rollid': $('#rollid').val(),
      'emailid': $('#email').val(),
      'gender': $('#gender').val(),
      'classid': $('#classid').val(),
      'age': $('#age').val(),
      'dob': $('#date').val(),
    };

    $.ajax({
      type: "POST",
      url: 'queries/add_student.php',
      data: formData,
    }).done(function (response) {

      var arr = JSON.parse(response);

      if (arr.success === true) {
        iziToast.success({
          title: 'Success',
          position: 'topRight',
          message: arr.message,
        });
      } else {
        iziToast.error({
          title: 'Error',
          position: 'topRight',
          message: arr.message,
        });
      }
    });
    event.preventDefault();

  });

  setInterval(function () {
      student_table.ajax.reload(null, false)
  }, 100000);

  $('#add_student').on('click', function (e) {
    e.preventDefault();
      $('#main_content').toggle();
      $('#student_add_card').show();
        student_table.ajax.reload(null, false);
  });
  $('#cancel_add').on('click', function (e) {
      e.preventDefault();
        $('#main_content').show();
        $('#student_add_card').toggle();

  });
  $('[data-toggle="datepicker"]').datepicker({
    format: 'dd-mm-yyyy',
    autoHide: true,
    language: 'ar-IQ'
  });

});

   

