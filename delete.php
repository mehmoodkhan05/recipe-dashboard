<?php
include "db/connection.php";

if (isset($_GET['user_id'])) {
    $id = $_GET["user_id"];
    $sql = "DELETE FROM `users` WHERE user_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        session_destroy();
        header("Location: users.php");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
} else {
    echo "error while deleteing account";
}