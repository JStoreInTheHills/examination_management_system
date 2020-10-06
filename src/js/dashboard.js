// Official js page for the index page.

// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

// variable holding the gender url.
const gender_url = "/dashboard/queries/get_gender_count.php";

// variable holding the pie chart element.
const ctx = document.getElementById("myPieChart");

// Area Chart Example
const clx = document.getElementById("myAreaChart");

// variable holding the index title.
const index_title = $("#index_title");

edit_madrasa = $("#edit_madrasa");

// variable holding the index heading.
const index_heading = $("#index_heading");

NProgress.start();

const init = () => {
  $.ajax({
    url: "./admin/queries/get_school.php",
    type: "GET",
    dataSrc: "json",
  }).done((resp) => {
    const arr = JSON.parse(resp);
    arr.forEach((item) => {
      index_heading.html(item.school_name);
      const school = sessionStorage.setItem("school", item.school_name);
      index_title.html(`Home - ${item.school_name}`);
    });
    get_students_count();
    get_all_teachers();
    get_all_class();

    edit_madrasa.html("Edit Madrasa");

    NProgress.done();
  });
};

init();

//------------------------------------------------------------------------------------------------------

edit_madrasa.click(() => {});

// Function to populate the number of students in the school.
const get_students_count = () => {
  $.ajax({
    url: "dashboard/queries/get_students.php",
    type: "GET",
  }).done((response) => {
    const j = JSON.parse(response);
    j.forEach((items) => {
      $("#all_students").html(items.students);
    });
  });
};

// Function to populate the number of teachers in the school.
const get_all_teachers = () => {
  $.ajax({
    url: "dashboard/queries/get_teachers.php",
    type: "GET",
  }).done((response) => {
    let t = JSON.parse(response);
    $("#all_teachers").empty().append(t[0].teachers_id);
  });
};

// Function to populate the number of streams in the school.
const get_all_class = () => {
  $.ajax({
    url: "dashboard/queries/get_classes.php",
    type: "GET",
  }).done((response) => {
    const j = JSON.parse(response);
    $("#all_classes").empty().append(j[0].classes);
  });
};

const populate_students_ratio = () => {};

// Pie Chart Example
const myPieChart = new Chart(ctx, {
  type: "doughnut",
  data: {
    labels: ["Female", "Male"],
    datasets: [
      {
        data: [50, 50],
        backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"],
        hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf"],
      },
    ],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: "#dddfeb",
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: true,
      caretPadding: 10,
    },
    legend: {
      display: true,
    },
    cutoutPercentage: 0,
  },
});

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

const line_chart_options = {
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

var line_chart_data = {
  labels: ["Jan", "Feb", "Mar", "April"],
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
      data: [500, 200, 477, 300],
    },
  ],
};

const myLineChart = new Chart(clx, {
  type: "line",
  data: line_chart_data,
  options: line_chart_options,
});

setInterval(() => {
  get_students_count();
  get_all_class();
  get_all_teachers();
}, 1000000);
