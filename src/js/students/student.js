var county_id = $("#county_id");
/**
 * This is the Students Js File. It contains the dataset used to populate the Students Datatables.
 */

var student_table = $("#dataTable").DataTable({
  ajax: {
    url: "./queries/get_all_students.php",
    type: "GET",
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: {
        StudentId: "StudentId",
      },
      render: function (data) {
        return `<a href="./pages/details.php?sid=${data.StudentId}"> ${data.StudentName} </a>`;
      },
    },
    {
      targets: 1,
      data: "RollId",
      width: "10%",
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
      width: "10%",

      render: function (data, type, row, meta) {
        return `<a onClick="del()"><i class="fas fa-edit" title="Edit Student"></i></a>
          <a style = "color:red" onClick="deleteStudent(${data})"><i class="fas fa-trash" title="Delete Student"></i></a>
        `;
      },
    },
  ],
});

var toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.question({
        title: "Warning",
        transitionIn: "bounceInLeft",
        opacity: "100",
        icon: "fas fa-users",
        message: "Are you sure you want to delete this student?",
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

function deleteStudent(student_id) {
  toast.question().then(function () {
    $.ajax({
      url: "./queries/delete_student.php",
      type: "POST",
      data: {
        student_id: student_id,
      },
    })
      .done(function (response) {
        var r = JSON.parse(response);
        if (r.success === true) {
          iziToast.success({
            type: "Success",
            transitionIn: "bounceInLeft",
            message: r.message,
            onClosing: function () {
              student_table.ajax.reload(null, false);
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

$("#form").on("submit", function (event) {
  var formData = {
    fullanme: $("#fullanme").val(),
    rollid: $("#rollid").val(),
    emailid: $("#email").val(),
    gender: $("#gender").val(),
    classid: $("#classid").val(),
    age: $("#age").val(),
    dob: $("#date").val(),

    next_of_kin: $("#next_of_kin").val(),
    telephone: $("telephone").val(),
    address: $("#address").val(),
    county_id: $("#county_id").val(),
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
        transitionIn: "bounceInLeft",
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

function getCounties() {
  $.ajax({
    url: "../utils/get_counties.php",
    dataSrc: "",
  }).done(function (response) {
    let res = JSON.parse(response);
    res.forEach((element) => {
      county_id.append(
        `<option value="${element.id}">${element.code} ~ ${element.name}</option>`
      );
    });
  });
}

getCounties();
