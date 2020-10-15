// ------ Start of variable declaration --------------------------------
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const class_id = urlParams.get("stream_id"); // pointer to hold the class_id

const streamTitle = $("#stream_title");
const pageHeader = $("#page_header");
const activeBreadCrumb = $("#active_breadcrumb");

// DOM element referencing the archive button.
const archiveClassButton = $("#editClassActive");
archiveClassButton.hide();

const studentsCount = $("#all_students");

const teachersCount = $("#all_teachers");

const streamCount = $("#all_streams");

const exampleModalLongTitle = $("#exampleModalLongTitle");

const edit_class_name = $("#edit_class_name");

const edit_class_desc = $("#edit_class_desc");

const edit_this_class_submit_btn = $("#edit_this_class_submit_btn");

var class_name;

// Variable to check if the class is active.
var classStatus;

// Object holding the form used in the class.
const formData = {
  class_id: class_id,
};

const alert = $("#alert");

// ------ End of Variable Declaration --------------------------------

const toggleSideBar = () => {
  $("body").toggleClass("sidebar-toggled");
  $(".sidebar").toggleClass("toggled");
  if ($(".sidebar").hasClass("toggled")) {
    $(".sidebar .collapse").collapse("hide");
  }
};
toggleSideBar();

// Function to get the class details =.
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
      classStatus = i.status;
    });
    archiveClassButton.show();
    checkIfClassIsArchived();
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

// Datatables for the class exam Datatables.
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
        year_id: "year_id",
        term_id: "term_id",
      },
      render: function (data) {
        return `
        <a href="./view_class_stream_exam_performance?cid=${class_id}&eid=${data.exam_id}&yid=${data.year_id}&tid=${data.term_id}">
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

const toast = {
  question: function () {
    return new Promise(function (resolve) {
      iziToast.info({
        title: "WARNING",
        icon: "fa fa-exclamation-triangle",
        message: `You are about to delete a Students Result! 
                  Are you sure of this command?`,
        timeout: 20000,
        close: false,
        transitionIn: "bounceInLeft",
        position: "center",
        buttons: [
          [
            "<button><b>YES</b></button>",
            function (instance, toast, button, e, inputs) {
              instance.hide(
                {
                  transitionOut: "fadeOut",
                },
                toast,
                "button"
              );
              resolve();
            },
            false,
          ],
          [
            "<button>NO</button>",
            function (instance, toast, button, e, inputs) {
              instance.hide(
                {
                  transitionOut: "fadeOut",
                },
                toast,
                "button"
              );
            },
          ],
        ],
      });
    });
  },
  warning: function () {
    return new Promise(function (resolve) {
      iziToast.error({
        title: "WARNING",
        icon: "fa fa-exclamation-triangle",
        message: `You are about to archive this class.  
                  Are you sure of this command?`,
        timeout: 20000,
        close: false,
        transitionIn: "bounceInLeft",
        position: "center",
        buttons: [
          [
            "<button><b>YES</b></button>",
            function (instance, toast, button, e, inputs) {
              instance.hide(
                {
                  transitionOut: "fadeOut",
                },
                toast,
                "button"
              );
              resolve();
            },
            false,
          ],
          [
            "<button>NO</button>",
            function (instance, toast, button, e, inputs) {
              instance.hide(
                {
                  transitionOut: "fadeOut",
                },
                toast,
                "button"
              );
            },
          ],
        ],
      });
    });
  },
};

const deleteStream = (stream_id) => {
  console.log(stream_id);
};

const checkIfClassIsArchived = () => {
  if (classStatus == 0) {
    $("#badge").html(`<i class="badge badge-danger"> Archived </i>`);

    alert.html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>This Class has been archived from editing. It is read only.</strong>
    <hr>
        <p class="mb-0">Either all results have been declared or the exam is no longer available for editing. 
        Kindly Contact Administrator</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>`);

    archiveClassButton
      .html(`<i class="fas fa-check">Make Active</i>`)
      .removeClass("btn-danger")
      .addClass("btn-success");
  } else {
    $("#badge").html(`<i class="badge badge-success"> Active </i>`);
    alert.html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Use this page to view this class streams, exams and students.</strong>
    <hr>
        <p class="mb-0">View all streams registered in the class. You can add new stream here,
        view students and the exams the class has sat for. </p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>`);
    archiveClassButton
      .html(`<i class="fas fa-trash">Archive Class</i>`)
      .removeClass("btn-success")
      .addClass("btn-danger");
  }
};

archiveClassButton.click((e) => {
  toast.warning().then(() => {
    let s;
    if (classStatus == 0) {
      s = 1;
    } else {
      s = 0;
    }

    $.ajax({
      url: "../queries/editMakeClassInactive.php",
      type: "POST",
      data: {
        class_id: class_id,
        status: s,
      },
    }).done((response) => {
      const resp = JSON.parse(response);
      if (resp.success == true) {
        iziToast.success({
          type: "success",
          message: resp.message,
          position: "topRight",
          onClosing: () => {
            get_class_details();
          },
        });
      } else {
        iziToast.error({
          type: "error",
          message: resp.message,
          position: "topRight",
        });
      }
    });
  });

  e.preventDefault();
});

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
  class_student_table.ajax.reload(null, false);
  class_stream_table.ajax.reload(null, false);
  class_exam_table.ajax.reload(null, false);
  get_students_count();
  get_exam_count();
  get_stream_count();
  get_teachers_count();
}, 1000000);
