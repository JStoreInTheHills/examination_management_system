// Official js page for the index page.

// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

// add a variable to hold the gender url.
const gender_url = "/dashboard/queries/get_gender_count.php";

// variable holding the pie chart element.
// const ctx = document.getElementById("myPieChart");

// Area Chart Example
const clx = document.getElementById("myAreaChart");

// variable holding the index title.
const index_title = $("#title");

edit_madrasa = $("#edit_madrasa");

// variable holding the index heading.
const index_heading = $("#index_heading");

// Pointer to the number of teachers in the school.
let number_of_teachers;

// Pointer hold the total number of classes in the school.
let number_of_classes;

// Pointer holding the term and students marks for the term.
let totalMarksForStudentsArray;

const edit_school_modal = $("#edit_school_modal");

const edit_school_form = $("#edit_school_form");

const school_name_input = $("#school_name_input");

// Function to toogle the sidebar
const toggle = () => {
  $("body").toggleClass("sidebar-toggled");
  $(".sidebar").toggleClass("toggled");
  if ($(".sidebar").hasClass("toggled")) {
    $(".sidebar .collapse").collapse("hide");
  }
};
toggle();
// Pointer to the school name.
let school_name;
let school_id;

const init = () => {
  getAndSetMaleAndFemaleStudents();
  setMaleAndFemaleTeachers();
  get_all_class();
};

// Initial funcrion to run when starting the page.
async function get_school_name() {
  const school = {};
  const request = await fetch(`./admin/queries/get_school.php`);
  const response = await request.text();
  const arr = JSON.parse(response);

  arr.forEach((key) => {
    school.name = key.school_name;
    school.id = key.id;
  });

  return school;
}

async function setSchoolName() {
  const school = await get_school_name();
  school_name_input.val(`${school.name}`);
  school_id = school.id;
  school_name = school.name;
  index_heading.html(school.name);
  sessionStorage.setItem("school_name", school.name);
  index_title.html(`Home - ${school.name}`);

  edit_madrasa.html("Edit School Name");
}

setSchoolName();
//------------------------------------------------------------------------------------------------------

// Show the modal when the buttton is clicked.
edit_madrasa.click(() => {
  edit_school_modal.modal({
    show: true,
    backdrop: "static",
    keyboard: false,
  });
});

async function get_students_count() {
  const request = await fetch(`dashboard/queries/get_students.php`);
  const response = await request.text();
  const parsed = JSON.parse(response);

  return parsed;
}

async function getAndSetMaleAndFemaleStudents() {
  const all_students_count = await get_students_count();
  const maleStudentsUrl = await fetch(`/admin/queries/get_male_students.php`);
  const response = await maleStudentsUrl.text();
  const all_male_students_count = JSON.parse(response);

  // to get the female students we subtract the male students from the total number of students.
  female_ = all_students_count - all_male_students_count;

  // Assign to the DOM.
  $("#male_students").html(all_male_students_count);
  $("#all_students").html(all_students_count);
  $("#female_students").html(female_);
}

async function get_all_teachers() {
  const request = await fetch(`dashboard/queries/get_teachers.php`);
  const response = await request.text();
  const all_teachers = JSON.parse(response);

  return all_teachers;
}

async function setMaleAndFemaleTeachers() {
  const count_of_teachers = await get_all_teachers();
  number_of_teachers = count_of_teachers;

  const request = await fetch(`/admin/queries/get_male_teachers.php`);
  const response = await request.text();
  const male_teachers = JSON.parse(response);

  let teachers_female_ = number_of_teachers - male_teachers;

  $("#all_teachers").html(number_of_teachers);
  $("#female_teachers").html(teachers_female_);
  $("#male_teachers").html(male_teachers);
}

// Function to populate the number of streams in the school.
const get_all_class = () => {
  $.ajax({
    url: "dashboard/queries/get_classes.php",
    type: "GET",
  }).done((response) => {
    // array object holding the response from the db.
    const allclasses = JSON.parse(response);
    allclasses.forEach((item) => {
      // Assing the number of classes to the global number of classes.
      number_of_classes = item.classes;
    });
    $("#all_classes").html(number_of_classes);
  });
};

setInterval(() => {
  getAndSetMaleAndFemaleStudents();
  get_all_class();
  setMaleAndFemaleTeachers();
}, 1000000);

