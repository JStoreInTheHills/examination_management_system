/**
 * This is the Class Exam Main JS file.
 * It contains subject performance table, student result table and the subject performance chart
 * the chart, the subject performance table and the student result table refresh after 100000 ms.
 * the heading is appended from this file.
 * the rest of the code uses the above variables to query the database using ajax jquery calls.
 *
 * Author: Salim Juma.
 */

// $(document).ready(() => {
const queryString = window.location.search; // points to the url and store the value in a constiable
const urlParams = new URLSearchParams(queryString); // the url is passed as an argurment to the search

const class_exam_id = urlParams.get("id"); // the pointer holds the value that match the passed argurment
const cid = urlParams.get("class_id"); // the pointer also holds the value of the matching passed value

// pointer to the html element.
// Setting the heading and the page title using jquery.
const page_title = $("#page_title");
const page_heading = $("#heading");
const exam_flag = $("#exam_flag");
const class_name_navbar_link = $("#class_name_navbar_link");
const active_class_exam = $("#class_exam_active");
const alerts = $("#alert");
const classSelectElement = $("#class");
const class_exam_ids_element = $("#class_exam_id");
const lock_exam_button = $("#lock_exam");
const exam_creation_date_element = $("#academic_year");
const add_result_button = $("#add_result");
const best_performed_subject_element = $("#best_performed_subject");
const subject_teacher = $("#subject_teacher");
const studentsId = $("#studentid");

const ctx = document.getElementById("chart").getContext("2d");
const student_ctx = document.getElementById("students_chart").getContext("2d");

const best_performed_studentElement = $("#best_performed_student");
const total_students_sat_for_exam = $("#total_students_sat_for_exam");

const a = document.getElementById("class_name_navbar_link");
const print_subject_results = $("#print_subject_results");

const checkIfResultIsDeclared = () => {
  if (exam_status == 0) {
    alerts.html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>This Exam has been locked from editing.</strong>
    <hr>
        <p class="mb-0">Either all results have been declared or the exam is no longer available for editing. 
        Kindly Contact Administrator</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>`);
  } else {
    alerts.html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>This is an active Exam. </strong>
    <hr>
        <p class="mb-0">Click the Add Result to add a new results.</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>`);
  }
};

// This the students performance chart.
const populateStudentsChart = () => {
  $.ajax({
    url: "../queries/class_exam/get_students_performance_to_chart.php",
    type: "GET",
    data: {
      class_exam_id: class_exam_id,
      cid: cid,
    },
    dataSrc: "",
  }).done(function (response) {
    const performanceData = JSON.parse(response);

    let studentsname = [];
    let studentsmarks = [];

    performanceData.forEach((items) => {
      studentsmarks.push(items.total);
      studentsname.push(`${items.FirstName} ${items.OtherNames}`);
    });

    var myStudentsChart = new Chart(student_ctx, {
      type: "bar",
      data: {
        labels: studentsname,
        datasets: [
          {
            label: "Total Marks",
            data: studentsmarks,
            backgroundColor: "rgb(0,0,255)",
            borderWidth: 0,
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
                offsetGridLines: true,
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
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [0],
              },
            },
          ],
        },
      },
    });
  });
};

var class_name;

// this is the exam name
var exam_name;

// this is the exam_id
var exam_id;

// this is the creationDate.
var created_at;

// pointer pointing to a local storage showing status of exams.
var exam_status;

// pointer holding the best performed subject.
var best_performed_subject;

// pointer holding the best performed student.
var best_performed_student;

var best_performed_student_max;

var best_performed_subject_teacher;

var total_students_who_sat_for_the_exam;

var class_total_students_count;

var exam_out_of;

// const init = () => {
//   $.ajax({
//     url: "",
//     data : {

//     }
//     type: "GET",
//   });
// };

