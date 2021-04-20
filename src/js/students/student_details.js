// // Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

const queryString = window.location.search; // points to the url and store the value in a constiable
const urlParams = new URLSearchParams(queryString); // the url is passed as an argurment to the search

const _token = sessionStorage.getItem("_token");
// Edit student button
const edit_students = $("#edit_students").html("Edit Student");
const editStudentModalTitle = $("#editStudentModalTitle");
const first_name = $("#first_name");
const second_name = $("#second_name");
const last_name = $("#last_name");
const rollid = $("#rollid");
const telephone = $("#telephone");
const gender = $("#gender");
const classid = $("#classid");

const classidInput = $("#classid");
const edit_student_form = $("#edit_student_form");
const date = $("#date");
const students_id = $("#students_id");

const moveStudentToDifferentClass = $("#moveStudentToDifferentClass");

const pupil = {};

const makeStudentInactive = $("#makeStudentInactive");

var { stdid, class_id } = checkTokenization();

function checkTokenization() {
  if (_token == "Administrator") {
    var stdid = urlParams.get("sid");
    var class_id;
  } else {
    var stdid = sessionStorage.getItem("students_id");
    var class_id = sessionStorage.getItem("class_id");
  }
  return { stdid, class_id };
}

async function get_details() {
  makeStudentInactive.prop("disabled", true);
  var stat;
  var formData = {
    sid: stdid,
  };
  $.ajax({
    url: "../queries/get_students_details.php",
    type: "GET",
    data: formData,
  }).done(function (response) {
    const arr = JSON.parse(response);

    let data = {};

    arr.forEach((item) => {
      pupil.FirstName = item.FirstName;
      pupil.LastName = item.LastName;
      pupil.OtherNames = item.OtherNames;
      pupil.age = item.age;
      pupil.Gender = item.Gender;
      pupil.DOB = item.DOB;
      pupil.TelNo = item.TelNo;
      pupil["RegDate"] = item.RegDate;
      pupil["RollId"] = item.RollId;
      pupil["Status"] = item.Status;
      pupil["StreamName"] = item.name;
      pupil["ClassName"] = item.ClassName;
      class_id = item.id;

      data.ClassName = item.ClassName;
      data.id = item.id;
      populateModalWithStudentsDetails(item);
    });

    fillSelect2WithData(data);

    checkIfStudentIsInactive();
    populateStudentsDetails();
    makeStudentInactive.prop("disabled", false);
  });

  function populateStudentsDetails() {
    $("#title").html(
      `${pupil.FirstName} ${pupil.OtherNames} ${pupil.LastName} (${pupil.RollId})`
    );

    $("#heading").html(
      `${pupil.FirstName} ${pupil.OtherNames} ${pupil.LastName} (${pupil.RollId})`
    );
    $("#nav").html(`${pupil.FirstName} ${pupil.OtherNames} ${pupil.LastName}`);

    $("#students_name").html(
      `<span>Name:</span><span class="text-gray-900"> ${pupil.FirstName} ${pupil.OtherNames} ${pupil.LastName}
        </span>`
    );

    $("#Gender").html(
      `<span>Gender:</span><span class="text-gray-900"> ${pupil.Gender}</span>`
    );
    $("#DOB").html(
      `<span>Date Of Birth:</span><span class="text-gray-900"> ${pupil.DOB}</span>`
    );
    $("#TelNo").html(
      `<span>Telephone Number:</span><span class="text-gray-900"> ${pupil.TelNo}</span>`
    );
    $("#RegDate").html(
      `<span>Date Of Registration:</span><span class="text-gray-900"> ${pupil.RegDate}</span>`
    );
    $("#age").html(
      `<span>Age:</span> <span class="text-gray-900"> ${pupil.age} years</span>`
    );
    $("#RollId").html(
      `<span>Admission Number:</span><span class="text-gray-900"> ${pupil["RollId"]}</span>`
    );
    $("#stream_name").html(
      `<span>Class Name:</span><span class="text-gray-900"> ${pupil["ClassName"]}</span>`
    );
    if (pupil["Status"] === "1") {
      stat = `<span class="badge badge-pill badge-success">Active</span>`;
    } else {
      stat = `<span class="badge badge-pill badge-danger">InActive</span>`;
    }
    $("#status").html(
      `<span>Status:</span><span class="text-gray-900">  ${stat}</span>`
    );

    $("#class_name").html(
      `<span>Stream Name:</span><span class="text-gray-900"> ${pupil["StreamName"]}</span>`
    );
  }
}

function fillSelect2WithData(data) {
  var option = new Option(data.ClassName, data.id, true, true);
  classidInput.append(option).trigger("change");
  classidInput.trigger({
    type: "select2:select",
    params: {
      data: data,
    },
  });
}

