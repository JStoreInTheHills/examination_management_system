const teacher_module_table = $("#teacher_module_table");

teacher_module_table.DataTable({
  ajax: {
    url: "./subject_class.json",
    dataSrc: "",
    data: [],
  },
  columns: [
    {
      data: "ClassName",
      render: (data) => {
        return `<a href="${data}">${data}</a>`;
      },
    },
    { data: "SubjectName" },
    { data: "SubjectCode" },
  ],
});
