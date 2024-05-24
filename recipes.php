<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include "navbar.php";
include "db/connection.php";

// Define the API URL
$api_url = 'https://edevz.com/recipe/get_my_recipes.php?user_id=1&limit=6&page=1';

// Initialize a cURL session
$ch = curl_init();

// Set the cURL options
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
  $error_message = 'Error:' . curl_error($ch);
  $recipes = [];
} else {
  // Decode the JSON response to a PHP array
  $data = json_decode($response, true);

  // Check if json_decode() failed
  if (json_last_error() !== JSON_ERROR_NONE) {
    $error_message = 'Invalid JSON response: ' . json_last_error_msg();
    $recipes = [];
  } elseif (!isset($data['success']) || !$data['success']) {
    $error_message = 'API returned an error.';
    $recipes = [];
  } else {
    $recipes = $data['recipes'] ?? [];
  }
}

// Close the cURL session
curl_close($ch);
?>

<head>

  <style>
    .recipes-page {
      margin-top: 100px;
    }

    th,
    tr {
      padding: 0 -50px;
    }

    .serving-text {
      padding: 10px 20px;
      background: lightcoral;
      border-radius: 10px;
    }
  </style>
</head>


<body>
  <?php include "sidebar.php"; ?>
  <div class="container">
    <div class="recipes-page">
      <h2 class="text-center">Recipes</h2>
      
      <div class="row justify-content-end">
        <div class="col-lg-10 col-12">
          <div class="card mt-5">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>id</th>
                      <th>Title</th>
                      <th>Time to Cook</th>
                      <th>Specialities</th>
                      <th>Meal Type</th>
                      <th>Total Comments</th>
                      <th>Total Likes</th>
                      <th>isLiked</th>
                      <th>isFollowed</th>
                      <th>User id</th>
                      <th>Name</th>
                      <th>Time Stamp</th>
                      <th>Picture</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($error_message)) : ?>
                      <tr>
                        <td colspan="4"><?php echo htmlspecialchars($error_message); ?></td>
                      </tr>
                    <?php elseif (!empty($recipes) && is_array($recipes)) : ?>
                      <?php foreach ($recipes as $recipe) : ?>
                        <tr>
                          <td><?php echo htmlspecialchars($recipe['recipe_id']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['title']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['time_to_cook']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['specialities']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['meal_type']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['total_comments']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['total_likes']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['isLiked']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['isFollowed']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['user_id']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['name']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['timestamp']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['picture_url']); ?></td>
                          <td>
                            <a href="recipes-details.php?recipe_id=<?php echo $recipe['recipe_id'] ?>">
                              <i class="fa-solid fa-eye me-5"></i>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <tr>
                        <td colspan="4">No recipes found.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">Recipes Info</h5>
        </div>
        <div class="modal-body">
          <div class="recipe_img text-center mb-4">
            <!-- <img src="assets/img/user.png" alt="" class="img-fluid"> -->
            <!-- <img src="" alt="" class="img-fluid rounded-circle"> -->
          </div>
          <div class="container">
            <h2 class="text-heading">Berry Caremal Pancakes</h2>
            <h5 class="author-text text-danger">By Srasti Gupta</h5>
            <div class="buttons mt-3">
              <a href="#" class="btn btn-danger rounded">Healthy</a>
              <a href="#" class="btn btn-danger rounded">High Protein</a>
            </div>
            <div class="serving-text d-flex mt-4">
              <h5 class="text-dark m-0 align-items-center d-flex">Servings</h5>
              <div class="increment_decrement-btn ml-auto">
                <button class="btn btn-light bg-white text-dark rounded-circle">-</button>
                <span class="ml-2 mr-2 text-dark">3</span>
                <button class="btn btn-light bg-white text-dark rounded-circle">+</button>
              </div>
            </div>
            <div class="facts mt-4">
              <h5>Nutrition <span style="color: red;">Facts</span></h5>
              <div class="row">
                <div class="col-lg-3">
                  <p class="mb-0">14g</p>
                  <p>Protein</p>
                </div>

                <div class="col-lg-3">
                  <p class="mb-0">14g</p>
                  <p>Protein</p>
                </div>

                <div class="col-lg-3">
                  <p class="mb-0">14g</p>
                  <p>Protein</p>
                </div>

                <div class="col-lg-3">
                  <p class="mb-0">14g</p>
                  <p>Protein</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php include "footer.php" ?>
  <script>
    $(document).ready(function() {
      $('.table').DataTable({
        "pageLength": 25
      });
    });
  </script>
</body>