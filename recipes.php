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

<style>
  .recipes-page {
    margin-top: 100px;
  }

  table {
    border-spacing: 150px; /* Adjust the spacing value as needed */
  }
</style>

<body>
  <?php include "sidebar.php"; ?>
  <div class="container">
    <div class="recipes-page">
      <h2 class="text-center">Recipes</h2>
      <div class="row justify-content-end">
        <div class="col-10 grid-margin stretch-card">
          <div class="card mt-5">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover" cellspacing="100px">
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
  <?php include "footer.php" ?>
</body>

</html>