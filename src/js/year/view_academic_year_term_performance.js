const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const year_id = urlParams.get("year_id");
const term_id = urlParams.get("term_id");
const date_added = $("#date_added");
const added_by = $("#added_by");
const term_status = $("#term_status");

const alert = $("#alert");
var statusOfClass;

const init = () => {
  $.ajax({
    url: "../queries/get_academic_year_term_performance.php",
    data: {
      year_id: year_id,
      term_id: term_id,
    },
    type: "GET",
  }).done((resp) => {
    const arr = JSON.parse(resp);
    arr.forEach((item) => {
      heading.html(`${item.year_name} ~ ${item.name} Performance`);
      year_title.html(`${item.year_name} ~ ${item.name} Performance`);
      bread_list_year.html(`${item.year_name}`);
      a.href = `view_academic_year?year_id=${year_id}`;
      bread_list_term.html(item.name);
      date_added.html(`Date Added : ${item.created_at}`);
      added_by.html(`Added By : ${item.username}`);
      statusOfClass = item.status;
    });
    checkIfTermIsActive();
  });
};

init();

const term_year_table = $("#term_year_table").DataTable({
  ajax: {
    url: "../queries/get_classes.php",
    type: "GET",
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: {
        ClassName: "ClassName",
        id: "id",
      },
      render: (data) => {
        return `<a href="./view_academic_term_year_exam_performance?class_id=${data.id}&year_id=${year_id}&&term_id=${term_id}">${data.ClassName}</a>`;
      },
    },
    {
      targets: 1,
      data: "ClassNameNumeric",
    },
    {
      targets: 2,
      data: "name",
    },
  ],
});

setInterval(() => {
  term_year_table.ajax.reload(null, false);
}, 1000000);

const heading = $("#heading");
const a = document.getElementById("bread_list_year");
const year_title = $("#title");
const bread_list_year = $("#bread_list_year");
const bread_list_term = $("#bread_list_term");

function checkIfTermIsActive() {
  if (statusOfClass == 1) {
    alert.html(`<div class="alert alert-success" role="alert">
        <h5 class="alert-heading ">All the class in the school and the exam performance for the term are displayed in the table below. </h5>
        <hr>
        <p class="mb-0">Click on a class and view the students term performance. This performance combines all the exams that were sat for be the student this term.</p>
      </div>`);

    term_status.html(
      `Status : <span class="badge badge-pill badge-success">Active</span>`
    );
  } else {
    alert.html(`<div class="alert alert-danger" role="alert">
        <h5 class="alert-heading ">This is an inactive term and cannot be used for editing</h5>
        <hr>
        <p class="mb-0">Activate the term if you want to add exam and results to the term. Otherwise exams and students performance cannot be added.</p>
      </div>`);

    term_status.html(
      ` Status : <span class="badge badge-pill badge-danger">InActive</span>`
    );
  }
}
