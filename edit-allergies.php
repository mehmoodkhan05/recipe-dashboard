<?php
include "navbar.php";
include "db/connection.php";

if (!isset($_GET["ingredient_id"]) || !isset($_GET["user_id"])) {
    die("User ID or Ingredient ID is missing.");
}

$ingredient_id = $_GET["ingredient_id"];
$user_id = $_GET["user_id"];

if (isset($_POST["submit"])) {
    $new_ingredient_name = $_POST['ingredient_name'];

    // Check if new ingredient exists and get its ID
    $ingredient_check_sql = "SELECT `ingredient_id` FROM `ingredients` WHERE `ingredient_name` = '$new_ingredient_name'";
    echo "Debug: Query - $ingredient_check_sql<br>"; // Debugging statement
    $ingredient_check_result = mysqli_query($conn, $ingredient_check_sql);

    if (!$ingredient_check_result) {
        die('Error checking ingredient: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($ingredient_check_result) > 0) {
        // Ingredient found, proceed with update
        echo "Debug: Ingredient found<br>"; // Debugging statement
        $ingredient_row = mysqli_fetch_assoc($ingredient_check_result);
        $new_ingredient_id = $ingredient_row['ingredient_id'];

        // Update the allergy record with the new ingredient ID
        $update_allergy_sql = "UPDATE `allergies` SET `ingredient_id` = '$new_ingredient_id' WHERE `user_id` = '$user_id' AND `ingredient_id` = '$ingredient_id'";
        $update_allergy_result = mysqli_query($conn, $update_allergy_sql);

        if ($update_allergy_result) {
            header("Location: user-allergies.php?user_id=$user_id");
        } else {
            echo "Failed to update allergy: " . mysqli_error($conn);
        }
    } else {
        // Retry checking for new ingredient
        sleep(1); // Add a short delay before retrying (adjust as needed)
        $ingredient_check_result = mysqli_query($conn, $ingredient_check_sql);
        if (mysqli_num_rows($ingredient_check_result) > 0) {
            // New ingredient found, update allergy
            $ingredient_row = mysqli_fetch_assoc($ingredient_check_result);
            $new_ingredient_id = $ingredient_row['ingredient_id'];

            $update_allergy_sql = "UPDATE `allergies` SET `ingredient_id` = '$new_ingredient_id' WHERE `user_id` = '$user_id' AND `ingredient_id` = '$ingredient_id'";
            $update_allergy_result = mysqli_query($conn, $update_allergy_sql);

            if ($update_allergy_result) {
                header("Location: user-allergies.php?user_id=$user_id");
            } else {
                echo "Failed to update allergy: " . mysqli_error($conn);
            }
        } else {
            echo 'New ingredient does not exist.';
        }
    }
}
?>

<body>
    <style>
        .content-wrapper {
            margin-top: 100px;
        }
    </style>

    <!-- partial -->
    <?php include "sidebar.php" ?>
    <div class="container">
        <!-- partial -->
        <div class="row justify-content-lg-end justify-content-center">
            <div class="col-lg-10">
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="text-center mb-4">
                            <h3>Edit Allergies</h3>
                            <p class="text-muted">Click save after changing any information</p>
                        </div>
                        <?php
                        $sql = "SELECT * FROM `ingredients` WHERE ingredient_id = $ingredient_id";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        <form action="" method="POST">
                            <input type="hidden" value="<?php echo $ingredient_id ?>" name="id">
                            <input type="hidden" value="<?php echo $user_id ?>" name="user_id">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="mb-3">
                                        <label for="floatingName">User ID</label>
                                        <input type="text" class="form-control" name="user_id"
                                            value="<?php echo $user_id ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6">
                                    <div class="mb-3">
                                        <label for="floatingName">Ingredient</label>
                                        <input type="text" class="form-control" name="ingredient_name"
                                            value="<?php echo $row['ingredient_name'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-success" name="submit">Save</button>
                                <a href="user-allergies.php?user_id=<?php echo $user_id; ?>"
                                    class="btn btn-danger ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>