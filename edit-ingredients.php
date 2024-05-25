<?php
include "navbar.php";
include "db/connection.php";

$id = $_GET["ingredient_id"];

if (isset($_POST["submit"])) {
    $ingredientsName = $_POST['ingredient_name'];
    $prefUnit = $_POST['pref_unit'];

    $sql = "UPDATE `ingredients` SET `ingredient_name`='$ingredientsName',`pref_unit`='$prefUnit'
    WHERE ingredient_id = $id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: ingredients.php");
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
    <div class="container">
        <!-- partial -->
        <div class="row justify-content-lg-end justify-content-center">
            <div class="col-lg-10">
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="text-center mb-4">
                            <h3>Edit Ingredient</h3>
                            <p class="text-muted">Click save after changing any information</p>
                        </div>
                        <?php
                        $sql = "SELECT * FROM `ingredients` WHERE ingredient_id = $id LIMIT 1";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="mb-3">
                                        <label for="floatingName">Ingredient Name</label>
                                        <input type="text" class="form-control" name="ingredient_name" value="<?php echo $row['ingredient_name'] ?>">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6">
                                    <div class="mb-3">
                                        <label for="floatingUnit">Pref Unit</label>
                                        <input type="text" class="form-control" name="pref_unit" value="<?php echo $row['pref_unit'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-success" name="submit">Save</button>
                                <a href="ingredients.php" class="btn btn-danger ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>