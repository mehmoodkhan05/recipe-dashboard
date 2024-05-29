<?php
include "db/connection.php";

if (isset($_GET['user_id']) && isset($_GET['dietary_restrictions_id'])) {
    $user_id = $_GET['user_id'];
    $dietary_restrictions_id = $_GET['dietary_restrictions_id'];

    $sql = "DELETE FROM `user_dietary_restrictions` WHERE user_id = $user_id AND dietary_restrictions_id = $dietary_restrictions_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: user-dietary-restriction.php?user_id=$user_id");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
} else {
    echo "Error while deleting dietary restriction";
}