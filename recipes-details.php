<?php
include "navbar.php";
include "db/connection.php";
include "sidebar.php";

$recipe_id = $_GET['recipe_id'];

// Define the API URL
// $api_url = 'https://edevz.com/recipe/get_my_recipes.php?user_id=1&limit=6&page=1';
$api_url = 'https://edevz.com/recipe/get_recipe_details.php?recipe_id=' . $recipe_id . '&user_id=1';
// echo $api_url;

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
    }
    //   elseif (!isset($data['success']) || !$data['success']) {
    //     $error_message = 'API returned an error.';
    //     $recipes = [];
    //   }
    else {
        $recipes = $data['recipe_details'] ?? [];
        $ingredients = $data['ingredients'] ?? [];
        $steps = $data['steps'] ?? [];
        $comments = $data['comments'] ?? [];
        $reviews = $data['reviews'] ?? [];
        $picture_urls = $data['picture_urls'] ?? [];
    }
}

// Close the cURL session
curl_close($ch);
?>
?>

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .recipes_details-page {
            margin-top: 100px;
        }

        .recipe_img-view .details_colomn {
            padding: 10px 10px;
            background: #C0C0C0;
        }
    </style>
</head>



<body>
    <div class="container">
        <div class="recipes_details-page">
            <h2 class="text-center mb-4">Recipes Details</h2>
            <div class="recipe_img-view">
                <div class="row justify-content-end">
                    <div class="col-5 align-items-center d-flex">
                        <?php if (!empty($picture_urls)): ?>
                            <div id="recipeImageCarousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($picture_urls as $index => $picture_url): ?>
                                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                            <img src="<?php echo htmlspecialchars($picture_url); ?>" alt="Recipe Image"
                                                class="img-fluid">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <a class="carousel-control-prev" href="#recipeImageCarousel" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#recipeImageCarousel" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        <?php else: ?>
                            <img src="" class="img-fluid" alt="No image available">
                        <?php endif; ?>
                    </div>
                    <div class="col-5 details_colomn">
                        <div class="row">
                            <div class="col-6">
                                <p>Total Time: <?php echo htmlspecialchars($recipes['total_time']); ?></p>
                                <p>Cuisine: <?php echo htmlspecialchars($recipes['cuisine']); ?></p>
                                <p>Servings: <?php echo htmlspecialchars($recipes['servings']); ?></p>
                                <p>Specialities 1: <?php echo htmlspecialchars($recipes['specialities1']); ?></p>
                            </div>
                            <div class="col-6">
                                <p>Description: <?php echo htmlspecialchars($recipes['description']); ?></p>
                                <p>Image 1: <?php echo htmlspecialchars($recipes['img1']); ?></p>
                                <p>Status: <?php echo htmlspecialchars($recipes['status']); ?></p>
                                <p>Serving Size: <?php echo htmlspecialchars($recipes['serving_size']); ?></p>
                            </div>
                            <div class="col-12">
                                <p>Source Link: <?php echo htmlspecialchars($recipes['source_link']); ?></p>
                            </div>
                            <div class="col-6">
                                <p>City: <?php echo htmlspecialchars($recipes['city']); ?></p>
                                <p>State: <?php echo htmlspecialchars($recipes['state']); ?></p>
                                <p>Country: <?php echo htmlspecialchars($recipes['country']); ?></p>
                                <p>Calories: <?php echo htmlspecialchars($recipes['calories']); ?></p>
                            </div>
                            <div class="col-6">
                                <p>Protein: <?php echo htmlspecialchars($recipes['protein']); ?></p>
                                <p>Saturated Fat: <?php echo htmlspecialchars($recipes['saturated_fat']); ?></p>
                                <p>Fat: <?php echo htmlspecialchars($recipes['fat']); ?></p>
                                <p>Carbohydrates: <?php echo htmlspecialchars($recipes['carbohydrates']); ?></p>
                            </div>
                            <div class="col-6">
                                <p>Fiber: <?php echo htmlspecialchars($recipes['fiber']); ?></p>
                                <p>Sodium: <?php echo htmlspecialchars($recipes['sodium']); ?></p>
                                <p>Sugar: <?php echo htmlspecialchars($recipes['sugar']); ?></p>
                                <p>Cholesterol: <?php echo htmlspecialchars($recipes['cholesterol']); ?></p>
                                <p>View Count: <?php echo htmlspecialchars($recipes['view_count']); ?></p>
                            </div>
                            <div class="col-6">
                                <p>Video Calling: <?php echo htmlspecialchars($recipes['video_calling']); ?></p>
                                <p>Rating: <?php echo htmlspecialchars($recipes['rating']); ?></p>
                                <p>Cooking Tips: <?php echo htmlspecialchars($recipes['cooking_tips']); ?></p>
                                <p>Ingredient Count: <?php echo htmlspecialchars($recipes['ingredient_count']); ?></p>
                                <p>Earn Session: <?php echo htmlspecialchars($recipes['earn_per_session']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ingredients_steps-view">
                <div class="row justify-content-end">
                    <div class="col-5">
                        <div class="card mt-5">
                            <h5 class="text-center mt-2">Ingredients</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <!-- <th>Extra</th> -->
                                                <th>Name</th>
                                                <!-- <th>Icon URL</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ingredients as $ingredient): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($ingredient['ingredient_quantity']); ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($ingredient['ingredient_unit']); ?>
                                                    </td>
                                                    <!-- <td><?php // echo htmlspecialchars($ingredient['extra']); ?></td> -->
                                                    <td><?php echo htmlspecialchars($ingredient['ingredient_name']); ?>
                                                    </td>
                                                    <!-- <td><?php // echo htmlspecialchars($ingredient['icon_url']); ?></td> -->
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-5">
                        <div class="card mt-5">
                            <div class="card-body">
                                <h5 class="text-center mt-2">Steps</h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <!-- <th>id</th> -->
                                                <!-- <th>Recipe id</th> -->
                                                <!-- <th>Number</th> -->
                                                <th>Body</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($steps as $step): ?>
                                                <tr>
                                                    <!-- <td><?php // echo htmlspecialchars($step['step_id']); ?></td> -->
                                                    <!-- <td><?php // echo htmlspecialchars($step['recipe_id']); ?></td> -->
                                                    <!-- <td><?php // echo htmlspecialchars($step['step_number']); ?></td> -->
                                                    <td><?php echo htmlspecialchars($step['step_body']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="comments_reviews-view">
                <div class="row justify-content-end">
                    <div class="col-5">
                        <div class="card mt-5">
                            <h5 class="text-center mt-2">Comments</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <!-- <th>id</th> -->
                                                <!-- <th>User id</th> -->
                                                <!-- <th>Recipe id</th> -->
                                                <th>Body</th>
                                                <!-- <th>Time Stamp</th> -->
                                                <th>Username</th>
                                                <th>Like Count</th>
                                                <th>Likes</th>
                                                <th>Replies</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($comments)): ?>
                                                <?php foreach ($comments as $comment): ?>
                                                    <tr>
                                                        <!-- <td><?php // echo htmlspecialchars($comments['id']); ?></td> -->
                                                        <!-- <td><?php // echo htmlspecialchars($comments['user_id']); ?></td> -->
                                                        <!-- <td><?php // echo htmlspecialchars($comments['recipe_id']); ?></td> -->
                                                        <td><?php echo htmlspecialchars($comments['comment_body']); ?></td>
                                                        <!-- <td><?php // echo htmlspecialchars($comments['timestamp']); ?></td> -->
                                                        <td><?php echo htmlspecialchars($comments['user_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($comments['like_count']); ?></td>
                                                        <td><?php echo htmlspecialchars($comments['likes']); ?></td>
                                                        <td><?php echo htmlspecialchars($comments['replies']); ?></td>
                                                    </tr>
                                                    <?php if (!empty($comment['replies'])): ?>
                                                        <tr>
                                                            <td colspan="6" class="comment-replies">
                                                                <strong>Replies:</strong>
                                                                <ul>
                                                                    <?php foreach ($comment['replies'] as $reply): ?>
                                                                        <li>
                                                                            <strong><?php echo htmlspecialchars($reply['user_name'] ?? 'N/A'); ?>:</strong>
                                                                            <?php echo htmlspecialchars($reply['body'] ?? 'N/A'); ?>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No comments found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-5">
                        <div class="card mt-5">
                            <div class="card-body">
                                <h5 class="text-center mt-2">Reviews</h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <!-- <th>id</th> -->
                                                <!-- <th>Recipe id</th> -->
                                                <!-- <th>User id</th> -->
                                                <th>Stars</th>
                                                <th>Comments</th>
                                                <!-- <th>Time Stamp</th> -->
                                                <th>Username</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($reviews)): ?>
                                                <?php foreach ($reviews as $review): ?>
                                                    <tr>
                                                        <!-- <td><?php // echo htmlspecialchars($reviews['review_id']); ?></td> -->
                                                        <!-- <td><?php // echo htmlspecialchars($reviews['recipe_id']); ?></td> -->
                                                        <!-- <td><?php // echo htmlspecialchars($reviews['user_id']); ?></td> -->
                                                        <td><?php echo htmlspecialchars($reviews['no_of_stars']); ?></td>
                                                        <td><?php echo htmlspecialchars($reviews['comment']); ?></td>
                                                        <!-- <td><?php // echo htmlspecialchars($reviews['timestamp']); ?></td> -->
                                                        <td><?php echo htmlspecialchars($reviews['user_name']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No reviews found.</td>
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
    </div>
    <?php include "footer.php" ?>
</body>