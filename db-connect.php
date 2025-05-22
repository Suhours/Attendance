<?php 
// // Hostname
// $host = "localhost";
// // Username
// $uname = "root";
// // Password
// $pw = "";
// // Database Name
// $dbname = "attendance_db";

// try{
//     $conn = new MySQLi($host, $uname, $pw, $dbname);
// }catch(Exception $e){
//     echo "Database Connection Failed: <br>";
//     print_r($e->getMessage());
//     exit;
// }

// Hostname
$host = "localhost";
// Username
$uname = "root";
// Password
$pw = "";
// Database Name
$dbname = "nugaal-db";

// Establish a connection
$conn = new mysqli($host, $uname, $pw, $dbname);

// Check connection
if ($conn->connect_error) {
    // Connection failed, display an error message
    die("Database Connection Failed: " . $conn->connect_error);
}


?>