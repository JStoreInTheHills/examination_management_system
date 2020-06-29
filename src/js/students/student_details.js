// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

var queryString = window.location.search; // points to the url and store the value in a variable
var urlParams = new URLSearchParams(queryString); // the url is passed as an argurment to the search
var students_id = urlParams.get("sid");

function populate_exam() {
  let formData = {
    sid: students_id,
  };

  $("#overrall_exam_table").DataTable({
    order: [[3, "desc"]],
    ajax: {
      url: "../queries/populate_students_area_chart.php",
      type: "GET",
      dataSrc: "",
      data: formData,
    },
    columnDefs: [
      {
        targets: 0,
        data: "exam_name",
        render: function (data) {
          return `<a href="">${data}</a>`;
        },
      },
      {
        targets: 1,
        data: "mar",
        width: "20%",
      },
      {
        targets: 2,
        data: "mar",
        width: "10%",
        render: function (data) {
          if (data >= 450) {
            return `A`;
          } else {
            return `B`;
          }
        },
      },
      {
        targets: 3,
        data: "year_name",
      },
    ],
  });
}

populate_exam();

function get_details() {
  var stat;
  var formData = {
    sid: students_id,
  };
  $.ajax({
    url: "../queries/get_students_details.php",
    type: "GET",
    data: formData,
  }).done(function (response) {
    let arr = JSON.parse(response);

    let Students_Name = arr[0].StudentName;

    $("#title").append(`${Students_Name} || Details`);
    $("#heading").append(`${Students_Name}`);
    $("#nav").append(`${Students_Name}`);
    $("#students_name").append(
      `<span class="text-gray-900"> ${Students_Name}</span>`
    );

    $("#Gender").append(
      ` <span class="text-gray-900"> ${arr[0].Gender}</span>`
    );
    $("#DOB").append(` <span class="text-gray-900"> ${arr[0].DOB}</span>`);
    $("#RegDate").append(
      ` <span class="text-gray-900"> ${arr[0].RegDate}</span>`
    );
    $("#age").append(
      ` <span class="text-gray-900"> ${arr[0].age} years</span>`
    );
    $("#RollId").append(`<span class="text-gray-900"> ${arr[0].RollId}</span>`);
    $("#stream_name").append(
      `<span class="text-gray-900"> ${arr[0].ClassName}</span>`
    );
    if (arr[0].Status === "1") {
      stat = `<span class="badge badge-pill badge-success">Active</span>`;
    } else {
      stat = `<span class="badge badge-pill badge-danger">InActive</span>`;
    }
    $("#status").append(`<span class="text-gray-900"> ${stat}</span>`);
    $("#class_name").append(
      `<span class="text-gray-900"> ${arr[0].name}</span>`
    );
  });
}
get_details();

function populateChart() {
  var ctx = document.getElementById("myAreaChart");
  let formData = {
    sid: students_id,
  };
  $.ajax({
    url: "../queries/populate_students_area_chart.php",
    type: "GET",
    data: formData,
  }).done(function (response) {
    var ds = JSON.parse(response); // Array of all subject Objects

    console.log(ds);
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
}

populateChart();

setInterval(() => {
  populateChart();
}, 200000);