/** fetches the class exams using ajax call.
    We are passing class id as an argurment and appending the result to a select element.
    We are also updating the alert element, the created date, the active flag
    we check the status of the exam here.
*/
const fetch_class_exams = () => {
  $.ajax({
    url: "../queries/fetch_class_exams.php",
    type: "GET",
    data: {
      cid: cid,
      class_exam_id: class_exam_id,
    },
  })
    .done((response) => {
      const j = JSON.parse(response);
      j.forEach((i) => {
        exam_id = i.class_exam_id;
        exam_name = i.exam_name;
        class_name = i.ClassName;
        created_at = parseInt(i.created_at);
        exam_status = i.status;
        exam_out_of = i.exam_out_of;
      });
      class_exam_ids_element
        .empty()
        .append(`<option value="${exam_id}">${exam_name}</option>`);
      exam_creation_date_element.html(created_at);
      classSelectElement
        .empty()
        .append(`<option value="${cid}">${class_name}</option>`);
      class_name_navbar_link.html(`${class_name}`);
      page_heading.html(`${class_name} ~ ${exam_name} Performance`);
      page_title.html(`${class_name} || ${exam_name} Performance`);
      active_class_exam.html(`${exam_name}`);
      a.href = `class_view?classid=${cid}`;

      if (exam_status == 1) {
        exam_flag.html(
          `<span class="badge badge-pill badge-success">Exam Is Active</span>`
        );
        lock_exam_button.html("Lock Exam");
        add_result_button.show();
      } else {
        exam_flag.html(
          `<span class="badge badge-pill badge-danger">Exam Is Locked</span>`
        );
        lock_exam_button.html("Unlock Exam");
        add_result_button.hide();
      }
      checkIfResultIsDeclared();
    })
    .fail((e) => {
      iziToast.info({
        type: "Info",
        position: "topRight",
        message:
          "Failed fetching Class Exam Details. Refresh the page to fetch class exam details",
      });
    });
};
fetch_class_exams();

/**
 * This is the students datatables. fetches the performance of students in an exam. The total and mean score are placed here
 * We pass the class and class_exam id as parameters for the call
 */
const class_exam_student_table = $("#class_exam_student_table").DataTable({
  order: [[1, "asc"]],
  ajax: {
    url: "../queries/fetch_class_exams_student_performance.php",
    type: "GET",
    dataSrc: "",
    data: {
      class_exam_id: class_exam_id,
      class_id: cid,
    },
  },
  columnDefs: [
    {
      targets: 1,
      width: "1%",
      data: "students_rank",
    },
    {
      targets: 2,
      data: {
        FirstName: "FirstName",
        students_id: "students_id",
        OtherNames: "OtherNames",
        LastName: "LastName",
      },
      render: (data) => {
        return `<a href="/students/pages/details?sid=${data.students_id}">${data.FirstName} ${data.OtherNames} ${data.LastName}</a>`;
      },
    },
    {
      targets: 3,
      data: "RollId",
    },
    {
      targets: 0,
      data: "created_at",
    },
    {
      targets: 6,
      data: "total", // this is the sum of all the marks of the student for that exam.
    },
    {
      targets: 4,
      data: {
        total: "total", // total marks of the students.
        subjects: "subjects", // string from group_concat values of the result.
        subject: "subject", //count of all the subject the class sits for
      },
      render: function (data) {
        let total_marks = data.total, // declaration of total marks.
          d = data.subjects; // declararion and assigning of the string concatenated .

        let l = d.split(","); // split the string to array and find the length of the array.
        if (data.subject == l.length) {
          // comparing the value of count subjects against length of the array.
          var total = total_marks / l.length;
          return total.toFixed(2);
        } else {
          return `__`; //return this if the student didnt sit for all the exams.
        }
      },
    },
    // {
    //   targets: 5,
    //   data: {
    //     total: "total",
    //     subject: "subject",
    //   },
    //   render: function (data) {
    //     var t = data.total;
    //     var s = data.subject;
    //     s = s * exam_out_of;

    //     var result = t / s;

    //     result = Math.round(result * 100);

    //     if (result >= 96) {
    //       return `<span class="text-success">Excellent</span>`;
    //     } else if ((result <= 95) & (result >= 86)) {
    //       return `<span class="text-success"> Very Good </span>`;
    //     } else if ((result <= 85) & (result >= 70)) {
    //       return `<span class="text-warning">Good</span>`;
    //     } else if ((result <= 69) & (result >= 50)) {
    //       return `<span class="text-info">Pass</span>`;
    //     } else {
    //       return `<span class="text-danger">Fail</span>`;
    //     }
    //   },
    // },
    {
      targets: 5,
      data: "subjects",
      render: function (data) {
        let d = data, //get the total subjects sat by the student in form of a string
          l = d.split(","); // remove the commas and convert to array`
        return l.length; // check the length of the array and output it.
      },
    },

    {
      targets: 7,
      orderable: false,
      data: {
        result_id: "result_id",
      },

      render: function (data) {
        return `
          <a target="_blank" href="/reports/students/report_card?sid=${data.students_id}&cid=${cid}&ceid=${class_exam_id}">
                  <i class="fas fa-file-pdf"></i>
          </a>    
          <a style="color:red" onClick=deleteResult(${data.result_id})><i class="fas fa-trash"></i></a>`;
      },
    },
  ],
});

