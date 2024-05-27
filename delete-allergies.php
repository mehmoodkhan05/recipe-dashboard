<?php
include "db/connection.php";

if (isset($_GET['user_id']) && isset($_GET['ingredient_id'])) {
    $user_id = $_GET['user_id'];
    $ingredient_id = $_GET['ingredient_id'];

    $sql = "DELETE FROM `allergies` WHERE user_id = $user_id AND ingredient_id = $ingredient_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: user-allergies.php?user_id=$user_id");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
} else {
    echo "Error while deleting allergy";
}