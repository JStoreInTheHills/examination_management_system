// $(document).ready(() => {
// Declaration of a string holding the URI location values.
const class_id_queryString = window.location.search;

// Creating an object that holds the values of the argurments in the URI.
// The URI is passed as an argurment.
const class_id_urlParams = new URLSearchParams(class_id_queryString);

const class_name_input = $("#edit_class_name");

const class_name_numeric = $("#edit_class_name_numeric");

// Variable holding the value of the class unique id
const class_id = class_id_urlParams.get("classid");

// Variable holding the value of the class name.
// --------------------------------------------------
const edit_class_form_submit = $("#edit_class_form_submit");

// Variable holding a reference node to the exam chart html canvas.
const ctx = document.getElementById("exams_charts").getContext("2d");

// The name of the class being appended to the heading of the page.
const pageHeading = $("#heading");

// Title of the page.
const pageTitle = $("#title");

// Breadlists BreadCrums item name.
const breadList = $("#bread_list");

// Stream name on the Add Subject Modal.
const classInputId = $("#class_to_add_subject");

const stream2_name = $("#stream2_name");
// --------------------------------------------------

// Variable pointing to the Submit button node on the form
const view_class_submit = $("#view_class_submit");

// Variable pointing to the exam input field on the exam form.
const examInput = $("#exam_id");

// Variable pointing to the year input field on the exam form.
const yearInput = $("#year_id");

// Variable pointing to the term input field on the exam form.
const termInput = $("#term_id");

// Variable pointing to the total number of exams declared card.
const totalExamInStream = $("#total_exams_in_class");

// Variable pointing to the total number of students declared card.
const totalStudentsInClass = $("#total_students_in_class");

// Variable pointing to the total number of subjects declared card.
const totalSubjectsInClass = $("#total_subjects_in_class");

// Variable pointing to the class teachers name.
const classTeacher = $("#classTeacher");

var teacher;
// Variable pointing to the creation date of the stream.
const creationdate = $("#creationdate");

// Variable pointing to the node value of the subject add form.
const add_teacher_form = $("#subject_add");

// Variable pointing to the teacher name in the add teacher form.
const subject_id = $("#teacher_id");

var totalValueOfStudent = 0;

// Function to toggle the sidebar.
const toggle = () => {
  $("body").toggleClass("sidebar-toggled");
  $(".sidebar").toggleClass("toggled");
  if ($(".sidebar").hasClass("toggled")) {
    $(".sidebar .collapse").collapse("hide");
  }
};

// Invocation of the toggle method.
toggle();

const init = () => {
  $.ajax({
    url: "../queries/class_view/get_class_details.php",
    type: "GET",
    dataSrc: "",
    data: {
      class_id: class_id,
    },
  })
    .done((response) => {
      const arr = JSON.parse(response);
      let class_name;
      arr.forEach((i) => {
        class_name = i.ClassName;
        pageHeading.html(class_name);
        pageTitle.html(`${class_name} || Details`);
        breadList.html(`${class_name}`);
        classInputId.html(class_name);
        class_name_input.val(class_name);
        $("#edit_date").val(`${i.CreationDate}`);
        stream2_name.html(i.sname);
        classTeacher.html(`<a href="">${i.tname}</a>`);
        creationdate.html(`${i.CreationDate}`);
        class_name_numeric.val(i.ClassNameNumeric);
      });
    })
    .fail((e) => {
      console.log(e);
    });
};

init();

