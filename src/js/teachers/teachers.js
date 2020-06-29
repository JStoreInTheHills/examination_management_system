let county_address = $("#county_id"); // placeholder for county select dropdown/

let teacher_table = $("#teachers_table").DataTable({
  ajax: {
    url: "./queries/get_all_teachers.php",
    type: "GET",
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: {
        name: "name",
        teacher_id: "teacher_id",
      },
      render: function (data) {
        return `<a href="/teachers/pages/view_teacher.php?teachers_id=${data.teacher_id}">${data.name}<a>`;
      },
    },
    {
      targets: 1,
      data: "id_no",
    },
    {
      targets: 2,
      data: "gender",
    },
    {
      targets: 3,
      data: "SubjectName",
      render: function (data) {
        return `<a href="">${data}</a>`;
      },
    },
    {
      targets: 4,
      data: "email",
      render: function (data) {
        return `<a href="mailto:${data}">${data}</a>`;
      },
    },
    {
      targets: 5,
      data: "phone",
    },
    {
      targets: 6,
      orderable: false,
      data: "teacher_id",
      render: function (data) {
        return `<a style="color: red" onclick="deleteTeacher(${data})" class="fas fa-trash"></a>`;
      },
    },
  ],
});

$("#teachers_form").on("submit", function (e) {
  e.preventDefault();

  let formData = {
    teacherName: $("#teachers_name").val(),
    teacherID: $("#teachers_id").val(),
    teachers_email: $("#teachers_email").val(),
    teachers_phoneNumber: $("#teachers_phoneNumber").val(),
    gender: $("#gender").val(),

    physicalAddress: $("#physicalAddress").val(),
    county_id: $("#county_id").val(),

    teachers_spec: $("#teachers_spec").val(),
  };

  if (formData.teacherID.length > 8 && formData.teacherID.length < 7) {
    $("#ErrorMessage").html("ID NUMBER MUST BE MORE THAN 8 DIGITS");
  } else {
    $.ajax({
      url: "./queries/add_teacher.php",
      data: formData,
      type: "POST",
      dataSrc: "",
    })
      .done(function (response) {
        let res = JSON.parse(response);
        if (res.success === true) {
          iziToast.success({
            title: "Success",
            icon: "fas fa-user",
            transitionIn: "bounceInLeft",
            position: "topRight",
            message: res.message,
            onClosing: function () {
              teacher_table.ajax.reload(null, false);
              $("#teachers_form").each(function () {
                this.reset();
              });
            },
          });
        } else {
          iziToast.error({
            title: "Error",
            icon: "fas fa-user",
            transitionIn: "bounceInLeft",
            position: "bottomRight",
            message: "Check Again",
          });
        }
      })
      .fail(function (response) {
        iziToast.error({
          title: "Error",
          icon: "fas fa-user",
          transitionIn: "bounceInLeft",
          position: "bottomRight",
          message: "Something went wrong. Check your serverSide Script.",
        });
      });
  }
});

$("#add_teacher").on("click", function (event) {
  event.preventDefault();
  $("#main_content").toggle();
  $("#teacher_input_form").show();
  getCounties();
  getSubjects();
});

$("#cancel_form").on("click", function (event) {
  event.preventDefault();
  $("#main_content").show();
  $("#teacher_input_form").toggle();
});

function getCounties() {
  $.ajax({
    url: "./queries/get_counties.php",
    dataSrc: "",
  }).done(function (response) {
    let res = JSON.parse(response);
    res.forEach((element) => {
      county_address.append(
        `<option value="${element.id}">${element.code} ~ ${element.name}</option>`
      );
    });
  });
}

function getSubjects() {
  $.ajax({
    url: "./queries/get_subjects.php",
    type: "GET",
    dataSrc: "",
  }).done(function (response) {
    let result = JSON.parse(response);
    result.forEach((element) => {
      let teachers_spec = $("#teachers_spec");
      teachers_spec.append(
        `<option value = "${element.subject_id}">${element.SubjectName}</option>`
      );
    });
  });
}

var questionToast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.question({
        title: "Warning",
        icon: "fas fa-exclamation-triangle",
        message: "Are you Sure you want to delete this teacher?",
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

function deleteTeacher(teachers_id) {
  questionToast.question().then(function () {
    $.ajax({
      url: "./queries/delete_teacher.php",
      type: "POST",
      data: {
        teachers_id: teachers_id,
      },
    })
      .done(function (response) {
        let r = JSON.parse(response);
        if (r.success === true) {
          iziToast.success({
            type: "Success",
            position: "topRight",
            message: r.message,
            onClosing: function () {
              teacher_table.ajax.reload(null, false);
            },
          });
        }
      })
      .fail(function () {
        iziToast.error({
          type: "Error",
          message: "Error Check Again",
        });
      });
  });
}

function getTeachersCount() {
  $.ajax({
    url: "./queries/get_teachers_count.php",
    type: "GET",
  }).done(function (response) {
    let teacher = JSON.parse(response);
    $("#all_students").append(`${teacher[0].teachers}`);
  });
}
getTeachersCount();
