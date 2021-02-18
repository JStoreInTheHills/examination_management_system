async function get_school_name() {
  const school = {};
  const request = await fetch(`../../admin/queries/get_school.php`);
  const response = await request.text();
  const arr = JSON.parse(response);

  arr.forEach((key) => {
    school.name = key.school_name;
    school.id = key.id;
  });

  return school;
}

const school = get_school_name()
  .then((res) => {
    sessionStorage.setItem("school_name", res.name);
    sessionStorage.setItem("school_id", res.id);
    $("#index_heading").val(sessionStorage.getItem("school_name"));
  })
  .catch((err) => console.log(err));