let overal_exam_table;

async function populateOverallExamTable() {
  await get_details();
  overal_exam_table = $("#overrall_exam_table").DataTable({
    order: [[0, "desc"]],
    ajax: {
      url: "../queries/populate_students_area_chart.php",
      type: "GET",
      dataSrc: "",
      data: {
        sid: stdid,
      },
    },
    columnDefs: [
      {
        targets: 0,
        data: "created_at",
      },
      {
        targets: 1,
        data: {
          exam_name: "exam_name",
          id: "id",
        },
        render: function (data) {
          return `
              <a href="/students/pages/students_exam_details?sid=${stdid}&cid=${class_id}&ceid=${data.id}">
                ${data.exam_name}
              </a>`;
        },
      },
      {
        targets: 4,
        data: "mar",
        width: "20%",
      },
      {
        targets: 2,
        data: "name",
      },
      {
        targets: 3,
        data: "year_name",
      },
    ],
  });
}

populateOverallExamTable();

const populateChart = () => {
  var ctx = document.getElementById("myAreaChart").getContext("2d");
  const formData = {
    sid: stdid,
  };
  $.ajax({
    url: "../queries/populate_students_area_chart.php",
    type: "GET",
    data: formData,
  }).done(function (response) {
    const ds = JSON.parse(response); // Array of all subject Objects

    // console.log(ds);
    var label_array = []; // array that holds the charts label.
    var myChartDataSet = []; // array that holds the chart datasets data.

    for (let i = 0; i < ds.length; i++) {
      let ds_items = ds[i];
      label_array.push(ds_items.exam_name); // pushes subjectnames to the the subject pointer.
      myChartDataSet.push(ds_items.mar);
    }
    var data = {
      labels: label_array,
      datasets: [
        {
          label: "Marks",
          lineTension: 0.3,
          backgroundColor: "rgba(255, 99, 132, 0.2)",
          borderColor: "rgba(255, 99, 132, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(255, 99, 132, 0.2)",
          pointBorderColor: "rgba(255, 99, 132, 0.2)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(255, 99, 132, 0.2)",
          pointHoverBorderColor: "rgba(255, 99, 132, 0.2)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: myChartDataSet,
        },
      ],
    };
    var options = {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0,
        },
      },
      scales: {
        xAxes: [
          {
            time: {
              unit: "date",
            },

            ticks: {
              maxTicksLimit: 7,
            },
          },
        ],
        yAxes: [
          {
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
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
      legend: {
        display: false,
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: "#6e707e",
        titleFontSize: 14,
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: "index",
        caretPadding: 10,
      },
    };
    var myLineChart = new Chart(ctx, {
      type: "line",
      data: data,
      options: options,
    });
  });
};

populateChart();

var toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.error({
        title: "Warning",
        icon: "fas fa-exclamation",
        transitionIn: "bounceInLeft",
        opacity: "100",
        zindex: 999,
        overlay: true,
        displayMode: "once",
        message: "Are you sure you want to change the status of this student?",
        timeout: 2000000,
        close: false,
        position: "center",
        messageColor: "black",
        titleSize: "50",
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

function checkIfStudentIsInactive() {
  if (pupil.Status === "1") {
    $("#alert").html(`
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Use this page to view name, admission number and class of the students.</strong>
      <hr>
          <p class="mb-0">Active students are denoted by <span class="badge badge-pill badge-success">Active</span> while In Active students are denoted by <span class="badge badge-pill badge-danger">Inactive</span> </p>
    </div>`);

    makeStudentInactive.html(`Make InActive`);
  } else {
    $("#alert").html(`
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>This is an InActive Student.</strong>
      <hr>
          <p>The student could be having arrears or has not cleared with Finance. Kindly consult with the Mudhir or the Accounts Department.</p>
    </div>`);
    makeStudentInactive.html(`Make Active`);
  }
}

makeStudentInactive.click(() => {
  let status;
  if (pupil.Status == 1) {
    status = 0;
  } else {
    status = 1;
  }
  toast.question().then(() => {
    $.ajax({
      url: "../queries/makeStudentInactive.php",
      type: "POST",
      data: {
        student_id: stdid,
        status: status,
      },
    })
      .done((response) => {
        const arr = JSON.parse(response);
        if (arr.success === "true") {
          iziToast.success({
            type: "Success",
            transitionIn: "bounceInLeft",
            message: arr.message,
            onClosing: function () {
              get_details();
            },
          });
        } else {
          iziToast.error({
            type: "Error",
            message: arr.message,
          });
        }
      })
      .fail((error) => {
        console.log("Fail");
      });
  });
});

edit_students.click(() => {
  $("#exampleModalCenter").modal("show");
});

function populateModalWithStudentsDetails(item) {
  editStudentModalTitle.html(
    `${item.FirstName} ${item.OtherNames} ${item.LastName}`
  );
  first_name.val(item.FirstName);
  second_name.val(item.OtherNames);
  last_name.val(item.LastName);
  rollid.val(item.RollId);
  telephone.val(item.TelNo);
  gender.val(item.Gender);
  classid.val(item.id);
  date.val(item.DOB);
  students_id.val(stdid);
}

edit_student_form.validate({
  rules: {
    first_name: "required",
    telephone_no: "required",
    second_name: "required",
    last_name: "required",
    rollid: "required",
    telephone: "required",
    gender: "required",
    classid: "required",
    dob: {
      required: true,
      dateISO: true,
    },
  },
  errorClass: "text-danger",
  submitHandler: (form) => {
    $.ajax({
      url: "../queries/edit_students_details.php",
      type: "POST",
      data: $(form).serialize(),
    }).done((response) => {
      const resp = JSON.parse(response);
      checkIfSuccessIsFalse(resp);
    });
  },
});

function checkIfSuccessIsFalse(resp) {
  if (resp.success == true) {
    iziToast.success({
      message: resp.message,
      displayMode: "once",
      transitionIn: "fadeInUp",
      position: "topRight",
      onClosing: () => {
        updateDetails();
      },
    });
  } else {
    iziToast.error({
      message: resp.message,
      displayMode: "once",
      transitionIn: "fadeInUp",
      position: "topRight",
    });
  }
}

function updateDetails() {
  get_details();
  $("#exampleModalCenter").modal("hide");
}

moveStudentToDifferentClass.html(`Move Student To Different Class`);
moveStudentToDifferentClass.click(() => {
  $("#moveToDifferentClass").modal("show");
});

classid.select2({
  placeholder: "Type to choose the class to add the student",
  theme: "bootstrap4",
  ajax: {
    url: "../queries/getAllClasses.php",
    type: "POST",
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

const term_performance_table = $("#term_performance_table").DataTable({
  order: [[1, "desc"]],
  ajax: {
    url: "../queries/fetch_term.php",
    type: "GET",
    dataSrc: "",
    data: {},
  },
  columnDefs: [
    {
      targets: 0,
      data: {
        name: "name",
        year_id: "year_id",
        term_year_id: "term_year_id",
      },
      render: function (data) {
        return `<a target="_blank" href="/reports/class/module/term/exam_report?year_id=${data.year_id}&&term_id=${data.term_year_id}&&cid=${class_id}&&sid=${stdid}">${data.name}</a>`;
      },
    },
    {
      targets: 1,
      data: "year_name",
    },
  ],
});
setInterval(() => {
  populateChart();
  overal_exam_table.ajax.reload(null, false);
}, 200000);

// chartIt();

// // async funxtion to fetch the students subject Performance.
// async function chartIt() {
//   const data = await getSubjectData();
//   var ctx = document.getElementById("mySubjectChart").getContext("2d");
//   var myChart = new Chart(ctx, {
//     type: "line",
//     data: {
//       labels: data.xs,
//       datasets: [
//         {
//           label: "Student Subject Performance for The Exams",
//           data: data.ys,
//           fill: true,
//           backgroundColor: "rgba(255, 99, 132, 0.2)",
//           borderColor: "rgba(255, 99, 132, 1)",
//           borderWidth: 1,
//           pointHitRadius: 10,
//           pointBorderWidth: 2,
//         },
//       ],
//     },
//     options: {
//       scales: {
//         yAxes: [
//           {
//             ticks: {
//               beginAtZero: true,
//             },
//           },
//         ],
//       },
//     },
//   });
// }

// async function getSubjectData() {
//   const xs = [];
//   const ys = [];
//   const response = await fetch(
//     `/students/chartjs/get_students_subject_performance.php?stdid=${stdid}`
//   );
//   const datas = await response.text();

//   const parsed = JSON.parse(datas);

//   parsed.forEach((row) => {
//     xs.push(row.SubjectName);
//     ys.push(row.marks);
//   });

//   return { xs, ys };
// }

const academic_year_performance = $("#academic_year_performance").DataTable({
  order: [[1, "desc"]],
  ajax: {
    url: "../queries/fetch_academic_year.php",
    dataSrc: "",
    type: "GET",
  },
  columnDefs: [
    {
      targets: 0,
      data: {
        year_name: "year_name",
        year_id: "year_id",
      },
      render: (data) => {
        return `<a target="_blank" href="/reports/academic_year/students_academic_year_result.php?sid=${stdid}&cid=${class_id}&year_id=${data.year_id}">${data.year_name}</a>`;
      },
    },
    {
      targets: 1,
      data: "created_at",
    },
  ],
});
