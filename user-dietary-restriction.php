<?php
include "navbar.php";
include "db/connection.php";
include "sidebar.php";
?>

<head>
    <style>
        .dietary_restriction-page {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="dietary_restriction-page">
            <h2 class="text-center">User Dietary Restriction</h2>
            <div class="row justify-content-lg-end justify-content-center">
                <div class="col-lg-10">
                    <a href="users.php" class="back_to-user text-decoration-none ms-1">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Dietary Restriction</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $userId = $_GET['user_id'];
                                        $sql = "SELECT user_dietary_restrictions.*, dietary_restrictions.name FROM user_dietary_restrictions
                                        INNER JOIN dietary_restrictions ON dietary_restrictions.id = user_dietary_restrictions.dietary_restrictions_id
                                        WHERE user_dietary_restrictions.user_id = '$userId'";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row["user_id"] ?></td>
                                                <td><?php echo $row["name"] ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <?php include "footer.php" ?> -->
</body>