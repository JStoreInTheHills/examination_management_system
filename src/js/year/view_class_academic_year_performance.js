const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const class_name = urlParams.get("cid");
const academic_year = urlParams.get("yid");

const heading = $("#heading");
const academic_title = $("#title");
const bread_list = $("#bread_list");

const class_name_title = $("#class_name");
const class_creation_date = $("#class_creation_date");
const class_teachers_name = $("#class_teachers_name");

const formData = {
  class_name: class_name,
  academic_year: academic_year,
};

const init = () => {
  $.ajax({
    url: "../queries/get_year_details",
    type: "GET",
    data: {
      year_id: academic_year,
    },
  }).done((response) => {
    const arr = JSON.parse(response);
    arr.forEach((items) => {
      heading.html(
        `Academic Year: <a href="/academic_year/page/view_academic_year?year_id=${items.year_id}">${items.year_name}</a>`
      );
      academic_title.html(`${items.year_name}`);
      bread_list.html(
        `<a href="/academic_year/page/view_academic_year?year_id=${items.year_id}">${items.year_name}</a>`
      );
    });
    getClassDetails();
  });
};

init();

const getClassDetails = () => {
  $.ajax({
    url: "../queries/get_class_details_for_final_result_show.php",
    type: "GET",
    data: {
      class_id: class_name,
    },
  }).done((response) => {
    const arr = JSON.parse(response);
    arr.forEach((items) => {
      class_name_title.html(
        `Stream : <a href="/class/page/class_view?classid=${items.id}">${items.ClassName} (${items.ClassNameNumeric})</a>`
      );
      class_creation_date.html(`Date Created: ${items.CreationDate}`);
      class_teachers_name.html(
        `Class Teacher: <a href="/teachers/pages/view_teacher?teachers_id=${items.teacher_id}">${items.name}</a>`
      );
      $("#bread_list2").html(`${items.ClassName}`);
    });
  });
};

const table = $("#table").DataTable({
  order: [[0, "desc"]],
  ajax: {
    url: "./../queries/class_exam_results.php",
    data: formData,
    type: "GET",
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 1,
      data: "exam_name",
      render: function (data) {
        return `<a href="#">${data}</a>`;
      },
    },
    {
      targets: 0,
      data: "created_at",
    },
    {
      targets: 2,
      data: "name",
    },
    {
      targets: 3,
      data: "status",
      render: function (data) {
        if (data == 1) {
          return `<span class="badge badge-pill badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-pill badge-danger">Inactive</span>`;
        }
      },
    },
    {
      targets: 4,
      width: "10%",
      data: "exam_out_of",
    },
  ],
});

var class_academic_table = $("#class_academic_table").DataTable({
  ajax: {
    url: "./../queries/class_academic_year_exam_students.php",
    type: "GET",
    dataSrc: "",
    data: formData,
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
        StudentId: "StudentId",
        LastName: "LastName",
        OtherNames: "OtherNames",
      },
      render: function (data) {
        return `<a target="_blank" href="../../reports/academic_year/students_academic_year_result.php?sid=${data.StudentId}&cid=${class_name}&year_id=${academic_year}">${data.FirstName} ${data.OtherNames} ${data.LastName}</a>`;
      },
    },
    {
      targets: 2,
      data: "RollId",
    },
    {
      targets: 3,
      data: "Status",
      render: function (data) {
        if (data == 1) {
          return `<span class="badge badge-pill badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-pill badge-danger">Inactive</span>`;
        }
      },
    },
  ],
});

// Intervals
setInterval(function () {
  class_academic_table.ajax.reload(null, false);
  table.ajax.reload(null, false);
}, 100000);
