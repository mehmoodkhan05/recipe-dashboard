<?php
include "navbar.php";
include "db/connection.php";

$error_message = "";

// Check if user_id is passed via URL
if (!isset($_GET['user_id'])) {
    die('User ID is not specified.');
}

$current_user_id = $_GET['user_id'];

if (isset($_POST["submit"])) {
    $ingredientsName = $_POST['ingredient_name'];

    // Check if ingredient exists and get its ID
    $ingredient_check_sql = "SELECT `ingredient_id` FROM `ingredients` WHERE `ingredient_name` = '$ingredientsName'";
    $ingredient_check_result = mysqli_query($conn, $ingredient_check_sql);

    if (!$ingredient_check_result) {
        die('Error checking ingredient: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($ingredient_check_result) > 0) {
        $ingredient_row = mysqli_fetch_assoc($ingredient_check_result);
        $ingredient_id = $ingredient_row['ingredient_id'];

        // Check if the user_id exists in the users table
        $user_check_sql = "SELECT * FROM `users` WHERE `user_id` = '$current_user_id'";
        $user_check_result = mysqli_query($conn, $user_check_sql);

        if (!$user_check_result) {
            die('Error checking user: ' . mysqli_error($conn));
        }

        if (mysqli_num_rows($user_check_result) > 0) {
            // Insert new allergy into allergies table
            $allergy_sql = "INSERT INTO `allergies`(`user_id`, `ingredient_id`) VALUES ('$current_user_id', '$ingredient_id')";
            $allergy_result = mysqli_query($conn, $allergy_sql);

            if ($allergy_result) {
                header("Location: user-allergies.php?user_id=$current_user_id");
            } else {
                die('Failed to add allergy: ' . mysqli_error($conn));
            }
        } else {
            die('User does not exist.');
        }
    } else {
        $error_message = "<div class='alert alert-danger text-center'>No Ingredient Found.</div>";
    }
}
?>

<style>
    .container {
        margin-top: 100px;
    }
</style>

<body>
    <?php include "sidebar.php" ?>
    <div class="container">
        <div class="text-center mb-4">
            <h3>Add Allergy</h3>
            <p class="text-muted mb-0">Complete the form below to add Allergy</p>
        </div>
        
        <div class="row justify-content-end">
            <div class="col-10">
                <?php echo $error_message ?>
                <form action="add-allergies.php?user_id=<?php echo $current_user_id; ?>" method="POST">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="floatingName">Ingredient</label>
                                <input type="text" class="form-control" name="ingredient_name" id="floatingName"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="users_confirmation-buttons">
                        <button type="submit" class="btn btn-success" name="submit">Add</button>
                        <a href="user-allergies.php?user_id=<?php echo $current_user_id; ?>" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>