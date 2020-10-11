// $(document).ready(() => {

// const { default: iziToast } = require("izitoast");

// Declaration of a string holding the URI location values.
const class_subject_teacher_query = window.location.search;

// Creating an object that holds the values of the argurments in the URI.
// The URI is passed as an argurment.
const class_id_param = new URLSearchParams(class_subject_teacher_query);

// Variable holding the value of the class unique id
// ----------------------------------------------------------------
const class_id = class_id_param.get("class_id");

const subject_id = class_id_param.get("subject_id");

const teachers_id = class_id_param.get("teacher_id");
// -----------------------------------------------------------------

// variable holding the teachers datatables.

// Variable holding the students input field.
const students_id = $("#students_id");
students_id.select2({
  theme: "bootstrap4",
  placeholder: "Select a Student",
});

const class_teacher_modal_title = $("#class_teacher_modal_title");

const Subject_Taught = $("#Subject_Taught");

const exam_id = $("#exam_id");

const marks = $("#marks");

// ----------------------------------------------------------------------------------------------
// Adding the href attribute to the HTML dom for navigation purposes.
const my_classes = document.getElementById("my_classes");

my_classes.href = `./view_teacher?teachers_id=${teachers_id}`;
// ----------------------------------------------------------------------------------------------

// Variable holding the form attribute
const subject_teachers_form = $("#subject_teachers_form");

// Variable holding the SubjectCreationDate of the class.
const SubjectCreationDate = $("#SubjectCreationDate");

const year_id = $("#year_id");

// Variable holding the status of the subject of the teacher.
const status = $("#status");

// Variable holding the name of the term.
const term_name = $("#term_name");

const formData = {
  class_id: class_id,
};

const errror = $("#errror");

var exam_out_of;

const init = () => {
  $.ajax({
    url: "../queries/fetch_class_subject_to_add_result.php",
    type: "GET",
    data: formData,
  }).done((resp) => {
    const r = JSON.parse(resp);
    r.forEach((item) => {
      $("#heading").html(`Stream: ${item.ClassName}`);
      $("#title").html(`${item.ClassName} || Add Result`);
      const active_class = document.getElementById("active_class");
      $("#active_class").html(item.ClassName);
    });
    getSubject();
    getStudents();

    $("#toast").html(`
      <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Uses this page to add a students performance marks for a subject that you teach.</strong>
      <hr>
      <p class="mb-0">Click Save after choosing the exam, the student and the appropriate performance.
      Exam that are marked "Closed" are not to be entered and wont appear on the exam
          options.
      </p>

      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
    `);
  });
};

init();

const getStudents = () => {
  $.ajax({
    url: "/class/queries/get_class_students",
    data: formData,
    type: "GET",
    dataSrc: "",
  }).done((resp) => {
    const r = JSON.parse(resp);
    r.forEach((item) => {
      students_id.append(
        `<option value="${item.StudentId}">${item.FirstName} ${item.OtherNames} ${item.LastName} (${item.RollId})</option>`
      );
    });
  });
};

const getSubject = () => {
  $.ajax({
    url: "../queries/get_subject_for_add_subject.php",
    type: "GET",
    data: {
      teacher_id: teachers_id,
      class_id: class_id,
      subject_id: subject_id,
    },
  }).done((resp) => {
    const r = JSON.parse(resp);

    let s;
    r.forEach((item) => {
      class_teacher_modal_title.html(`Add Marks for : ${item.SubjectName}`);
      Subject_Taught.html(`Subject: ${item.SubjectName}`);
      SubjectCreationDate.html(`Subject Added on: ${item.CreationDate}`);
      s = item.status;
    });
    if (s === "1") {
      status.html(
        `Subject Status : <span class="badge badge-pill badge-success">Active</span>`
      );
    } else {
      status.html(
        '<span class="badge badge-pill badge-danger">Inactive</span>'
      );
    }
  });
};

const getExam = (term_id) => {
  $.ajax({
    url: "../queries/get_class_specific_exam.php",
    type: "GET",
    data: {
      class_id: class_id,
      term_id: term_id,
    },
  }).done((resp) => {
    const r = JSON.parse(resp);
    r.forEach((item) => {
      exam_id.append(`<option value="${item.id}">${item.exam_name}</option>`);
      exam_out_of = item.exam_out_of;
    });
  });
};

const getYear = () => {
  $.ajax({
    url: "/academic_year/queries/fetch_all_academic_years.php",
    type: "GET",
  }).done((resp) => {
    const arr = JSON.parse(resp);
    if (arr.length == 0) {
      iziToast.error({
        type: "Warning",
        title: "Warning",
        icon: "fas fa-exclamation",
        // position: "center",
        message: "No year has been declared yet. Kindly contact Administrator.",
      });
    } else {
      arr.forEach((item) => {
        year_id.append(
          `<option value="${item.year_id}">${item.year_name}</option>`
        );
      });
    }
  });
};

