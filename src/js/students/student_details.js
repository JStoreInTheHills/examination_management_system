// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

const queryString = window.location.search; // points to the url and store the value in a constiable
const urlParams = new URLSearchParams(queryString); // the url is passed as an argurment to the search

const _token = sessionStorage.getItem("_token");
// Edit student button
const edit_students = $("#edit_students").html("Edit Student");

const pupil = {};

const makeStudentInactive = $("#makeStudentInactive");

makeStudentInactive.hide();

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

function get_details() {
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

    arr.forEach((item) => {
      pupil.FirstName = item.FirstName;
      pupil.LastName = item.LastName;
      pupil.OtherNames = item.OtherNames;
      pupil.age = item.age;
      pupil.Gender = item.Gender;
      pupil.DOB = item.DOB;
      pupil["RegDate"] = item.RegDate;
      pupil["RollId"] = item.RollId;
      pupil["Status"] = item.Status;
      pupil["StreamName"] = item.name;
      pupil["ClassName"] = item.ClassName;
      class_id = item.id;
    });

    checkIfStudentIsInactive();
    populateStudentsDetails();
  });

  function populateStudentsDetails() {
    $("#title").html(
      `${pupil.FirstName} ${pupil.OtherNames} ${pupil.LastName}`
    );

    $("#heading").html(
      `${pupil.FirstName} ${pupil.OtherNames} ${pupil.LastName}`
    );
    $("#nav").html(`${pupil.FirstName} ${pupil.OtherNames} ${pupil.LastName}`);

    $("#students_name").html(
      `<span>Name:</span><span class="text-gray-900"> ${pupil.FirstName} ${pupil.OtherNames} ${pupil.LastName}
        </span>`
    );

    $("#Gender").html(
      `<span>Gender:</span><span class="text-gray-900"> ${pupil.Gender}</span>`
    );
    // $("#DOB").html(
    //   `<span>Date Of Birth:</span><span class="text-gray-900"> ${pupil.DOB}</span>`
    // );
    $("#RegDate").html(
      `<span>Date Of Registration:</span><span class="text-gray-900"> ${pupil.RegDate}</span>`
    );
    // $("#age").html(
    //   `<span>Age:</span> <span class="text-gray-900"> ${pupil.age} years</span>`
    // );
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

get_details();

const overal_exam_table = $("#overrall_exam_table").DataTable({
  order: [[2, "desc"]],
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
      data: {
        exam_name: "exam_name",
        id: "id",
      },
      render: function (data) {
        return `
            <a target="_blank" href="/reports/students/report_card?sid=${stdid}&cid=${class_id}&ceid=${data.id}">
              ${data.exam_name}
            </a>`;
      },
    },
    {
      targets: 1,
      data: "mar",
      width: "20%",
    },

    {
      targets: 2,
      data: "year_name",
    },
  ],
});

const populateChart = () => {
  var ctx = document.getElementById("myAreaChart");
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
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
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
            gridLines: {
              display: true,
              drawBorder: true,
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
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
    </div>`);

    makeStudentInactive.html(`Make InActive`);
  } else {
    $("#alert").html(`
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>This is an InActive Student.</strong>
      <hr>
          <p>The student could be having arrears or has not cleared with Finance. Kindly consult with the Mudhir or the Accounts Department.</p>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
    </div>`);
    makeStudentInactive.html(`Make Active`);
  }
}

$(document).ajaxComplete(function () {
  makeStudentInactive.show();
});

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

setInterval(() => {
  populateChart();
  overal_exam_table.ajax.reload(null, false);
}, 200000);
