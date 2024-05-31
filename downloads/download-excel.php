<?php
include "../db/connection.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $sql = "SELECT * FROM `users` WHERE `user_id` = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set user details in the sheet
        $sheet->setCellValue('A1', 'Field');
        $sheet->setCellValue('B1', 'Value');

        $row = 2;
        foreach ($user as $key => $value) {
            $sheet->setCellValue('A' . $row, ucfirst($key));
            $sheet->setCellValue('B' . $row, $value);
            $row++;
        }

        // Generate Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'user_' . $user_id . '.xlsx';

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}