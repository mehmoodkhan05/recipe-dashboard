<?php
include "db/connection.php";

// if (isset($_GET['search'])) {
//     $search = $_GET['search'];

//     // Perform search query to select all fields
//     $sql = "SELECT `user_id`, `email`, `phoneNumber`, `locationLatitude`, `locationLongitude`, `name`, `type`, `token`, `description`, `coins`
//             FROM `users`
//             WHERE `user_id` LIKE '%$search%'
//                OR `name` LIKE '%$search%'
//                OR `email` LIKE '%$search%'
//                OR `phoneNumber` LIKE '%$search%'
//                OR `locationLatitude` LIKE '%$search%'
//                OR `locationLongitude` LIKE '%$search%'
//                OR `type` LIKE '%$search%'
//                OR `token` LIKE '%$search%'
//                OR `description` LIKE '%$search%'
//                OR `coins` LIKE '%$search%'";
//     $result = mysqli_query($conn, $sql);

//     // Prepare data for Select2
//     $users = array();
//     while ($row = mysqli_fetch_assoc($result)) {
//         $users[] = array(
//             'id' => $row['user_id'],
//             'text' => $row['name'],
//             'email' => $row['email'],
//             'phoneNumber' => $row['phoneNumber'],
//             'locationLatitude' => $row['locationLatitude'],
//             'locationLongitude' => $row['locationLongitude'],
//             'name' => $row['name'],
//             'type' => $row['type'],
//             'token' => $row['token'],
//             'description' => $row['description'],
//             'coins' => $row['coins']
//         );
//     }

//     // Return JSON response
//     echo json_encode($users);
// }

if (isset($_POST['field']) && isset($_POST['query'])) {
    $field = $_POST['field'];
    $query = $_POST['query'];
    $sql = "SELECT * FROM `users` WHERE `$field` LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);
    $users = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    echo json_encode($users);
}