getYear();

const getterms = (year_id) => {
  $.ajax({
    url: "../queries/get_year_terms.php",
    type: "GET",
    data: {
      year_id: year_id,
    },
  }).done((resp) => {
    const arr = JSON.parse(resp);
    arr.forEach((item) => {
      term_name.append(
        `<option value="${item.term_year_id}"> ${item.name}</option>`
      );
    });
  });
};

subject_teachers_form.submit((e) => {
  e.preventDefault();

  const formData = {
    class_exam_id: exam_id.val(),
    students_id: students_id.val(),
    marks: marks.val(),
    subject_id: subject_id,
    class_id: class_id,
  };

  if (formData.marks <= exam_out_of) {
    $.ajax({
      url: "../queries/add_students_result_for_stream.php",
      type: "POST",
      data: formData,
    }).done((resp) => {
      const arr = JSON.parse(resp);
      if (arr.success == true) {
        iziToast.success({
          type: "Success",
          position: "topRight",
          transitionIn: "bounceInLeft",
          message: arr.message,
          onClosing: () => {
            teachers_subject_table.ajax.reload(null, false);
            $("#subject_teacher_form").each(function () {
              this.reset();
            });
          },
        });
      } else {
        $("#errror")
          .html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>${arr.message}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>`);
      }
    });
  } else {
    marks.css("border-color", "red");
    $("#label_for_marks").removeClass("text-primary").addClass("text-danger");
    $("#year_label").removeClass("text-primary").addClass("text-danger");
    $(".label_error").html(`Subject Marks Is Out of ${exam_out_of}`);
  }
});

const teachers_subject_table = $("#teachers_subject_table").DataTable({
  order: [[3, "desc"]],
  ajax: {
    url: "../queries/fetch_class_result_.php",
    type: "GET",
    data: {
      class_id: class_id,
      subject_id: subject_id,
    },
    dataSrc: "",
  },
  columnDefs: [
    {
      width: "10%",
      targets: 3,
    },
    {
      targets: 0,
      data: {
        FirstName: "FirstName",
        OtherNames: "OtherNames",
        LastName: "LastName",
      },
      render: (data) => {
        return `<a href="">${data.FirstName} ${data.OtherNames} ${data.LastName}</a>`;
      },
    },
    {
      targets: 1,
      data: {
        RollId: "RollId",
      },
      render: (data) => {
        return `${data.RollId}`;
      },
    },
    {
      targets: 2,
      data: "exam_name",
    },
    {
      targets: 3,
      data: "marks",
    },
    {
      targets: 4,
      data: {
        result_id: "result_id",
        students_id: "students_id",
        subject_id: "subject_id",
        exam_id: "exam_id",
      },
      render: (data) => {
        return `<a onClick="editResult(${data.result_id}, ${data.students_id}, ${data.exam_id})">
                  <span><i class="text-primary fas fa-edit"></i></span>
                </a>`;
      },
    },
  ],
});

const editResult = (result_id, students_id, exam_id) => {
  // console.log(result_id, students_id, exam_id);
  $("#edit_students_marks").modal("show");
  $.ajax({
    url: "../queries/get_students_result.php",
    type: "GET",
    data: {
      result_id: result_id,
      students_id: students_id,
      exam_id: exam_id,
    },
  }).done((resp) => {
    const arr = JSON.parse(resp);
    arr.forEach((item) => {
      $("#students_name").val(
        `${item.FirstName} ${item.OtherNames} ${item.LastName} (${item.RollId})`
      );
      $("#students_marks").val(item.marks);
      $("#edit_students_id").val(item.students_id);
      $("#edit_exam_id").val(item.class_exam_id);
      $("#edit_result_id").val(item.result_id);
    });
  });
};

$("#edit_students_result_submit").click((e) => {
  const formData = {
    students_id: $("#edit_students_id").val(),
    students_marks: $("#students_marks").val(),
    exam_id: $("#edit_exam_id").val(),
    result_id: $("#edit_result_id").val(),
    subject_id: subject_id,
    class_id: class_id,
  };

  $.ajax({
    url: "../queries/update_students_subject_result.php",
    type: "GET",
    data: formData,
  }).done((resp) => {
    const arr = JSON.parse(resp);
    if (arr.success == true) {
      iziToast.success({
        type: "Success",
        message: arr.message,
        position: "topRight",
        transitionIn: "bounceInRight",
        onClosing: () => {
          teachers_subject_table.ajax.reload(null, false);
        },
      });
    } else {
      iziToast.error({
        type: "Error",
        message: arr.message,
        position: "topRight",
        transitionIn: "bounceInRight",
      });
    }
  });
  e.preventDefault();
});

students_id.change((e) => {
  var selectedColor = students_id.val();
  $("#errror").fadeOut();
});

setInterval(() => {
  teachers_subject_table.ajax.reload(null, false);
}, 1000000000);
// });
