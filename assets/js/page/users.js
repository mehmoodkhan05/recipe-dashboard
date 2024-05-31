$(document).ready(function () {
  $(".select2").select2();

  $("#mainSelect").on("change", function () {
    const selectedField = $(this).val();
    if (selectedField !== "") {
      $("#searchContainer").html(`
      <div class='input_container'>
        <input type="text" id="searchQuery" class="form-control ms-2" placeholder="Search by ${selectedField}">
        <button class="ms-2 bg-transparent border-0" onclick="searchUsers('${selectedField}')"><i class="fas fa-search"></i></button>
      </div>
  `);
    } else {
      $("#searchContainer").empty();
    }
  });

  // Event delegation for dynamically created search button
  $(document).on("click", "#searchButton", function () {
    const selectedField = $("#mainSelect").val();
    searchUsers(selectedField);
  });

  // Function for closing modal
  $(document).ready(function () {
    // Close modal when close button is clicked
    $(".btn-close").click(function () {
      $(".modal").modal("hide");
    });
  });

  // Function to view user details
  $(document).on("click", ".view-user", function () {
    const userId = $(this).data("id");
    $.ajax({
      url: "get-users.php",
      type: "POST",
      data: { user_id: userId },
      success: function (response) {
        const user = JSON.parse(response);
        // Set user details
        $("#modalEmail").val(user.email);
        $("#modalPhone").val(user.phoneNumber);
        $("#modalLocationLatitude").val(user.locationLatitude);
        $("#modalLocationLongitude").val(user.locationLongitude);
        $("#modalName").val(user.name);
        $("#modalType").val(user.type);
        $("#modalToken").val(user.token);
        $("#modalDescriptions").val(user.description);
        $("#modalCoins").val(user.coins);
        // Set user image
        $("#modalImage").attr("src", "assets/img/users/" + user.image);
      },
      error: function () {
        alert("An error occurred while fetching user data.");
      },
    });
  });
});

// Function to search users
function searchUsers(field) {
  const query = $("#searchQuery").val().trim();
  if (query === "") {
    alert("Please enter to search!");
    return;
  }

  $.ajax({
    url: "get-search.php",
    type: "POST",
    data: { field: field, query: query },
    success: function (response) {
      const users = JSON.parse(response);
      const tbody = $("#userTableBody");
      tbody.empty();

      if (users.length === 0) {
        $("#noUserMessage").text("No users found.");
      } else {
        users.forEach((user) => {
          const tr = `
                      <tr>
                          <td>${user.user_id}</td>
                          <td>${user.email}</td>
                          <td>${user.phoneNumber}</td>
                          <td>${user.name}</td>
                          <td>
                              <a href="#" data-id="${user.user_id}" data-toggle="modal"
                                  data-target="#userModal" class="view-user text-decoration-none"
                                  title="view">
                                  <i class="fa-solid fa-eye me-2"></i>
                              </a>
                              <a href="edit.php?user_id=${user.user_id}"
                                  class="text-success text-decoration-none" title="edit">
                                  <i class="fa-solid fa-pen-to-square me-2"></i>
                              </a>
                              <a href="delete.php?user_id=${user.user_id}"
                                  class="text-danger text-decoration-none" title="delete">
                                  <i class="fa-solid fa-trash me-1"></i>
                              </a>
                              <a href="user-allergies.php?user_id=${user.user_id}"
                                  class="text-decoration-none" title="Allergies">
                                  <i class="fas fa-allergies"></i>
                              </a>
                              <a href="user-dietary-restriction.php?user_id=${user.user_id}"
                                  class="text-decoration-none" title="Dietary Restriction">
                                  Dietary Restriction
                              </a>
                          </td>
                      </tr>
                  `;
          tbody.append(tr);
        });
      }
    },
    error: function () {
      alert("An error occurred while processing your request.");
    },
  });
}
