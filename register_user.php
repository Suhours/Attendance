<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    // Redirect if the user is not an admin
    header("Location: index.php");
    exit();
}

require_once('db-connect.php');  // Ensure the DB connection is included

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form input values
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // Get the raw password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password

    // Check if the username already exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['flashdata'] = ['type' => 'error', 'msg' => 'Username already exists.'];
        header("Location: register.php");
        exit();
    } else {
        // Insert the new user into the database (setting is_admin = 0 by default)
        $is_admin = 0;

        $insert_sql = "INSERT INTO users (username, password, is_admin) VALUES ('$username', '$hashed_password', '$is_admin')";
        if ($conn->query($insert_sql) === TRUE) {
            $_SESSION['flashdata'] = ['type' => 'success', 'msg' => 'User registered successfully.'];
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['flashdata'] = ['type' => 'error', 'msg' => 'Error: ' . $conn->error];
            header("Location: register.php");
            exit();
        }
    }
}

$conn->close();  // Close the DB connection
?>
