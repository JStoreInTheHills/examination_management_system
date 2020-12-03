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

$("#subject_id").val(subject_id);
$("#class_id").val(class_id);

// -----------------------------------------------------------------

console.log(sessionStorage.getItem("token_number"));

const class_teacher_modal_title = $("#class_teacher_modal_title");

const Subject_Taught = $("#Subject_Taught");

const exam_id = $("#exam_id");

const marks = $("#marks");

const students_id = $("#students_id");
//------------------------------------------------------------------------------------------

// variable holding the teachers datatables.

// Variable holding the students input field.

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

$("#students_id").select2({
  placeholder: "Type to search student",
  theme: "bootstrap4",
  ajax: {
    url: "../queries/get_class_students",
    type: "POST",
    dataType: "json",
    delay: 250,
    data: function (params) {
      return {
        searchTerm: params.term,
        class_id: class_id, // search term
      };
    },
    processResults: function (response) {
      return {
        results: response,
      };
    },
    cache: true,
  },
});

$("#students_id").on("select2:select", function (e) {
  $("#btnSubmit").prop("disabled", false);
  $("#errror").fadeOut();
});

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

const getExam = () => {
  $.ajax({
    url: "../queries/get_class_specific_exam.php",
    type: "GET",
    data: {
      class_id: class_id,
      term_id: term_name.val(),
    },
  }).done((resp) => {
    const r = JSON.parse(resp);
    r.forEach((item) => {
      exam_id.append(`<option value="${item.id}">${item.exam_name}</option>`);
      exam_out_of = item.exam_out_of;
      $("#exam_out_of_badge").html(
        `<span><i>Exam out of : ${exam_out_of}<i></span>`
      );
    });
  });
};

year_id.select2({
  theme: "bootstrap4",
  placeholder: "Select a year",
  ajax: {
    url: "../queries/fetch_academic_year.php",
    type: "GET",
    dataType: "json",
    delay: 250,
    data: function (params) {
      return {
        searchTerm: params.term,
      };
    },
    processResults: function (response) {
      return {
        results: response,
      };
    },
    cache: true,
  },
});

term_name.select2({
  theme: "bootstrap4",
  placeholder: "Type to search for term",
  ajax: {
    url: "../queries/get_year_terms.php",
    type: "POST",
    dataType: "json",
    delay: 250,
    data: function (params) {
      return {
        searchTerm: params.term,
        year_id: year_id.val(),
      };
    },
    processResults: function (response) {
      return {
        results: response,
      };
    },
    cache: true,
  },
});

term_name.on("select2:select", function (e) {
  exam_id.select2({
    theme: "bootstrap4",
    placeholder: "Select An Exam",
    ajax: {
      url: "../queries/get_class_specific_exam.php",
      type: "POST",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term,
          class_id: class_id,
          term_id: term_name.val(),
        };
      },
      processResults: function (response) {
        return {
          results: response,
        };
      },
      cache: true,
    },
  });
});

subject_teachers_form.validate({
  rules: {
    year_id: "required",
    term_name: "required",
    exam_id: "required",
    students_id: "required",
    marks: {
      required: true,
      range: [0, 30],
    },
  },

  errorClass: "text-danger",

  submitHandler: (form) => {
    $.ajax({
      url: "../queries/add_students_result_for_stream.php",
      type: "POST",
      data: $(form).serialize(),
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
        $("#errror").fadeIn();
        $("#btnSubmit").prop("disabled", true);
        iziToast.error({
          type: "Error",
          icon: "fas fa-exclamation",
          position: "center",
          transitionIn: "bounceInLeft",
          message: arr.message,
        });
      }
    });
  },

  invalidHandler: (event, validator) => {
    let error = validator.numberOfInvalids();
    if (error) {
      let message = error == 1 ? "You missed" : `You missed ${error} fields`;
      $("#errror").html(message).addClass(`alert alert-danger`);
      $("#errror").show();
    } else {
      $("#errror").hide();
    }
  },
});

const teachers_subject_table = $("#teachers_subject_table").DataTable({
  order: [[4, "desc"]],
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
      width: "6%",
      targets: 4,
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
      data: "created_at",
    },
    {
      targets: 4,
      data: "marks",
    },
    {
      targets: 5,
      width: "5",
      data: {
        result_id: "result_id",
        students_id: "students_id",
        subject_id: "subject_id",
        exam_id: "exam_id",
      },
      render: (data) => {
        return `<a onClick="editResult(${data.result_id}, ${data.students_id}, ${data.exam_id})">
                  <span><i class="text-primary fas fa-edit"></i></span>
                </a>
                <a onClick="deleteResult(${data.result_id})">
                  <span><i class="text-danger fas fa-trash"></i></span>
                </a>
                `;
      },
    },
  ],
});

const toast = {
  question: () => {
    return new Promise((resolve) => {
      iziToast.error({
        title: "WARNING.",
        icon: "fas fa-exclamation",
        message:
          "Are you Sure you want to delete this result!! This operation is irreversible",
        timeout: 20000000,
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

const deleteResult = (result_id) => {
  toast.question().then(() => {
    $.ajax({
      url: "../queries/delete_students_result.php",
      type: "POST",
      data: {
        result_id: result_id,
      },
    }).done((response) => {
      const arr = JSON.parse(response);
      if (arr.success == true) {
        iziToast.success({
          type: "Success",
          position: "topRight",
          transitionIn: "bounceInLeft",
          message: arr.message,
          onClosing: () => {
            teachers_subject_table.ajax.reload(null, false);
          },
        });
      } else {
        iziToast.error({
          type: "Error",
          position: "topRight",
          transitionIn: "bounceInLeft",
          message: arr.message,
        });
      }
    });
  });
};

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
