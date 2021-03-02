// $(document).ready(() => {
// Declaration of a string holding the URI location values.
const class_subject_teacher_query = window.location.search;

// Creating an object that holds the values of the argurments in the URI.
// The URI is passed as an argurment.
const class_id_param = new URLSearchParams(class_subject_teacher_query);

// Variable holding the value of the class unique id
// ----------------------------------------------------------------
const teachers_id = class_id_param.get("teachers_id");

// const teachers_id = sessionStorage.getItem("teachers_token");

const heading = $("#heading");
const title = $("#title");

const class_id = $("#class_id");
const subject_id = $("#subject_id");

const add_subject_teacher_submit = $("#add_subject_teacher_submit");

const teachers_name = $("#teachers_name");

const id_no = $("#id_no");

const email = $("#email");
const phone = $("#gender");
const CreationDate = $("#CreationDate");
const edit_teacher_btn = $("#edit_teacher_btn");

const status = $("#status");

const formData = {
  teachers_id: teachers_id,
};

const init = () => {
  $.ajax({
    url: "../queries/get_teachers_details.php",
    type: "GET",
    data: formData,
  }).done((response) => {
    const arr = JSON.parse(response);
    arr.forEach((item) => {
      heading.html(
        `<span><img class="img-profile rounded-circle" width="50"  src="/src/img/download.png"></span> Welcome, ${item.firstname} ${item.lastname}.`
      );
      teachers_name.html(
        `<span class="text-gray-600">Name</span> : ${item.firstname} ${item.lastname}`
      );
      id_no.html(
        `<span class="text-gray-600">ID Number </span> : ${item.id_no}`
      );
      email.html(
        `<span class="text-gray-600" >Email Address  </span> : <a href=""> ${item.email}</a>`
      );
      phone.html(
        `<span class="text-gray-600">Phone Number </span>: ${item.phone}`
      );
      CreationDate.html(
        `<span class="text-gray-600">Date of Registration </span>: ${item.created_at}`
      );
      title.html(`${item.firstname} ${item.lastname} || Teachers`);
      edit_teacher_btn.html(
        `<span><i class="fas fa-edit"></i> </span> Edit ${item.firstname}`
      );

      checkTeachersStatus(item);

      $("#teacher_address").html(
        `<span class="text-gray-800">Address </span> : ${item.address}`
      );

      $("#county").html(
        `<span class="text-gray-800">County </span> : ${item.county_name}`
      );

      $("#edit_teacher_heading").html(`${item.firstname} ${item.lastname}`);

      $("#edit_teachers_name").val(`${item.firstname} ${item.lastname}`);
      $("#edit_id_no").val(item.id_no);
      $("#edit_phone").val(item.phone);
      $("#address").val(item.address);
    });
  });
};

init();

const teachers_subject_table = $("#teachers_subject_table").DataTable({
  ajax: {
    url: "../queries/fetch_teacher_subject.php",
    type: "GET",
    data: formData,
    dataSrc: "",
  },
  columnDefs: [
    {
      targets: 0,
      data: {
        ClassName: "ClassName",
        id: "id",
        subject_id: "SubjectId",
        ClassNameNumeric: "ClassNameNumeric",
      },
      render: (data) => {
        return `
        <a href="./add_result?class_id=${data.id}&subject_id=${data.SubjectId}&teacher_id=${teachers_id}">${data.ClassName} (${data.ClassNameNumeric})</a>`;
      },
    },
    {
      targets: 1,
      data: "SubjectName",
    },
    {
      targets: 2,
      data: "SubjectCode",
    },
    {
      targets: 3,
      orderable: false,
      width: "5%",
      data: {
        id: "id",
        SubjectId: "SubjectId",
      },
      render: (data) => {
        return `<a style="color:red"
                    onclick="deleteSubjectCombination(${data.id}, ${data.SubjectId})">
                  <span><i class="fas fa-trash"></i></span>
                </a>`;
      },
    },
  ],
});

