<?php
include "../db/connection.php";
require '../vendor/autoload.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $sql = "SELECT * FROM `users` WHERE `user_id` = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Generate DOCX using your DOCX library
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addTitle("User Details", 1);
        foreach ($user as $key => $value) {
            $section->addText(ucfirst($key) . ': ' . $value);
        }
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="user_' . $user_id . '.docx"');
        $objWriter->save("php://output");
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}