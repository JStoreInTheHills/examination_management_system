const queryString = window.location.search; // points to the url and store the value in a constiable
const urlParams = new URLSearchParams(queryString); // the url is passed as an argurment to the search

const stdid = urlParams.get("sid");
const cid = urlParams.get("cid");
const ceid = urlParams.get("ceid");

// Pointer pointing to the button on the DOM node.
const print_results = $("#print_results");

// Pointer pointing to the page title.
const page_title = $("#page_title");

// Pointer pointing to the title of the site.
const title = $("#title");

// total_sum_of_marks for all the subjects done.
const total_sum_of_marks = $("#total_sum_of_marks");

// function to get the students details.
async function init() {
  // Students details Assignment.
  let students_roll_id;
  let students_first_name;
  let students_last_name;
  let students_other_name;

  // pointer pointing to the
  const response = await fetch(
    `/students/chartjs/get_students_details.php?stdid=${stdid}`
  );
  const datas = await response.text();

  const parsed = JSON.parse(datas);

  parsed.forEach((row) => {
    students_roll_id = row.RollId;
    students_first_name = row.FirstName;
    students_last_name = row.LastName;
    students_other_name = row.OtherNames;
  });

  return {
    students_first_name,
    students_other_name,
    students_last_name,
    students_roll_id,
  };
}
// populate the data collected from the init function.
async function populateStudentsDetails() {
  const students_details = await init();
  page_title.html(
    `${students_details.students_first_name} ${students_details.students_other_name} ${students_details.students_last_name} ~ ${students_details.students_roll_id}`
  );
  title.html(
    `${students_details.students_first_name} ${students_details.students_other_name} || Exam Details`
  );
}

populateStudentsDetails();

// Setting the defaults.
print_results[0].href = `/reports/students/report_card?sid=${stdid}&cid=${cid}&ceid=${ceid}`;
print_results[0].class = "btn btn-outline-primary btn-md";
print_results.html(`Print This Result`);

// Invocation of the chart js method.
chartIt();

// Declaration of the chart js method.
async function chartIt() {
  const data = await getSubjectData();
  const ctx = document.getElementById("myAreaChart").getContext("2d");
  const myChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: data.xs,
      datasets: [
        {
          label: "Subject Performance (Marks) ",
          data: data.ys,
          backgroundColor: "rgba(255, 99, 132, 0.2)",
          borderColor: "rgba(255, 99, 132, 1)",
          borderWidth: 2,
          fill: true,
          pointRadius: 3,
          pointBackgroundColor: "rgba(255, 99, 132, 0.2)",
          pointBorderColor: "rgba(255, 99, 132, 0.2)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(255, 99, 132, 0.2)",
          pointHoverBorderColor: "rgba(255, 99, 132, 0.2)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 5,
          right: 5,
          top: 20,
          bottom: 5,
        },
      },
      scales: {
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
        displayColors: true,
        intersect: false,
        mode: "index",
        caretPadding: 10,
      },
    },
  });
}

// Declaration of the getSubjectData to be used for the chart generation.
async function getSubjectData() {
  const xs = [];
  const ys = [];
  const response = await fetch(
    `/students/chartjs/get_students_subject_performance.php?stdid=${stdid}&ceid=${ceid}`
  );
  const datas = await response.text();

  const parsed = JSON.parse(datas);

  parsed.forEach((row) => {
    xs.push(row.SubjectName);
    ys.push(row.marks);
  });

  return { xs, ys };
}

const subject_performance = $("#subject_performance").DataTable({
  order: [[2, "desc"]],
  ajax: {
    url: "../queries/get_students_subject_result.php",
    data: {
      stdid: stdid,
      cid: cid,
      ceid: ceid,
    },
    dataSrc: "",
    type: "GET",
  },
  columnDefs: [
    {
      targets: 0,
      data: "SubjectName",
    },
    {
      targets: 1,
      data: "name",
    },
    {
      targets: 2,
      data: "marks",
    },
  ],
});

// Function to calculate the sum of all the subject performance for that Exam.
async function getSubjectTotalSum() {
  let totalSumOfSubjects;
  const response = await fetch(
    `/students/chartjs/getTotalSumOfSubject.php?sid=${stdid}&ceid=${ceid}`
  );
  const data = await response.text();

  const parsed = JSON.parse(data);

  totalSumOfSubjects = parsed;

  total_sum_of_marks.html(`${totalSumOfSubjects}`);
}

getSubjectTotalSum();
