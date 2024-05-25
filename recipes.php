<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include "navbar.php";
include "db/connection.php";

// Define the API URL
$api_url = 'https://edevz.com/recipe/get_my_recipes.php?user_id=1&limit=600&page=1';

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
                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <th>S#</th>
                      <th>Title</th>
                      <!-- <th>Time to Cook</th> -->
                      <th>Specialities</th>
                      <th>Type</th>
                      <!-- <th>Comments</th> -->
                      <!-- <th>Likes</th> -->
                      <!-- <th>isLiked</th> -->
                      <!-- <th>isFollowed</th> -->
                      <!-- <th>User id</th> -->
                      <!-- <th>Name</th> -->
                      <th>Date</th>
                      <!-- <th>Picture</th> -->
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($error_message)) : ?>
                      <tr>
                        <td colspan="4"><?php echo htmlspecialchars($error_message); ?></td>
                      </tr>
                    <?php elseif (!empty($recipes) && is_array($recipes)) : ?>
                      <?php
                        $itr = 1;
                    
                        ?>
                      <?php foreach ($recipes as $recipe) : ?>

                        <?php
                        // $itr = 1;

                        $dateAndTime = htmlspecialchars($recipe['timestamp']);
                    
                        ?>
                        <tr>
                          <td><?php echo $itr++; ?></td>
                          <td><?php echo htmlspecialchars($recipe['title']); ?></td>
                          <!-- <td><?php // echo htmlspecialchars($recipe['time_to_cook']); ?></td> -->
                          <td><?php echo htmlspecialchars($recipe['specialities']); ?></td>
                          <td><?php echo htmlspecialchars($recipe['meal_type']); ?></td>
                          <!-- <td><?php // echo htmlspecialchars($recipe['total_comments']); ?></td> -->
                          <!-- <td><?php // echo htmlspecialchars($recipe['total_likes']); ?></td> -->
                          <!-- <td><?php // echo htmlspecialchars($recipe['isLiked']); ?></td> -->
                          <!-- <td><?php // echo htmlspecialchars($recipe['isFollowed']); ?></td> -->
                          <!-- <td><?php // echo htmlspecialchars($recipe['user_id']); ?></td> -->
                          <!-- <td><?php // echo htmlspecialchars($recipe['name']); ?></td> -->
                          <td><?php echo substr($dateAndTime, 0, 10) ?></td>
                          <!-- <td><img src="<?php // echo htmlspecialchars($recipe['picture_url']); ?>" class="img-fluid" width></td> -->
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
  <?php include "footer.php" ?>
  
  <script>
    $(document).ready(function() {
      $('.table').DataTable({
        "pageLength": 10
      });
    });
  </script>
</body>