// get recent added students from the database.
const recent_Datatables = $("#recent_Datatables").DataTable({
  paging: false,
  ordering: false,
  info: true,
  bFilter: true,
  autoWidth: true,
  ajax: {
    url: "/admin/queries/get_latest_result.php",
    data: "",
    dataSrc: "",
    type: "GET",
  },
  columnDefs: [
    {
      targets: 0,
      data: "RegDate",
    },
    {
      targets: 1,
      data: {
        FirstName: "FirstName",
        OtherNames: "OtherNames",
        LastName: "LastName",
        ClassName: "RollId",
      },
      render: (data) => {
        return `<a>${data.FirstName} ${data.OtherNames} ${data.LastName} (${data.RollId})</a>`;
      },
    },
    {
      targets: 2,
      data: "ClassName",
    },
    {
      targets: 3,
      data: "Status",
      render: (data) => {
        if (data != 1) {
          return `<span class="cute_dot cute_dot-lg bg-danger mr-2"></span>`;
        } else {
          return `<span class="cute_dot cute_dot-lg bg-success mr-2"></span>`;
        }
      },
    },
  ],
});

// get recent results added to the system.
const recent_result_declared = $("#recent_result_declared").DataTable({
  paging: false,
  ordering: false,
  info: true,
  bFilter: true,
  autoWidth: true,
  ajax: {
    url: "/admin/queries/get_latest_result_declared.php",
    type: "GET",
    data: "",
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: "created_at",
    },
    {
      targets: 1,
      data: {
        FirstName: "FirstName",
        OtherNames: "OtherNames",
        LastName: "LastName",
      },
      render: (data) => {
        return `<a href="">${data.FirstName} ${data.OtherNames} ${data.LastName} </a>`;
      },
    },
    {
      targets: 2,
      data: "ClassName",
    },
    {
      targets: 3,
      data: "SubjectName",
    },
    {
      targets: 4,
      data: "marks",
    },
  ],
});

// Get the term performance for all the students in the school.
// const getTotalMarksForStudents = () => {
//   $.ajax({
//     url: "/admin/queries/getTotalMarksForStudents.php",
//     type: "GET",
//     data: "",
//   }).done((response) => {
//     const studentsTotalMarks = JSON.parse(response);
//     totalMarksForStudentsArray = studentsTotalMarks;

//     totalMarksForStudentsArray.forEach((element) => {
//       let total = element.total;

//       // Divide the total by the number of students in the school.
//       total = total / number_of_students;

//       // Push the data to the data array.
//       data.push(total);
//       label.push(element.name);
//     });
//     myLineChart.update();
//   });
// };

const line_chart_options = {
  maintainAspectRatio: false,
  layout: {
    padding: {
      left: 5,
      right: 10,
      top: 10,
      bottom: 0,
    },
  },
  scales: {
    xAxes: [
      {
        stacked: true,
        time: {
          unit: "number",
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
          drawBorder: true,
          borderDash: [2],
          zeroLineBorderDash: [2],
        },
      },
    ],
  },
  legend: {
    display: true,
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
    intersect: true,
    mode: "index",
    caretPadding: 10,
  },
};

const line_chart_data = {
  labels: [],
  datasets: [
    {
      label: "",
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
      data: [],
      fill: true,
    },

    {
      label: "",
      lineTension: 0.3,
      backgroundColor: "rgba(231, 23, 3, 0.05)",
      borderColor: "rgba(231, 23, 3, 0.05)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(231, 23, 3, 0.05)",
      pointBorderColor: "rgba(231, 23, 3, 0.05)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(231, 23, 3, 0.05)",
      pointHoverBorderColor: "rgba(231, 23, 3, 0.05)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [],
      fill: true,
    },
  ],
};

let data = [];
let label = [];

edit_school_form.validate({
  rules: {
    school_name_input: {
      required: true,
    },
  },

  errorClass: "text-danger",

  submitHandler: function (form) {
    $.ajax({
      url: "/admin/queries/edit_school_name.php",
      type: "POST",
      data: $(form).serialize(),
    }).done(function (response) {
      edit_school_modal.modal("hide");
      const json_response = JSON.parse(response);

      if (json_response.success == true) {
        iziToast.success({
          message: json_response.message,
          position: "bottomLeft",
          overlay: true,
          messageColor: "black",
          onClosing: function () {
            edit_school_modal.modal("hide");
            setSchoolName();
          },
        });
      } else {
        iziToast.error({
          message: json_response.message,
          position: "bottomLeft",
          overlay: true,
          messageColor: "black",
        });
      }
    });
  },
});

init();
