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
        $sql = "UPDATE `users` SET `email`='$email',
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
        $sql = "UPDATE `users` SET `email`='$email',
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
        <div class="row justify-content-end">
            <div class="col-10">
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
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <label for="floatingName">Email</label>
                                        <input readonly type="text" class="form-control" name="email" value="<?php echo $row['email'] ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <label for="floatingdob">Phone</label>
                                        <input readonly type="text" class="form-control" name="phoneNumber" value="<?php echo $row['phoneNumber'] ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <label for="floatingName">location Latitude</label>
                                        <input type="text" class="form-control" name="locationLatitude" value="<?php echo $row['locationLatitude'] ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <label for="floatingName">location Longitude</label>
                                        <input type="text" class="form-control" name="locationLongitude" value="<?php echo $row['locationLongitude'] ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <label for="floatingName">Name</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <label for="floatingName">Type</label>
                                        <input type="text" class="form-control" name="type" value="<?php echo $row['type']; ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <label for="floatingName">Token</label>
                                        <input type="text" class="form-control" name="token" value="<?php echo $row['token']; ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <label for="floatingName">Description</label>
                                        <input type="text" class="form-control" name="description" value="<?php echo $row['description']; ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <label for="floatingName">Coins</label>
                                        <input type="text" class="form-control" name="coins" value="<?php echo $row['coins']; ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-floating mb-3">
                                        <label for="floatingPassword">Password</label>
                                        <input type="password" class="form-control" name="password" value="">
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