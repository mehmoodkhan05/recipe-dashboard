<?php
include "navbar.php";
include "db/connection.php";
?>

<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <style>
        .ingredients-panel {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include "sidebar.php"; ?>
        <!-- partial -->
        <div class="ingredients-panel">
            <div class="content-wrapper">
                <h2 class="text-center">Ingredients</h2>
                <div class="row justify-content-end">
                    <div class="col-10">
                        <div class="add_ingredients-btn justify-content-end d-flex mb-3">
                            <a href="add-ingredients.php" class="btn btn-primary">Add Ingredients</a>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>name</th>
                                                <th>pref unit</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM `ingredients`";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row["ingredient_id"] ?></td>
                                                    <td><?php echo $row["ingredient_name"] ?></td>
                                                    <td><?php echo $row["pref_unit"] ?></td>
                                                    <td>
                                                        <a href="edit-ingredients.php?ingredient_id=<?php echo $row["ingredient_id"] ?>" class="text-success">
                                                            <i class="fa-solid fa-pen-to-square me-3"></i>
                                                        </a>
                                                        <a href="delete-ingredients.php?ingredient_id=<?php echo $row["ingredient_id"] ?>" class="text-danger">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
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
    </div>
    <?php include "footer.php" ?>
    <script>
        // $(document).ready(function() {
            $('.table').DataTable({
                "pageLength": 25
            });
        // });
    </script>
</body>