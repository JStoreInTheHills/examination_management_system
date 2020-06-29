/**
 *
 */

var class_id_queryString = window.location.search;
var class_id_urlParams = new URLSearchParams(class_id_queryString);

var class_id = class_id_urlParams.get("classid");
var class_name = class_id_urlParams.get("class_name");
// --------------------------------------------------

$("#heading").append(class_name);
$("#title").append(`${class_name} || Details`);
$("#bread_list").append(`${class_name}`);
// --------------------------------------------------

var toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.question({
        title: "Warning",
        icon: "fas fa-certificate",
        message: "Are you Sure you want to delete?",
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

// Exam DataTables passing class id as an argurment.
var view_class_table = $("#view_class").DataTable({
  ajax: {
    url: "../queries/get_class_exams.php",
    type: "GET",
    dataSrc: "",
    data: {
      class_id: class_id,
    },
  },
  columnDefs: [
    {
      targets: 0,
      data: {
        exam_name: "exam_name",
        id: "id",
        ClassName: "ClassName",
      },
      render: function (data) {
        return `<a href="./class_exams.php?class_id=${class_id}&id=${data.id}&exam_name=${data.exam_name}&class_name=${data.ClassName}"> ${data.exam_name} </a>`;
      },
    },
    {
      targets: 1,
      data: "year_name",
    },
    {
      targets: 2,
      data: "created_at",
    },

    {
      targets: 3,
      data: "id",
      orderable: false,
      render: function (data) {
        return `<a style = "color:red" onClick="deleteExam(${data})"><i class="fas fa-trash"></i></a>
          <a href=""><i class="fas fa-edit"></i></a>
        
        `;
      },
    },
  ],
});

function deleteExam(data) {
  toast.question().then(function () {
    $.ajax({
      url: "../queries/delete_class_exam.php",
      type: "POST",
      data: {
        class_exam_id: data,
      },
    })
      .done(function (response) {
        var r = JSON.parse(response);
        if (r.success === true) {
          iziToast.success({
            type: "Success",
            message: r.message,
            onClosing: function () {
              view_class_table.ajax.reload(null, false);
            },
          });
        } else {
          iziToast.error({
            type: "Error",
            message: r.message,
          });
        }
      })
      .fail(function (response) {
        iziToast.error({
          type: "Error",
          message: "Error Check Again",
        });
      });
  });
}

var view_class_student = $("#view_class_student").DataTable({
  ajax: {
    url: "../queries/get_class_students.php",
    type: "GET",
    data: {
      class_id: class_id,
    },
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: "StudentName",
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
      data: "DOB",
    },
    {
      targets: 4,
      data: "Gender",
    },
    {
      targets: 5,
      data: "Status",
      render: function (data) {
        if (data == 1) {
          return `<span class="badge badge-pill badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-pill badge-danger">InActive</span>`;
        }
      },
    },
    {
      targets: 6,
      orderable: false,
      data: "StudentId",
      render: function (data) {
        var string = `

        <a href="" title="Make Student Inactive"><i class="fas fa-edit"></i></a>
        <a title="Remove Student From Class" style = "color:red" onClick="del()"><i class="fas fa-trash"></i></a>

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
             url : '../queries/delete_class_exam.php',
             type : 'POST',
             data : {
               class_exam_id : ${data},
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
        return string;
      },
    },
  ],
});

var view_class_subjects = $("#view_class_subjects").DataTable({
  ajax: {
    url: "../queries/get_class_subjects.php",
    type: "GET",
    dataSrc: "",
    data: {
      class_id: class_id,
    },
  },
  columnDefs: [
    { className: "dt-center", targets: "_all" },
    {
      targets: 0,
      data: "SubjectName",
    },
    {
      targets: 1,
      data: "SubjectCode",
    },
    {
      targets: 2,
      data: "name",
      render: function (data) {
        return `<a href="">${data}</a>`;
      },
    },
    {
      targets: 3,
      data: "status",
      render: function (data) {
        if (data == 1) {
          return `<span class="badge badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-success">Inactive</span>`;
        }
      },
    },
    {
      targets: 4,
      data: "id",
      orderable: false,
      render: function (data) {
        return `<a style="color:red" onClick="deleteSubject(${data})"> <i class="fas fa-trash"></i> </a>`;
      },
    },
  ],
});

function deleteSubject(subjectId) {
  console.log(subjectId);
}

$("#view_class_submit").on("click", function (event) {
  event.preventDefault();

  var formData = {
    exam_id: $("#exam_id").val(),
    year_id: $("#year_id").val(),
    class_id: class_id,
  };
  $.ajax({
    url: "../queries/add_class_exam.php",
    type: "POST",
    data: formData,
  }).done(function (response) {
    var s = JSON.parse(response);
    if (s.success === true) {
      iziToast.success({
        type: "Success",
        transitionIn: "bounceInLeft",
        position: "topRight",
        message: s.message,
        onClosing: function () {
          view_class_table.ajax.reload(null, false);
          get_total_exams_in_class();
        },
      });
    } else {
      iziToast.error({
        type: "Error",
        transitionIn: "bounceInLeft",
        position: "topRight",
        message: s.message,
      });
    }
  });
});

$("#view_subject_submit").on("click", function (e) {
  e.preventDefault();
  var formData = {
    subject_id: $("#subject_id").val(),
    class_id: class_id,
    teacher_id: $("#teachers_id").val(),
  };
  console.log(formData);
  $.ajax({
    url: "../queries/add_subject_to_class.php",
    data: formData,
    type: "POST",
  })
    .done(function (response) {
      var s = JSON.parse(response);
      if (s.success === true) {
        iziToast.success({
          type: "Success",
          position: "topRight",
          message: s.message,
          onClosing: function () {
            view_class_subjects.ajax.reload(null, false);
          },
        });
      } else {
        iziToast.error({
          type: "Error",
          position: "topRight",
          message: s.message,
        });
      }
    })
    .fail(function (response) {
      console.log(response);
    });
});

function get_declared_results() {
  $.ajax({
    url: "../queries/get_declared_results.php",
    type: "GET",
    data: {
      class_id: class_id,
    },
  }).done(function (response) {
    var r = JSON.parse(response);
    $("#result_declared_count").empty().append(r[0].student_who_sat);
  });
}

function get_total_students() {
  $.ajax({
    url: "../queries/get_total_students.php",
    type: "GET",
    data: {
      class_id: class_id,
    },
  }).done(function (response) {
    let r = JSON.parse(response);
    $("#total_students_in_class").empty().append(r[0].students);
  });
}

function get_total_exams_in_class() {
  $.ajax({
    url: "../queries/get_total_exams_in_class.php",
    type: "GET",
    data: {
      class_id: class_id,
    },
  }).done(function (response) {
    let r = JSON.parse(response);
    $("#total_exams_in_class").empty().append(r[0].exams);
  });
}

function total_subjects_in_class() {
  $.ajax({
    url: "../queries/get_total_subjects_in_class.php",
    type: "GET",
    data: {
      class_id: class_id,
    },
  }).done(function (response) {
    let e = JSON.parse(response);
    $("#total_subjects_in_class").empty().append(e[0].subjects);
  });
}

get_declared_results();
get_total_students();
get_total_exams_in_class();
total_subjects_in_class();

setInterval(function () {
  view_class_student.ajax.reload(null, false);
  view_class_table.ajax.reload(null, false);
  view_class_subjects.ajax.reload(null, false);
  get_declared_results();
  get_total_students();
  get_total_exams_in_class();
  total_subjects_in_class();
}, 100000);

// This is the chart method definition. Settings and Options are declared here. Datasets are populated from an ajax requesting
// class and class_exam id are passed as argurments.
function reloadChart() {
  var ctx = document.getElementById("myPieChart");
  $.ajax({
    url: "../queries/get_female_male_ratio.php",
    type: "GET",
    data: {
      class_id: class_id,
    },
    dataSrc: "",
  })
    .done(function (response) {
      var ds = JSON.parse(response); // Array of all subject Objects

      var female = ds[0]["female"];
      var male = ds[0]["male"];

      var options = {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: "#dddfeb",
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: true,
          caretPadding: 10,
        },
        legend: {
          display: true,
          position: "top",
        },
        cutoutPercentage: 70,
      };
      var data = {
        labels: ["Female", "Male"],
        datasets: [
          {
            data: [female, male],
            backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"],
            hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf"],
          },
        ],
      };

      var myPieChart = new Chart(ctx, {
        type: "doughnut",
        data: data,
        options: options,
      });
    })
    .fail(function (e) {
      console.log(e);
    });
}
reloadChart();
