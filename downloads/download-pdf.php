<?php
include "../db/connection.php";
require '../vendor/autoload.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $sql = "SELECT * FROM `users` WHERE `user_id` = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Generate PDF using your PDF library
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->Cell(0, 10, "User Details", 0, 1, 'C');
        foreach ($user as $key => $value) {
            $pdf->Cell(0, 10, ucfirst($key) . ': ' . $value, 0, 1);
        }
        $pdf->Output('user_' . $user_id . '.pdf', 'D');
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}