<?php
include "navbar.php";
include "db/connection.php";

if (isset($_POST["submit"])) {
    $ingredientsName = $_POST['ingredient_name'];
    $prefUnit = $_POST['pref_unit'];

    $sql = "INSERT INTO `ingredients`(`ingredient_id`, `ingredient_name`, `pref_unit`) 
   VALUES 
   (NULL,'$ingredientsName','$prefUnit')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: ingredients.php");
    } else {
        echo "Failed: " . mysqli_error($conn);
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
            <h3>Add New Ingredient</h3>
            <p class="text-muted mb-0">Complete the form below to add new ingredient</p>
        </div>

        <div class="row justify-content-end">
            <div class="col-10">
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="ingredient_name" id="floatingName" required>
                                <label for="floatingName">Ingredient Name</label>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="pref_unit" id="floatingUnit" required>
                                <label for="floatingName">Pref Unit</label>
                            </div>
                        </div>
                    </div>

                    <div class="users_confirmation-buttons">
                        <button type="submit" class="btn btn-success" name="submit">Add</button>
                        <a href="ingredients.php" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>