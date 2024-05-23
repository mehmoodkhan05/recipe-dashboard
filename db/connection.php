<?php
$host = "localhost";
$name= "root";
$password = "";
$dbname = "recepians";

$conn = mysqli_connect("$host", "$name", "$password", "$dbname");

if (!$conn) {
    die("Connection failed" . mysqli_connect_error());
}