// Object containing toasts that can be used in the stream.
const toast = {
  question: () => {
    return new Promise((resolve) => {
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
const view_class_table = $("#view_class_exams").DataTable({
  order: [[0, "DESC"]],
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
      targets: 1,
      data: {
        exam_name: "exam_name",
        id: "id",
      },
      render: function (data) {
        return `<a href="./class_exams?class_id=${class_id}&id=${data.id}"> ${data.exam_name} </a>`;
      },
    },
    {
      targets: 3,
      data: "year_name",
    },
    {
      targets: 0,
      data: "created_at",
    },
    {
      targets: 2,
      data: "t_name",
    },
    {
      targets: 4,
      data: "status",
      render: function (data) {
        if (data == 1) {
          return `<span class="badge badge-pill badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-pill badge-danger">Locked</span>`;
        }
      },
    },
    {
      targets: 5,
      data: "id",
      orderable: false,
      width: "10%",
      render: function (data) {
        return `
        <a href=""><i class="fas fa-edit"></i></a>
        <a style = "color:red" onClick="deleteExam(${data})"><i class="fas fa-trash"></i></a>


        `;
      },
    },
  ],
});

// Students datatables
const view_class_student = $("#view_class_student").DataTable({
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
      data: {
        FirstName: "FirstName",
        OtherNames: "OtherNames",
        LastName: "LastName",
      },
      render: (data) => {
        return data.FirstName + " " + data.OtherNames + " " + data.LastName;
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
      data: "Gender",
    },
    {
      targets: 4,
      data: "Status",
      render: function (data) {
        if (data === "1") {
          return `<span class="badge badge-pill badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-pill badge-danger">InActive</span>`;
        }
      },
    },
    {
      targets: 5,
      orderable: false,
      data: "StudentId",
      width: "10%",
      render: function (data) {
        let string = `
            <a href="" title="Make Student Inactive"><i class="fas fa-edit"></i></a>
            <a title="Remove Student From Class" style = "color:red"
              onClick="deleteStudent(${data})">
                <i class="fas fa-trash"></i>
            </a>
        `;
        return string;
      },
    },
  ],
});

// Function to delete a student from a stream
const deleteStudent = (studentId) => {
  toast.question().then(() => {
    $.ajax({
      url: "../queries/delete_student_from_stream.php",
      type: "GET",
      data: {
        studentId: studentId,
      },
    })
      .done((response) => {
        const j = JSON.parse(response);
        if (j.success == true) {
          iziToast.success({
            type: "Success",
            position: "topRight",
            transitionIn: "bounceInLeft",
            message: j.message,
            onClosing: () => {
              view_class_student.ajax.reload(null, false);
            },
          });
        } else {
          iziToast.error({
            type: "Error",
            position: "topRight",
            transitionIn: "bounceInLeft",
            message: j.message,
          });
        }
      })
      .fail(() => {
        iziToast.error({
          type: "Error",
          position: "topRight",
          transitionIn: "bounceInLeft",
          message: "Something went Wrong!! Please try again later.",
        });
      });
  });
};

// view all the subjects in a stream.
const view_class_subjects = $("#view_class_subjects").DataTable({
  ajax: {
    url: "../queries/get_class_subjects.php",
    type: "GET",
    dataSrc: "",
    data: {
      class_id: class_id,
    },
  },
  columnDefs: [
    {
      targets: 0,
      data: "SubjectName",
      render: (data) => {
        return `<a href="/subjects/subject" target ="_blank">${data}</a>`;
      },
    },
    {
      targets: 1,
      data: "SubjectCode",
    },
    {
      targets: 2,
      data: {
        teacherName: "teacherName",
        teacher_id: "teacher_id",
      },
      render: function (data) {
        return `<a href="/teachers/pages/view_teacher?teachers_id=${data.teacher_id}">${data.teacherName}</a>`;
      },
    },
    {
      targets: 3,
      data: "status",
      render: function (data) {
        if (data === "1") {
          return `<span class="badge badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-success">Inactive</span>`;
        }
      },
    },
    {
      targets: 4,
      data: "id",
      width: "10%",
      orderable: false,
      render: function (data) {
        return `
        <a href=""><i class="fas fa-edit"></i></a>
        <a style="color:red" onClick="deleteSubject(${data})">
         <i class="fas fa-trash"></i> </a>`;
      },
    },
  ],
});

// Delete subject from a stream.
const deleteSubject = (subjectId) => {
  toast.question().then(() => {
    $.ajax({
      url: "../queries/delete_subject_from_stream.php",
      type: "GET",
      data: {
        subjectId: subjectId,
        class_id: class_id,
      },
    })
      .done((response) => {
        let i = JSON.parse(response);
        if (i.success == true) {
          iziToast.success({
            type: "Success",
            message: i.message,
            position: "topRight",
            transitionIn: "bounceInLeft",
            onClosing: () => {
              view_class_subjects.ajax.reload(null, false);
            },
          });
        } else {
          iziToast.error({
            type: "Error",
            message: i.message,
            position: "topRight",
            transitionIn: "bounceInLeft",
          });
        }
      })
      .fail(() => {
        iziToast.error({
          type: "Error",
          message: "Failed loading page. Please try again",
          position: "topRight",
          transitionIn: "bounceInLeft",
        });
      });
  });
};

// Add an exam to a class event handler.
view_class_submit.click((e) => {
  e.preventDefault();

  const formData = {
    exam_id: examInput.val(),
    year_id: yearInput.val(),
    term_id: termInput.val(),
    class_id: class_id,
  };

  $.ajax({
    url: "../queries/add_class_exam.php",
    type: "POST",
    data: formData,
  }).done((response) => {
    const s = JSON.parse(response);
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

// fucntion to get all the students and place them in a variable.
const get_total_students = () => {
  $.ajax({
    url: "../queries/get_total_students.php",
    type: "GET",
    data: {
      class_id: class_id,
    },
  })
    .done((response) => {
      let r = JSON.parse(response);
      r.forEach((i) => {
        totalValueOfStudent = i.students;
        totalStudentsInClass.html(i.students);
      });
    })
    .fail((error) => {
      iziToast.error({
        type: "Error",
        message: error,
      });
    });
};

// function to get the total number of exams a stream sats for.
const get_total_exams_in_class = () => {
  $.ajax({
    url: "../queries/get_total_exams_in_class.php",
    type: "GET",
    data: {
      class_id: class_id,
    },
  }).done((response) => {
    const r = JSON.parse(response);
    r.forEach((i) => {
      totalExamInStream.html(i.exams);
    });
  });
};

// function to hold the number of subjects a stream has.
const total_subjects_in_class = () => {
  $.ajax({
    url: "../queries/get_total_subjects_in_class.php",
    type: "GET",
    data: {
      class_id: class_id,
    },
  }).done((response) => {
    const e = JSON.parse(response);
    e.forEach((i) => {
      totalSubjectsInClass.html(i.subjects);
    });
  });
};

// This is the chart method definition. Settings and Options are declared here.
// Datasets are populated from an ajax request
// class and class_exam id are passed as argurments.
const reloadChart = () => {
  $.ajax({
    url: "../queries/class_view/get_exam_performance_for_class.php",
    type: "GET",
    data: {
      class_id: class_id,
    },
    dataSrc: "",
  }).done((response) => {
    const arr = JSON.parse(response);

    const en = [],
      em = [];

    arr.forEach((object) => {
      en.push(object.exam_name);
      let tt = Math.round(object.total / object.stdcnt);
      em.push(tt);
    });

    var myChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: en,
        datasets: [
          {
            label: "Total Marks",
            data: em,
            borderWidth: 0,
            backgroundColor: "blue",
          },
        ],
      },
      options: {
        scales: {
          xAxes: [
            {
              gridLines: {
                display: false,
                drawBorder: true,
              },
              maxBarThickness: 50,
            },
          ],

          yAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: true,
                borderDash: [2],
                zeroLineBorderDash: [2],
              },
            },
          ],
        },
      },
    });
  });
};

