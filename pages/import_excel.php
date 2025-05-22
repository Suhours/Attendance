<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_FILES['attendance_file']['tmp_name']) {
    $file = $_FILES['attendance_file']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $data = $spreadsheet->getActiveSheet()->toArray();

    // Example: Loop through data and save to database
    foreach ($data as $row) {
        $student_name = $row[0]; // Assuming the first column contains student names
        $status = $row[1];      // Second column contains attendance status (Present, Absent, etc.)
        // Insert into the database (adjust your database query as needed)
        $query = "INSERT INTO attendance (student_name, status, date) VALUES ('$student_name', '$status', NOW())";
        // Execute your query here
    }
    echo "Attendance Imported Successfully!";
} else {
    echo "Please upload a valid Excel file.";
}
?>
