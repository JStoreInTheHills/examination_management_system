const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const class_name = urlParams.get("cid");
const academic_year = urlParams.get("yid");

const heading = $("#heading");
const academic_title = $("#academic_title");
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
    url : "../queries/get_year_details",
    type : "GET",
    data : {
      year_id: academic_year
    },
  }).done((response)=>{
    const arr = JSON.parse(response);
    arr.forEach(items =>{
      heading.html(`Academic Year: ${items.year_name}`);
      academic_title.html(`${items.year_name}`);
      bread_list.html(`<a href="/academic_year/page/view_academic_year?year_id=${items.year_id}">${items.year_name}</a>`
      );
      
    });
    getClassDetails();
  });
}

init();

const getClassDetails = () => {
  $.ajax({
      url : "../queries/get_class_details_for_final_result_show.php",
      type : "GET",
      data : {
        class_id: class_name
      },
    }).done((response)=>{
      const arr = JSON.parse(response);
      arr.forEach(items =>{
       class_name_title.html(`${items.ClassName} (${items.ClassNameNumeric})`);
       class_creation_date.html(`Date Created: ${items.CreationDate}`);
       class_teachers_name.html(`Class Teacher: ${items.name}`);
       $("#bread_list2").html(`${items.ClassName}`);
      })
    });
}

const table = $("#table").DataTable({
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
      data: "status",
      render: function (data) {
        if(data == 1){
          return `<span class="badge badge-pill badge-success">Active</span>`;
        }else{
           return `<span class="badge badge-pill badge-danger">Inactive</span>`;
        }
      },
    },
    {
      targets: 3,
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
        LastName : "LastName",
        OtherNames : "OtherNames",
      },
      render: function (data) {
        return `<a href="./page/print_result.php?sid=${data.StudentId}">${data.FirstName} ${data.OtherNames} ${data.LastName}</a>`;
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
        if(data == 1){
           return `<span class="badge badge-pill badge-success">Active</span>`;
        }else{
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
