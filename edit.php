<?php
include "navbar.php";
include "db/connection.php";

$id = $_GET["user_id"];

if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $locationLatitude = $_POST['locationLatitude'];
    $locationLongitude = $_POST['locationLongitude'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $token = $_POST['token'];
    $description = $_POST['description'];
    $coins = $_POST['coins'];
    $password = $_POST['password'];

    // Update user data in the MySQL database
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE `users` SET 
            `email`='$email',
            `phoneNumber`='$phoneNumber',
            `locationLatitude`='$locationLatitude',
            `locationLongitude`='$locationLongitude',
            `name`='$name',
            `type`='$type',
            `token`='$token',
            `description`='$description',
            `coins`='$coins',
            `password`='$hashedPassword'
            WHERE user_id = $id";
    } else {
        $sql = "UPDATE `users` SET 
            `email`='$email',
            `phoneNumber`='$phoneNumber',
            `locationLatitude`='$locationLatitude',
            `locationLongitude`='$locationLongitude',
            `name`='$name',
            `type`='$type',
            `token`='$token',
            `description`='$description',
            `coins`='$coins'
            WHERE user_id = $id";
    }

    $result = mysqli_query($conn, $sql);

    // Handle profile image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageType = $_FILES['image']['type'];
        $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageExt, $allowedExts)) {
            $uploadDir = 'assets/img/users/';
            $imagePath = $uploadDir . basename($imageName);
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Check if user has an existing image
            $sql_existing_image = "SELECT image FROM `users` WHERE user_id = $id";
            $result_existing_image = mysqli_query($conn, $sql_existing_image);
            if ($result_existing_image && mysqli_num_rows($result_existing_image) > 0) {
                $row = mysqli_fetch_assoc($result_existing_image);
                $existingImage = $row['image'];
                // Delete the old image file
                if (file_exists($existingImage)) {
                    unlink($existingImage);
                }
            }

            if (move_uploaded_file($imageTmpPath, $imagePath)) {
                // Update the profile image path in the database
                $sql_update_image = "UPDATE `users` SET `image`='$imagePath' WHERE user_id = $id";
                $result_update_image = mysqli_query($conn, $sql_update_image);
                if (!$result_update_image) {
                    echo "Failed to update profile image: " . mysqli_error($conn);
                }
            } else {
                echo "Error uploading the file.";
            }
        } else {
            echo "Invalid file extension.";
        }
    }

    if ($result) {
        header("Location: users.php");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
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
    <div class="container page-body-wrapper">
        <!-- partial -->
        <div class="row justify-content-lg-end justify-content-center">
            <div class="col-lg-10">
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="text-center mb-4">
                            <h3>Edit User Information</h3>
                            <p class="text-muted">Click save after changing any information</p>
                        </div>
                        <?php
                        $sql = "SELECT * FROM `users` WHERE user_id = $id LIMIT 1";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="floatingName">Email</label>
                                        <input readonly type="text" class="form-control" name="email"
                                            value="<?php echo $row['email'] ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="floatingdob">Phone</label>
                                        <input readonly type="text" class="form-control" name="phoneNumber"
                                            value="<?php echo $row['phoneNumber'] ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="floatingName">location Latitude</label>
                                        <input type="text" class="form-control" name="locationLatitude"
                                            value="<?php echo $row['locationLatitude'] ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="floatingName">location Longitude</label>
                                        <input type="text" class="form-control" name="locationLongitude"
                                            value="<?php echo $row['locationLongitude'] ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="floatingName">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="<?php echo $row['name']; ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="floatingName">Type</label>
                                        <input type="text" class="form-control" name="type"
                                            value="<?php echo $row['type']; ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="floatingName">Token</label>
                                        <input type="text" class="form-control" name="token"
                                            value="<?php echo $row['token']; ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="floatingName">Description</label>
                                        <input type="text" class="form-control" name="description"
                                            value="<?php echo $row['description']; ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="floatingName">Coins</label>
                                        <input type="text" class="form-control" name="coins"
                                            value="<?php echo $row['coins']; ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="floatingPassword">Update Password</label>
                                        <input type="password" class="form-control" name="password" value="">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label for="floatingProfile">Update Profile</label>
                                        <input type="file" class="form-control" name="image" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-success" name="submit">Save</button>
                                <a href="users.php" class="btn btn-danger ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>
</body>