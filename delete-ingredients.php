<?php
include "db/connection.php";

if (isset($_GET['ingredient_id'])) {
    $id = $_GET["ingredient_id"];
    $sql = "DELETE FROM `ingredients` WHERE ingredient_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        session_destroy();
        header("Location: ingredients.php");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
} else {
    echo "error while deleteing ingredients";
}