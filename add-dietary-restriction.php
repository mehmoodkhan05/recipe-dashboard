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
    $dietaryRestrictionName = $_POST['name'];

    // Check if dietary restriction exists and get its ID
    $restriction_check_sql = "SELECT `id` FROM `dietary_restrictions` WHERE `name` = '$dietaryRestrictionName'";
    $restriction_check_result = mysqli_query($conn, $restriction_check_sql);

    if (!$restriction_check_result) {
        die('Error checking dietary restriction: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($restriction_check_result) > 0) {
        $restriction_row = mysqli_fetch_assoc($restriction_check_result);
        $restriction_id = $restriction_row['id'];

        // Check if the user_id exists in the users table
        $user_check_sql = "SELECT * FROM `users` WHERE `user_id` = '$current_user_id'";
        $user_check_result = mysqli_query($conn, $user_check_sql);

        if (!$user_check_result) {
            die('Error checking user: ' . mysqli_error($conn));
        }

        if (mysqli_num_rows($user_check_result) > 0) {
            // Insert new dietary restriction into user_dietary_restrictions table
            $restriction_sql = "INSERT INTO `user_dietary_restrictions`(`user_id`, `dietary_restrictions_id`) VALUES ('$current_user_id', '$restriction_id')";
            $restriction_result = mysqli_query($conn, $restriction_sql);

            if ($restriction_result) {
                header("Location: user-dietary-restriction.php?user_id=$current_user_id");
            } else {
                die('Failed to add dietary restriction: ' . mysqli_error($conn));
            }
        } else {
            die('User does not exist.');
        }
    } else {
        $error_message = "<div class='alert alert-danger text-center'>No Dietary Restriction Found.</div>";
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
            <h3>Add Dietary Restriction</h3>
            <p class="text-muted mb-0">Complete the form below to add Dietary Restriction</p>
        </div>

        <div class="row justify-content-end">
            <div class="col-10">
                <?php echo $error_message ?>
                <form action="add-dietary-restriction.php?user_id=<?php echo $current_user_id; ?>" method="POST">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="floatingName">Dietary Restriction</label>
                                <input type="text" class="form-control" name="name" id="floatingName" required>
                            </div>
                        </div>
                    </div>

                    <div class="dietary_confirmation-buttons">
                        <button type="submit" class="btn btn-success" name="submit">Add</button>
                        <a href="user-dietary-restriction.php?user_id=<?php echo $current_user_id; ?>"
                            class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>