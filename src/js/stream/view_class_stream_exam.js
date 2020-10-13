const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const class_id = urlParams.get("cid");
const class_exam_id = urlParams.get("eid");
const year_id = urlParams.get("yid");
const term_id = urlParams.get("tid");

const reportUrl = `/reports/stream/class_stream_exam_report?class_id=${class_id}&eid=${class_exam_id}`;

const studentPageLink = [];

const classStreamTitle = $("#class_stream_title");

const pageHeader = $("#page_header");

const class_exam_term = $("#class_exam_term");

const activeBreadCrumb = $("#active_breadcrumb");

const classCreationDate = $("#class_creation_date");

var class_name;

const init = () => {
  const formData = {
    class_id: class_id,
    class_exam_id: class_exam_id,
    year_id: year_id,
    term_id: term_id,
  };
  $.ajax({
    url: "../queries/get_class_stream_details.php",
    type: "GET",
    data: formData,
  }).done((response) => {
    const arr = JSON.parse(response);
    const navLink = $("#nav_link");
    arr.forEach((item) => {
      navLink.html(item.stream_name);
      classCreationDate.html(item.year_name);
      classStreamTitle.html(
        ` ${item.stream_name} || ${item.exam_name} Performance`
      );
      pageHeader.html(`${item.stream_name} ~ ${item.exam_name} Performance`);
      activeBreadCrumb.html(item.exam_name);
      class_exam_term.html(item.term_name);
      navLink.attr("href", `view_stream?stream_id=${item.stream_id}`);
    });
  });
};

init();

const formData = {
  class_id: class_id,
  class_exam_id: class_exam_id,
};

const classTable = $("#class_table").DataTable({
  order: [[0, "asc"]],
  ajax: {
    url: "../queries/get_class_stream_exam_performance.php",
    type: "GET",
    dataSrc: "",
    data: formData,
  },
  columnDefs: [
    {
      targets: 0,
      data: "r",
      width: "5%",
    },
    {
      targets: 1,
      data: {
        FirstName: "FirstName",
        OtherNames: "OtherNames",
        LastName: "LastName",
        StudentId: "StudentId",
      },
      render: function (data) {
        return `<a target="_blank" 
                  href="/students/pages/details?sid=${data.StudentId}" >
                    ${data.FirstName} ${data.OtherNames} ${data.LastName}
                </a>`;
      },
    },
    {
      targets: 2,
      data: "RollId",
      width: "10%",
    },
    {
      targets: 3,
      data: "ClassName",
      width: "20%",
    },
    {
      targets: 4,
      data: "number_of_subjects",
      width: "10%",
    },
    {
      targets: 5,
      data: "total",
      width: "10%",
    },
    {
      targets: 6,
      width: "10%",
      data: {
        total: "total",
        subject_count: "subject_count",
        number_of_subjects: "number_of_subjects",
      },
      render: function (data) {
        let t = data.total;
        let d = data.subject_count;
        let l = d.split(",");

        let tt = t / l.length;
        if (l.length == data.number_of_subjects) {
          return tt;
        } else {
          return "__";
        }
      },
    },
    {
      targets: 7,
      width: "10%",
      data: {
        total: "total",
        subject_count: "subject_count",
      },
      render: function (data) {
        let t = data.total;
        let d = data.subject_count;
        let l = d.split(",");

        let tt = Math.round(t / l.length);

        if (tt >= 96) {
          return "Excellent";
        } else if ((tt <= 95) & (tt >= 86)) {
          return "Very Good";
        } else if ((tt <= 85) & (tt >= 70)) {
          return "Good";
        } else if ((tt >= 69) & (tt <= 50)) {
          return "Pass";
        } else {
          return "Fail";
        }
      },
    },
  ],
});

$("#print_overall_result").click((e) => {
  e.preventDefault();
  open(reportUrl);
});

setInterval(() => {
  classTable.ajax.reload();
}, 100000);
