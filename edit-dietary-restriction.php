<?php
include "navbar.php";
include "db/connection.php";

if (!isset($_GET["dietary_restrictions_id"]) || !isset($_GET["user_id"])) {
    die("User ID or Dietary Restriction ID is missing.");
}

$dietary_restriction_id = $_GET["dietary_restrictions_id"];
$user_id = $_GET["user_id"];

if (isset($_POST["submit"])) {
    $new_dietary_restriction_name = $_POST['dietary_restriction_name'];

    // Check if new dietary restriction exists and get its ID
    $restriction_check_sql = "SELECT `id` FROM `dietary_restrictions` WHERE `name` = '$new_dietary_restriction_name'";
    echo "Debug: Query - $restriction_check_sql<br>"; // Debugging statement
    $restriction_check_result = mysqli_query($conn, $restriction_check_sql);

    if (!$restriction_check_result) {
        die('Error checking dietary restriction: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($restriction_check_result) > 0) {
        // Dietary restriction found, proceed with update
        echo "Debug: Dietary restriction found<br>"; // Debugging statement
        $restriction_row = mysqli_fetch_assoc($restriction_check_result);
        $new_dietary_restriction_id = $restriction_row['id'];

        // Update the user dietary restriction record with the new dietary restriction ID
        $update_restriction_sql = "UPDATE `user_dietary_restrictions` SET `dietary_restrictions_id` = '$new_dietary_restriction_id' WHERE `user_id` = '$user_id' AND `dietary_restrictions_id` = '$dietary_restriction_id'";
        $update_restriction_result = mysqli_query($conn, $update_restriction_sql);

        if ($update_restriction_result) {
            header("Location: user-dietary-restriction.php?user_id=$user_id");
        } else {
            echo "Failed to update dietary restriction: " . mysqli_error($conn);
        }
    } else {
        echo 'New dietary restriction does not exist.';
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
                            <h3>Edit Dietary Restriction</h3>
                            <p class="text-muted">Click save after changing any information</p>
                        </div>
                        <?php
                        $sql = "SELECT * FROM `dietary_restrictions` WHERE id = $dietary_restriction_id";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        <form action="" method="POST">
                            <input type="hidden" value="<?php echo $dietary_restriction_id ?>"
                                name="dietary_restrictions_id">
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
                                        <label for="floatingName">Dietary Restriction</label>
                                        <input type="text" class="form-control" name="dietary_restriction_name"
                                            value="<?php echo $row['name'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-success" name="submit">Save</button>
                                <a href="user-dietary-restriction.php?user_id=<?php echo $user_id; ?>"
                                    class="btn btn-danger ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>