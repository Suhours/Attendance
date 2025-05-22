<?php
session_start();
require_once('classes/actions.class.php');
$actionClass = new Actions();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Call login function
    if ($actionClass->login($username, $password)) {
        header("Location: index.php"); // Redirect on success
        exit;
    } else {
        header("Location: login.php"); // Redirect back to login on failure
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once('inc/header.php'); ?>
<head>
    
    <style>
        /* Add background image to the body */
        body {
            background-image: url('images/background.jpg'); /* Replace with the correct path */
            background-size: cover; /* Ensures the image covers the entire viewport */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-position: center; /* Centers the image */
            height: 100vh; /* Ensures the height matches the viewport */
            margin: 0; /* Removes default margins */
            font-family: Arial, sans-serif;
        }

        /* Style the login container */
        .container-md {
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
        }

        h2 {
            text-align: center;
        }

        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
<?php include_once('inc/navigation.php'); ?>
<div class="container-md py-3">
    <h2>Login</h2>
    <?php if (isset($_SESSION['flashdata'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['flashdata']['type'], ENT_QUOTES, 'UTF-8') ?>">
            <?= htmlspecialchars($_SESSION['flashdata']['msg'], ENT_QUOTES, 'UTF-8') ?>
        </div>
        <?php unset($_SESSION['flashdata']); ?>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <div class="footer">
            &copy; 2025 Nugaal University
        </div>
</div>
<?php include_once('inc/footer.php'); ?>
</body>
</html>
