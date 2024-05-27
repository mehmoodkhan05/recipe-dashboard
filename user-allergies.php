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
                    <div class="top_header-links d-flex">
                        <a href="users.php" class="back_to-user text-decoration-none ms-1 d-flex align-items-center">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div class="add_allergies-btn ms-auto">
                            <a href="add-allergies.php?user_id=<?php echo $_GET['user_id']; ?>"
                                class="btn btn-primary">Add Allergies</a>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Ingredients</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['user_id'])) {
                                            $userId = $_GET['user_id'];
                                            $sql = "SELECT allergies.*, ingredients.ingredient_name FROM allergies
                                                    INNER JOIN ingredients ON ingredients.ingredient_id = allergies.ingredient_id
                                                    WHERE allergies.user_id = '$userId'";
                                            $result = mysqli_query($conn, $sql);
                                            if ($result) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row["user_id"] ?></td>
                                                        <td><?php echo $row["ingredient_name"] ?></td>
                                                        <td>
                                                            <a href="edit-allergies.php?user_id=<?php echo $row["user_id"] ?>&ingredient_id=<?php echo $row["ingredient_id"] ?>"
                                                                class="text-success text-decoration-none" title="edit">
                                                                <i class="fa-solid fa-pen-to-square me-2"></i>
                                                            </a>
                                                            <a href="delete-allergies.php?user_id=<?php echo $row["user_id"]; ?>&ingredient_id=<?php echo $row["ingredient_id"]; ?>"
                                                                class="text-danger text-decoration-none" title="delete">
                                                                <i class="fa-solid fa-trash me-1"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='3'>Error: " . mysqli_error($conn) . "</td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3'>No user ID specified.</td></tr>";
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