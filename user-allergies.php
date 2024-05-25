<?php
include "navbar.php";
include "db/connection.php";
include "sidebar.php";
?>

<head>
    <style>
        .allergies_main-page {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="allergies_main-page">
            <h2 class="text-center">User Allergies</h2>
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
                                            <th>Ingredients</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $userId = $_GET['user_id'];
                                        $sql = "SELECT allergies.*, ingredients.ingredient_name FROM allergies
                                        INNER JOIN ingredients ON ingredients.ingredient_id = allergies.ingredient_id
                                        WHERE allergies.user_id = '$userId'";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row["user_id"] ?></td>
                                                <td><?php echo $row["ingredient_name"] ?></td>
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