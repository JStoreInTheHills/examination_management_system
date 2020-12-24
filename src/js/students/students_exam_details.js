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

const exam_name = $("#exam_name");
const exam_out_of = $("#exam_out_of");

// Node of the average marks DOM element
const average_marks = $("#average_marks");

// Percentage marks Node DOM element.
const percentage_marks = $("#percentage_marks");

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
  const total_marks_overal = await getTotalOveralOutOfMarks();
  let totalSumOfSubjects;
  const response = await fetch(
    `/students/chartjs/getTotalSumOfSubject.php?sid=${stdid}&ceid=${ceid}`
  );
  const data = await response.text();

  const parsed = JSON.parse(data);

  totalSumOfSubjects = parsed;

  total_sum_of_marks.html(
    `${totalSumOfSubjects} / ${total_marks_overal.total_overal_marks}`
  );

  return { totalSumOfSubjects };
}

async function getOutOfMarksForTheExam() {
  let exam_out_of;
  let exam_name;
  const response = await fetch(
    `/students/chartjs/get_exam_out_of_value.php?cid=${cid}$&ceid=${ceid}`
  );
  const data = await response.text();
  const parsed = JSON.parse(data);

  parsed.forEach((item) => {
    exam_name = item.exam_name;
    exam_out_of = item.exam_out_of;
  });
  return { exam_name, exam_out_of };
}

getSubjectTotalSum();

// Async function to get the exam name and exam out of value.
async function populateExamDetails() {
  const exam_obj = await getOutOfMarksForTheExam();
  exam_name.html(
    `<span class="text-muted">Exam Name:</span> ${exam_obj.exam_name}`
  );
  exam_out_of.html(
    `<span class="text-muted">Exam Out Of: </span>${exam_obj.exam_out_of}`
  );
}

// Populate the exam with exam out of and exam names.
populateExamDetails();

async function getTotalNumberOfSubjects() {
  let number_of_subjects;
  const response = await fetch(
    `/students/chartjs/get_total_number_of_subjects.php?cid=${cid}`
  );
  const data = await response.text();
  const parsed = JSON.parse(data);

  number_of_subjects = parsed;

  return { number_of_subjects };
}

async function getTotalOveralOutOfMarks() {
  const total_number_of_subjects_for_class_ = await getTotalNumberOfSubjects();
  const overall_exam_out_of = await getOutOfMarksForTheExam();

  let total_overal_marks =
    total_number_of_subjects_for_class_["number_of_subjects"] *
    overall_exam_out_of["exam_out_of"];

  return { total_overal_marks };
}

//function to calculate the average of the students marks.
async function calculateAverageTotalMarks() {
  const totalsumofsubjects = await getTotalNumberOfSubjects();
  const studentstotalmarks = await getSubjectTotalSum();
  const totaloveralout_of = await getTotalOveralOutOfMarks();

  let average =
    studentstotalmarks.totalSumOfSubjects /
    totalsumofsubjects.number_of_subjects;

  average = average.toFixed(1);
  average_marks.html(`${average}`);

  let percentage =
    (studentstotalmarks.totalSumOfSubjects /
      totaloveralout_of.total_overal_marks) *
    100;

  percentage = percentage.toFixed(1);
  percentage_marks.html(`${percentage}%`);
}

calculateAverageTotalMarks();
