const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const class_id = urlParams.get("stream_id"); // pointer to hold the class_id

const streamTitle = $("#stream_title");
const pageHeader = $("#page_header");
const activeBreadCrumb = $("#active_breadcrumb");

const studentsCount = $("#all_students");

const teachersCount = $("#all_teachers");

const streamCount = $("#all_streams");

const exampleModalLongTitle = $("#exampleModalLongTitle");

const edit_class_name = $("#edit_class_name");

const edit_class_desc = $("#edit_class_desc");

const edit_this_class_submit_btn = $("#edit_this_class_submit_btn");

var class_name;

const formData = {
  class_id: class_id,
};

const toggleSideBar = () => {
  $("body").toggleClass("sidebar-toggled");
  $(".sidebar").toggleClass("toggled");
  if ($(".sidebar").hasClass("toggled")) {
    $(".sidebar .collapse").collapse("hide");
  }
};
toggleSideBar();

const get_class_details = () => {
  $.ajax({
    url: "../queries/get_class_details.php",
    type: "GET",
    data: formData,
  }).done((response) => {
    const j = JSON.parse(response);
    j.forEach((i) => {
      class_name = i.name;
      $("#class_description").html(i.description);
      $("#class_creation_date").html(i.created_at);
      pageHeader.html(i.name);
      streamTitle.html(`Class || ${i.name}`);
      activeBreadCrumb.html(i.name);
      edit_class_name.val(i.name);
      edit_class_desc.val(i.description);
      exampleModalLongTitle.html(`Edit Class : ${i.name}`);
    });
  });
};

get_class_details();

const class_stream_table = $("#class_stream_table").DataTable({
  order: [[0, "desc"]],
  ajax: {
    url: "../queries/get_class_streams.php",
    type: "GET",
    data: formData,
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: "CreationDate",
    },
    {
      targets: 1,
      data: {
        ClassName: "ClassName",
        id: "id",
      },
      render: function (data) {
        return `<a href="/class/page/class_view?classid=${data.id}">${data.ClassName}</a>`;
      },
    },
    {
      targets: 2,
      data: "ClassNameNumeric",
    },
    {
      targets: 3,
      data: "number_of_students",
      render: function (data) {
        if (data > 1) {
          return `${data} students`;
        } else {
          return `${data} student`;
        }
      },
    },
    {
      targets: 4,
      data: "number_of_subjects",
      render: function (data) {
        if (data > 1) {
          return `${data} subjects`;
        } else {
          return `${data} subject`;
        }
      },
    },
    {
      targets: 5,
      data: "exams",
      render: function (data) {
        if (data > 1) {
          return `${data} exams`;
        } else {
          return `${data} exam`;
        }
      },
    },
    {
      targets: 6,
      width: "5%",
      orderable: false,
      data: "id",
      render: function (data) {
        return `
          <a style = "color:red" onclick="deleteStream(${data})"><span><i class="fas fa-trash"></i></span></a>
          `;
      },
    },
  ],
});

const class_exam_table = $("#class_exam_table").DataTable({
  order: [[0, "desc"]],
  ajax: {
    url: "../queries/populate_class_exam_table.php",
    type: "GET",
    data: formData,
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
        exam_name: "exam_name",
        exam_id: "exam_id",
        year_name: "year_name",
      },
      render: function (data) {
        return `
        <a href="./view_class_stream_exam_performance?cid=${class_id}&eid=${data.exam_id}">
          ${data.exam_name}
        </a>`;
      },
    },
    {
      targets: 4,
      data: "year_name",
    },
    {
      targets: 3,
      data: "exam_count",
      render: function (data) {
        if (data > 1) {
          return `${data} Streams`;
        } else {
          return `${data} Stream`;
        }
      },
    },
    {
      targets: 2,
      data: "name",
    },
  ],
});

const class_student_table = $("#class_student_table").DataTable({
  order: [[0, "desc"]],
  ajax: {
    url: "../queries/get_all_students.php",
    type: "GET",
    data: formData,
    dataSrc: "",
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
      render: function (data) {
        return `<a href="../../students/pages/details?sid=${data.StudentId}">${data.FirstName} ${data.OtherNames} ${data.LastName}</a>`;
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
      data: "Status",
      render: function (data) {
        if (data == "1") {
          return `<span class="badge badge-pill badge-success">Active</span>`;
        } else {
          return `<span class="badge badge-pill badge-danger">InActive</span>`;
        }
      },
    },
    {
      targets: 4,
      data: "DOB",
    },
  ],
});

const get_students_count = () => {
  $.ajax({
    url: "../queries/get_students_count.php",
    type: "GET",
    data: formData,
  }).done((response) => {
    const j = JSON.parse(response);
    j.forEach((i) => {
      studentsCount.html(`${i.students_count}`);
    });
  });
};

get_students_count();

const get_teachers_count = () => {
  $.ajax({
    url: "../queries/get_teacher_count.php",
    type: "GET",
    data: formData,
  }).done(function (response) {
    const j = JSON.parse(response);
    j.forEach(function (i) {
      teachersCount.html(i.teacher_count);
    });
  });
};

get_teachers_count();

const get_stream_count = () => {
  $.ajax({
    url: "../queries/get_stream_count.php",
    type: "GET",
    data: formData,
  }).done((response) => {
    const j = JSON.parse(response);
    j.forEach((i) => {
      streamCount.html(i.stream_count);
    });
  });
};

get_stream_count();

const get_exam_count = () => {
  $.ajax({
    url: "../queries/get_exam_count.php",
    type: "GET",
    data: formData,
  }).done(function (response) {
    let j = JSON.parse(response);
    j.forEach(function (i) {
      $("#all_exams").html(`${i.exam_count}`);
    });
  });
};
// get_exam_count();

const deleteStream = (stream_id) => {
  console.log(stream_id);
};

edit_this_class_submit_btn.click((e) => {
  const formData = {
    edit_class_name: edit_class_name.val(),
    edit_class_desc: edit_class_desc.val(),
    class_id: class_id,
  };

  if (formData.edit_class_name.length < 3) {
    console.log("Class Name cannot be less than 3 digits");
  } else {
    $.ajax({
      url: "../queries/edit_stream.php",
      type: "POST",
      data: formData,
    }).done((response) => {
      const arr = JSON.parse(response);
      if (arr.success === true) {
        iziToast.success({
          type: "Success",
          position: "topRight",
          message: arr.message,
          transitionIn: "bounceInLeft",
          onClosing: () => {
            get_class_details();
          },
        });
      } else {
        iziToast.error({
          type: "Error",
          position: "topRight",
          message: arr.message,
          transitionIn: "bounceInLeft",
        });
      }
    });
  }

  e.preventDefault();
});

setInterval(() => {
  class_student_table();
  class_stream_table();
  class_exam_table();
  get_students_count();
  get_exam_count();
  get_stream_count();
  get_teachers_count();
}, 100000);
