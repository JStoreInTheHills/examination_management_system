const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const year_id = urlParams.get("year_id");
const term_id = urlParams.get("term_id");
const class_id = urlParams.get("class_id");

const heading = $("#heading");
const year_title = $("#year_title");
const bread_list_term = $("#bread_list_term");
const bread_list_year = $("#bread_list_year");

const bread_list_year_name = $("#bread_list_year_name");

const term_title_id = $("#term_id");
const year_title_id = $("#year_id");

const class_details_name = $("#class_details_name");
const class_details_teacher = $("#class_details_teacher");

year_title.html(`2020 || Term Results`);
bread_list_term.html(`Class Name`);

const students_term_year_table = $("#students_term_year_table");

const exams_id = $("#exams_id");

const getYearDetails = () => {
  $.ajax({
    url: "../queries/Models/term_year/getTermYearDetails.php",
    data: {
      term_id: term_id,
      year_id: year_id,
    },
    type: "GET",
  }).done((response) => {
    const arr = JSON.parse(response);
    arr.forEach((item) => {
      heading.html(` ${item.name} Performance`);
      term_title_id.html(
        `Term : <a href="/academic_year/page/view_academic_year_term_performance?term_id=${item.term_year_id}&year_id=${item.year_id}"> ${item.name} </a>`
      );
      year_title_id.html(
        `Year Name : <a href="/academic_year/page/view_academic_year?year_id=${item.year_id}">${item.year_name}</a>`
      );
      bread_list_year.html(
        `<a href="view_academic_year_term_performance?term_id=${term_id}&year_id=${year_id}"> ${item.name}</a>`
      );
      bread_list_year_name.html(
        `<a href="/academic_year/page/view_academic_year?year_id=${item.year_id}">${item.year_name}</a>`
      );
    });
  });
};

getYearDetails();

const getClassDetails = () => {
  $.ajax({
    url: "../queries/Models/term_year/getClassDetails",
    data: {
      class_id: class_id,
    },
    type: "GET",
  }).done((response) => {
    const arr = JSON.parse(response);
    arr.forEach((item) => {
      class_details_name.html(
        `Class Name : <a target="_blank" href="/class/page/class_view?classid=${item.id}">${item.ClassName}</a>`
      );
      bread_list_term.html(item.ClassName);
      class_details_teacher.html(
        `Class Teacher : <a target="_blank" href="/teachers/pages/view_teacher?teachers_id=${item.teacher_id}">${item.name}</a>`
      );
    });
  });
};

getClassDetails();

students_term_year_table.DataTable({
  ajax: {
    url: "../queries/getStudentForClass.php",
    type: "GET",
    dataSrc: "",
    data: {
      class_id: class_id,
    },
  },
  columnDefs: [
    {
      targets: 0,
      data: {
        FirstName: "FirstName",
        OtherNames: "OtherNames",
        LastName: "LastName",
        StudentId: "StudentId",
      },
      render: (data) => {
        return `<a target="_blank" href="/reports/class/module/term/exam_report?year_id=${year_id}&&term_id=${term_id}&&cid=${class_id}&&sid=${data.StudentId}">${data.FirstName} ${data.OtherNames} ${data.LastName}</a>`;
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
      render: (data) => {
        if (data == 1) {
          return `<span class="badge badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-danger">InActive</span>`;
        }
      },
    },
  ],
});