//Invoaction of the students chart.
populateStudentsChart();

// The exam subject datatable. fetches the performance of students per subjects using average and total marks obtained.
// We pass the class and class_exam ids as parameters to be used to query the database.
const class_exam_subject = $("#class_exam_subject_table").DataTable({
  order: [[2, "desc"]],
  ajax: {
    url: "../queries/fetch_class_exam_subject_perrormance.php",
    type: "GET",
    dataSrc: "",
    data: {
      class_exam_id: class_exam_id,
      class_id: cid,
    },
  },
  columnDefs: [
    {
      targets: 0,
      data: {
        subject_id: "subject_id",
        SubjectName: "SubjectName",
      },
      render: function (data) {
        return `<a href="#">${data.SubjectName}</a>`;
      },
    },
    {
      targets: 1,
      data: "name",
    },
    {
      targets: 2,
      data: "marks",
    },
    {
      targets: 3,
      data: {
        concat: "concat",
        marks: "marks",
      },
      render: function (data) {
        var x = data.concat;
        var marks = data.marks;
        var y = x.split(",");
        return Math.round(marks / y.length);
      },
    },
  ],
});

/**
 *This is the chart method definition. Settings and Options are declared here.
 *Datasets are populated from an ajax requesting
 *class and class_exam id are passed as argurments.
 */
const reloadChart = () => {
  $.ajax({
    url: "/subjects/queries/get_chart1_data.php",
    type: "GET",
    data: {
      class_id: cid,
      class_exam_id: class_exam_id,
    },
  })
    .done(function (response) {
      const ds = JSON.parse(response); // Array of all subject Objects

      let label_array = []; // array that holds the charts label.
      let myChartDataSet = []; // array that holds the chart datasets data.

      ds.forEach((i) => {
        label_array.push(i.SubjectName); // pushes subjectnames to the the subject pointer.
        myChartDataSet.push(i.total);
      });

      var myChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: label_array,
          datasets: [
            {
              label: "Subject Total Marks",
              data: myChartDataSet,
              backgroundColor: "rgb(192, 0, 192)",
              borderWidth: 0,
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
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2],
                },
              },
            ],
          },
        },
      });
    })
    .fail(function (e) {
      console.log(e);
    });
};

// Invocation of the function methods. the reloadChart fetch_class and fetch_class_exams functions.
reloadChart();

const toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.info({
        title: "WARNING",
        icon: "fa fa-exclamation-triangle",
        message: `You are about to delete a Students Result! 
                  Are you sure of this command?`,
        timeout: 20000,
        close: false,
        transitionIn: "bounceInLeft",
        position: "center",
        buttons: [
          [
            "<button><b>YES</b></button>",
            function (instance, toast, button, e, inputs) {
              instance.hide(
                {
                  transitionOut: "fadeOut",
                },
                toast,
                "button"
              );
              resolve();
            },
            false,
          ],
          [
            "<button>NO</button>",
            function (instance, toast, button, e, inputs) {
              instance.hide(
                {
                  transitionOut: "fadeOut",
                },
                toast,
                "button"
              );
            },
          ],
        ],
      });
    });
  },
};

/**
 * Function to delete a result from the exam.
 * @param {*} result_id
 */
const deleteResult = (result_id) => {
  toast.question().then(function () {
    $.ajax({
      url: "../queries/delete_students_exam_result.php",
      type: "POST",
      data: {
        result_id: result_id,
      },
    });
  });
};

// get the subjects and students for that class.
const getStudent = (cid) => {
  $.ajax({
    type: "GET",
    url: "../queries/get_student.php",
    data: {
      classid: cid,
    },
    success: (data) => {
      $("#studentid").html(data);
    },
  });
  $.ajax({
    type: "GET",
    url: "../queries/get_student.php",
    data: {
      classid1: cid,
    },
    success: (data) => {
      $("#subject").html(data);
    },
  });
};

getStudent(cid);

// get the results
const getresult = (val, clid) => {
  var formData = {
    clid: $(".clid").val(),
    val: $(".stid").val(),
    class_exam_id: class_exam_id,
  };
  // console.log(formData);
  $.ajax({
    type: "GET",
    url: "../queries/get_student.php",
    data: formData,
    success: function (data) {
      $("#reslt").html(data);
    },
  });
};

