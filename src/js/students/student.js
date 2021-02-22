/**
 * This is the Students Js File. It contains the dataset used to populate the Students Datatables.
 */

const county_id = $("#county_id");

const student_table = $("#dataTable").DataTable({
  order: [[0, "DESC"]],
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
        FirstName: "FirstName",
        OtherNames: "OtherNames",
        LastName: "LastName",
      },
      render: function (data) {
        let full_name = data.FirstName.concat(
          " " + data.OtherNames + " " + data.LastName
        );
        return `<a href="./pages/details?sid=${data.StudentId}"> ${full_name} </a>`;
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
        return '<a href="../class/pg/class_exams">' + data + "</a>";
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
          return `<span class="badge badge-pill badge-danger">In Active</span>`;
        }
      },
    },
    {
      targets: 6,
      orderable: false,
      data: "StudentId",
      width: "5%",

      render: function (data, type, row, meta) {
        return `
          <a style = "color:red" onClick="deleteStudent(${data})"><i class="fas fa-trash" title="Delete Student"></i></a>
        `;
      },
    },
  ],
});

var toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.error({
        title: "Warning",
        icon: "fas fa-exclamation",
        transitionIn: "bounceInLeft",
        opacity: "100",
        message:
          "Are you sure you want to delete this student? This process is irreversible",
        timeout: 2000000,
        close: false,
        position: "center",
        overlay: true,
        displayMode: "once",
        zindex: 999,
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
    first_name: $("#first_name").val(),
    second_name: $("#second_name").val(),
    last_name: $("#last_name").val(),
    rollid: $("#rollid").val(),
    gender: $("#gender").val(),
    classid: $("#classid").val(),
    dob: $("#date").val(),
    telephone: $("#telephone").val(),
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
