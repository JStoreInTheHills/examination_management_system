/**
 * This is the Students Js File. It contains the dataset used to populate the Students Datatables.
 */

var student_table = $("#dataTable").DataTable({
  ajax: {
    url: "./queries/get_all_students.php",
    type: "GET",
    dataSrc: "",
  },
  cache: true,
  columnDefs: [
    {
      targets: 0,
      data: "StudentName",
      render: function (data) {
        return `<a href="#"> ${data} </a>`;
      },
    },
    {
      targets: 1,
      data: "RollId",
    },
    {
      targets: 2,
      data: "RegDate",
    },
    {
      targets: 3,
      data: "ClassName",
      render: function (data) {
        return '<a href="../class/pg/class_exams.php">' + data + "</a>";
      },
    },
    {
      targets: 4,
      data: "age",
      render: function (data) {
        return `${data} yrs`;
      },
    },
    {
      targets: 5,
      data: "Status",
      render: function (data) {
        if (data === "1") {
          return `<span class="badge badge-pill badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-pill badge-danger">Active</span>`;
        }
      },
    },
    {
      targets: 6,
      orderable: false,
      data: "StudentId",

      render: function (data, type, row, meta) {
        return `
        <a onClick="del()"><i class="fas fa-edit" title="Edit Student"></i></a>
          <a style = "color:red" onClick="del()"><i class="fas fa-trash" title="Delete Student"></i></a>

          <script type='text/javascript'>

          var toast = {
            question: function () {
              return new Promise(function (resolve) {
                iziToast.question({
                  title: "Question",
                  message: "Are you Sure?",
                  timeout: 20000,
                  close: false,
                  position: "center",
                  buttons: [
                    [
                      "<button><b>YES</b></button>",
                      function (instance, toast, button, e, inputs) {
                        instance.hide({ transitionOut: "fadeOut" }, toast, "button");
                        resolve();
                      },
                      false,
                    ],
                    [
                      "<button>NO</button>",
                      function (instance, toast, button, e, inputs) {
                        instance.hide({ transitionOut: "fadeOut" }, toast, "button");
                      },
                    ],
                  ],
                });
              });
            },
          };

          function del(){
            toast.question().then(function (){
             $.ajax({
               url : './queries/delete_student.php',
               type : 'POST',
               data : {
                 student_id : ${data},
               },
             }).done(function(response){
               var r = JSON.parse(response);
               if(r.success === true){
                iziToast.success({
                  type : "Success",
                  message : r.message,
                });
               }else {
                iziToast.error({
                  type : "Error",
                  message :r.message,
                });
               }
             }).fail(function(response){
               iziToast.error({
                 type : "Error",
                 message : "Error Check Again",
               });
             });
            });
          }

          
      </script>
      `;
      },
    },
  ],
});

$("#form").on("submit", function (event) {
  var formData = {
    fullanme: $("#fullanme").val(),
    rollid: $("#rollid").val(),
    emailid: $("#email").val(),
    gender: $("#gender").val(),
    classid: $("#classid").val(),
    age: $("#age").val(),
    dob: $("#date").val(),
  };

  $.ajax({
    type: "POST",
    url: "queries/add_student.php",
    data: formData,
  }).done(function (response) {
    var arr = JSON.parse(response);

    if (arr.success === true) {
      iziToast.success({
        title: "Success",
        position: "topRight",
        message: arr.message,
        onClosing: function () {
          student_table.ajax.reload(null, false);
          $("#form").each(function () {
            this.reset();
          });
        },
      });
    } else {
      iziToast.error({
        title: "Error",
        position: "topRight",
        message: arr.message,
      });
    }
  });
  event.preventDefault();
});

setInterval(function () {
  student_table.ajax.reload(null, false);
}, 100000);

$("#add_student").on("click", function (e) {
  e.preventDefault();
  $("#main_content").toggle();
  $("#student_add_card").show();
  student_table.ajax.reload(null, false);
});
$("#cancel_add").on("click", function (e) {
  e.preventDefault();
  $("#main_content").show();
  $("#student_add_card").toggle();
});
$('[data-toggle="datepicker"]').datepicker({
  format: "yyyy-mm-dd",
  autoHide: true,
});