// Form submission.
$("#result_form").submit((e) => {
  let l = $(".marks").length; // getting the length of the class element marks
  let result = []; // creating an empty array.

  for (let i = 0; i < l; i++) {
    result.push($(".marks").eq(i).val());
  }
  var formData = {
    class: cid,
    studentid: studentsId.val(),
    marks: result,
    class_exam_id: class_exam_id,
  };

  $.ajax({
    url: "../queries/add_results.php",
    data: formData,
    method: "POST",
  }).done((response) => {
    const s = JSON.parse(response);
    if (s.success === true) {
      iziToast.success({
        title: "Success",
        position: "topRight", // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
        message: s.message,
        transitionIn: "bounceInRight",
        onClosing: function () {
          class_exam_student_table.ajax.reload(null, false);
          reloadChart();
          populateStudentsChart();
          get_best_performed_student();
          $("#result_form").each(function () {
            this.reset();
          });
        },
      });
    } else {
      iziToast.error({
        title: "Error",
        position: "topRight", // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter, center
        message: s.message,
      });
    }
  });
  e.preventDefault();
});

// function to print the cards result in pdf form

$("#print_class_result").click(() => {
  window.open(
    `/reports/class/class_exam_report?cid=${cid}&ceid=${class_exam_id}`
  );
});

// print the subject result of the stream.
print_subject_results.click(() => {
  window.open(
    `/reports/class/class_exam_subject?cid=${cid}&ceid=${class_exam_id}`
  );
});

// function to lock an exam from editing.
lock_exam_button.click((e) => {
  let status; // this variable only exists on this function.

  if (exam_status == 0) {
    status = 1;
  } else {
    status = 0;
  }

  let formData = {
    class_id: cid,
    class_exam_id: class_exam_id,
    status: status,
  };

  $.ajax({
    url: "../queries/set_exam_inactive_or_active.php",
    data: formData,
    type: "GET",
  }).done(function (response) {
    const j = JSON.parse(response);
    if (j.success == "true") {
      iziToast.success({
        type: "Success",
        message: j.message,
        transitionIn: "bounceInLeft",
        position: "topRight",
        onClosing: function () {
          fetch_class_exams();
        },
      });
    }
  });
  e.preventDefault();
});

const formDataForBestStudentAndSubject = {
  class_id: cid,
  class_exam_id: class_exam_id,
};

const get_best_performed_subject = () => {
  $.ajax({
    url: "../queries/get_best_performed_subject.php",
    type: "GET",
    data: formDataForBestStudentAndSubject,
  }).done(function (response) {
    const j = JSON.parse(response);
    j.forEach((i) => {
      best_performed_subject_teacher = i.name;
      best_performed_subject = i.SubjectName;
      best_performed_subject_marks = i.max_total;
    });
    best_performed_subject_element.html(`
      ${best_performed_subject} (  ${best_performed_subject_marks} )
    `);
    subject_teacher.html(best_performed_subject_teacher);
  });
};

get_best_performed_subject();

const get_best_performed_student = () => {
  $.ajax({
    url: "../queries/get_best_performed_student.php",
    type: "GET",
    data: formDataForBestStudentAndSubject,
  }).done((response) => {
    let j = JSON.parse(response);
    j.forEach((i) => {
      best_performed_student = `${i.FirstName} ${i.OtherNames}`;
      best_performed_student_max = i.max;
    });
    best_performed_studentElement.html(
      `${best_performed_student} ( ${best_performed_student_max} )`
    );
  });
};

get_best_performed_student();

const get_number_of_students_sat_for_exam = () => {
  $.ajax({
    url: "../queries/get_number_of_students_sat_for_exam.php",
    type: "GET",
    data: formDataForBestStudentAndSubject,
  }).done(function (response) {
    const j = JSON.parse(response);
    j.forEach((i) => {
      total_students_who_sat_for_the_exam = i.exam_sat_count;
      class_total_students_count = i.class_total_students_count;
    });
    total_students_sat_for_exam.html(
      `${total_students_who_sat_for_the_exam} 
        Out of ${class_total_students_count} Students`
    );
  });
};

get_number_of_students_sat_for_exam();

// Refresh Time Intervals for all the queries updates.
setInterval(function () {
  class_exam_subject.ajax.reload(null, false);
  class_exam_student_table.ajax.reload(null, false);
  fetch_class_exams();
  get_best_performed_subject();
  get_best_performed_student();
  get_number_of_students_sat_for_exam();
}, 100000);

setInterval(function () {
  reloadChart();
  populateStudentsChart();
}, 10000000);
// });
