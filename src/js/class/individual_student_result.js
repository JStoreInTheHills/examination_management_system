var queryString = window.location.search;
var urlParams = new URLSearchParams(queryString);

var student_id = urlParams.get("student_id");
let table = document.getElementById("individual_table");

function createNode(element) {
  return document.createElement(element); // Create the type of element you pass in the parameters
}

function append(parent, el) {
  return parent.appendChild(el); // Append the second parameter(element) to the first one
}

$(function () {
  fetch(`../queries/fetch_individual_result.php?student_id=${student_id}`)
    .then((resp) => resp.json())
    .then(function (data) {
      let items = data;

      for (var i = 0; i < items.length; i++) {
        var item = items[i];

        var subjects = item.subject_name;
        var marks = item.marks;

        var subject = subjects.split(",");
        var mark = marks.split(",");

        for (var x = 0; x < mark.length; x++) {
          var tbody = createNode("tbody");
          var td1 = createNode("td"),
            td2 = createNode("td"),
            td3 = createNode("td"),
            td4 = createNode("td");
          td2.innerHTML = `${mark[x]}`;
          td1.innerHTML = `${subject[x]}`;
          td3.innerHTML = "100";
          td4.innerHTML = `${subject[x]}`;

          append(tbody, td1);
          append(tbody, td2);
          append(tbody, td3);
          append(tbody, td4);
          append(table, tbody);
        }
      }
    });
});
