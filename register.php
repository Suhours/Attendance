<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    // Redirect if the user is not an admin
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Register New User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .alert {
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <!-- Flash message display -->
        <?php if (isset($_SESSION['flashdata'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['flashdata']['type']) ?>">
                <?= htmlspecialchars($_SESSION['flashdata']['msg']) ?>
            </div>
            <?php unset($_SESSION['flashdata']); ?>
        <?php endif; ?>

        <div class="card shadow-lg p-4">
            <div class="card-header">
                Register New User
            </div>
            <div class="card-body">
                <form action="register_user.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" id="username" name="username" class="form-control form-control-sm" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control form-control-sm" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">Register User</button>
                    </div>
                </form>

                <!-- Optional: Add a link back to the homepage -->
                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-secondary btn-sm">Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