const deleteExam = (examId) => {
  toast.question().then(() => {
    $.ajax({
      url: "../queries/delete_class_exam.php",
      type: "POST",
      data: {
        class_exam_id: examId,
      },
    })
      .done((response) => {
        const r = JSON.parse(response);
        if (r.success === true) {
          iziToast.success({
            type: "Success",
            message: r.message,
            onClosing: () => {
              view_class_table.ajax.reload(null, false);
              get_total_exams_in_class();
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
};

const getSubjectTeacher = (val) => {
  $.ajax({
    url: "../queries/get_subject_teacher.php",
    type: "get",
    data: {
      subject_id: val,
    },
  }).done(function (response) {
    let res = JSON.parse(response);
    res.forEach((element) => {
      subject_id.append(
        `<option value="${element.teacher_id}">${element.name}</option>`
      );
    });
  });
};

add_teacher_form.click((e) => {
  formData = {
    class_id: class_id,
    subject_id: $("#subject_id").val(),
    teacher_id: $("#teacher_id").val(),
  };

  $.ajax({
    url: "../queries/add_subject_to_class.php",
    type: "post",
    data: formData,
    dataSrc: "",
  }).done(function (response) {
    let r = JSON.parse(response);
    if (r.success === true) {
      iziToast.success({
        title: "Success",
        icon: "fas fa-user-graduate",
        transitionIn: "bounceInLeft",
        position: "topRight",
        message: r.message,
        onClosing: function () {
          view_class_subjects.ajax.reload(null, false);
          total_subjects_in_class();
        },
      });
    } else {
      iziToast.error({
        title: "Error",
        icon: "fas fa-user-graduate",
        transitionIn: "bounceInLeft",
        position: "bottomRight",
        message: r.message,
      });
    }
  });

  e.preventDefault();
});

// Initialization of the functions.
get_total_students();
get_total_exams_in_class();
total_subjects_in_class();
reloadChart();

edit_class_form_submit.click((e) => {
  const formData = {
    class_id: class_id,
    edit_class_name: $("#edit_class_name").val(),
    edit_class_code: $("#edit_class_name_numeric").val(),
    edit_stream: $("#edit_stream_id").val(),
    edit_date: $("#edit_date").val(),
    edit_teacher: $("#edit_teacher").val(),
  };

  $.ajax({
    url: "../queries/class_view/edit_class.php",
    type: "POST",
    data: formData,
  }).done((response) => {
    const arr = JSON.parse(response);
    if (arr.success == true) {
      iziToast.success({
        type: "Success",
        position: "topRight",
        transitionIn: "bounceInRight",
        message: arr.message,
        onClosing: function () {
          $("#edit_this_class").modal("hide");
          init();
        },
      });
    } else {
      iziToast.error({
        type: "Error",
        position: "topRight",
        transitionIn: "bounceInRight",
        message: arr.message,
      });
    }
  });

  e.preventDefault();
});

const getAcademicYears = () => {
  $.ajax({
    url: "../queries/class_view/get_academic_years.php",
    type: "GET",
    dataSrc: "",
  }).done((resp) => {
    const arr = JSON.parse(resp);
    arr.forEach((item) => {
      yearInput.append(
        `<option value="${item.year_id}">${item.year_name}</option>`
      );
    });
  });
};

getAcademicYears();

const getAcademicTerms = (year_id) => {
  $.ajax({
    url: "../queries/class_view/get_academic_term.php",
    type: "GET",
    dataSrc: "",
    data: {
      year_id: year_id,
    },
  }).done((resp) => {
    const arr = JSON.parse(resp);
    arr.forEach((item) => {
      termInput.append(
        `<option value="${item.term_year_id}">${item.name}</option>`
      );
    });
  });
};

// Interval between method calls.
setInterval(function () {
  view_class_student.ajax.reload(null, false);
  view_class_table.ajax.reload(null, false);
  view_class_subjects.ajax.reload(null, false);
  get_total_students();
  get_total_exams_in_class();
  total_subjects_in_class();
}, 100000);
// });