const toast = {
  question: () => {
    return new Promise((resolve) => {
      iziToast.question({
        title: "Warning",
        transitionIn: "bounceInLeft",
        opacity: "100",
        icon: "fas fa-users",
        message:
          "Are you sure you want to remove this subject from this teacher?",
        timeout: 20000,
        progressBar: false,
        close: false,
        messageColor: "black",
        overlay: true,
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

const getClass = () => {
  $.ajax({
    url: "../queries/getClass.php",
    type: "GET",
  }).done((resp) => {
    const arr = JSON.parse(resp);
    arr.forEach((item) => {
      class_id.append(
        `<option value="${item.id}">${item.ClassName} (${item.ClassNameNumeric})</option>`
      );
    });
  });
};

const getSubject = () => {
  $.ajax({
    url: "../queries/getSubjects.php",
    type: "GET",
  }).done((resp) => {
    const arr = JSON.parse(resp);
    arr.forEach((item) => {
      subject_id.append(
        `<option value="${item.subject_id}">${item.SubjectName} (${item.SubjectCode})</option>`
      );
    });
  });
};

const _token = sessionStorage.getItem("_token");

if (_token !== "Teacher") {
  getClass();
  getSubject();
}

add_subject_teacher_submit.click((e) => {
  const add_subject_teacher_submit_form = {
    class_id: class_id.val(),
    subject_id: subject_id.val(),
    teachers_id: teachers_id,
  };

  $.ajax({
    url: "../queries/add_subject_teacher.php",
    data: add_subject_teacher_submit_form,
    type: "POST",
  }).done((resp) => {
    const r = JSON.parse(resp);
    if (r.success == true) {
      iziToast.success({
        type: "Success",
        position: "topRight",
        transitionIn: "bounceInRight",
        message: r.message,
        onClosing: () => {
          teachers_subject_table.ajax.reload(null, false);
        },
      });
    } else {
      iziToast.error({
        type: "Error",
        position: "topRight",
        message: r.message,
        transitionIn: "bounceInRight",
      });
    }
  });

  e.preventDefault();
});

const edit_teachers_details = $("#edit_teachers_details");

edit_teachers_details.click((e) => {
  const formData = {
    edit_teachers_name: $("#edit_teachers_name").val(),
    edit_id_no: $("#edit_id_no").val(),
    edit_phone: $("#edit_phone").val(),
    edit_gender: $("#edit_gender").val(),
    address: $("#address").val(),
    teacher_id: teachers_id,
  };

  $.ajax({
    url: "../queries/update_teachers_details",
    data: formData,
    type: "POST",
  }).done((resp) => {
    const arr = JSON.parse(resp);
    if (arr.success == true) {
      iziToast.success({
        type: "Succes",
        position: "topRight",
        transitionIn: "bounceInRight",
        message: arr.message,
        onClosing: function () {
          init();
        },
      });
    } else {
      iziToast.error({
        type: "Error",
        position: "topRight",
        transitionIn: "bounceInRight",
        message: arr.message,
      });
    }
  });

  e.preventDefault();
});

const deleteSubjectCombination = (class_id, SubjectId) => {
  toast.question().then(() => {
    $.ajax({
      url: "../queries/view_teacher/delete_subject_for_teacher.php",
      type: "POST",
      data: {
        teachers_id: teachers_id,
        class_id: class_id,
        SubjectId: SubjectId,
      },
    }).done((resp) => {
      const arr = JSON.parse(resp);
      if (arr.success == true) {
        iziToast.success({
          type: "Success",
          position: "topRight",
          transitionIn: "bounceInRight",
          message: arr.message,
          onClosing: () => {
            teachers_subject_table.ajax.reload(null, false);
          },
          overlay: true,
          messageColor: true,
          close: false,
        });
      } else {
        iziToast.error({
          type: "Error",
          position: "bottomLeft",
          message: arr.message,
          progressBar: false,
          position: "topRight",
          overlay: true,
          close: false,
          messageColor: "black",
        });
      }
    });
  });
};

setInterval(function () {
  teachers_subject_table.ajax.reload(null, false);
}, 1000000);

const change_ownership = $("#change_ownership").click((e) => {
  e.preventDefault();
});

function checkTeachersStatus(item) {
  if (item.status === "1") {
    status.html(`<span class="badge badge-pill badge-success">Active</span>
      `);
  } else {
    status.html(`<span class="badge badge-pill badge-danger">InActive</span>`);
  }
}

function changeOwnershipOfSubjects() {
  $.ajax({
    url: "",
  });
}
