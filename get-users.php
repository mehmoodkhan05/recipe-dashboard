<?php
include "db/connection.php";

if (isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
    $sql = "SELECT * FROM `users` WHERE `user_id` = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
}