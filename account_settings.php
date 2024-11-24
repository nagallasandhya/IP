<?php
// Start session to check if the user is logged in
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include('db.php');

// Initialize error messages and success message
$errorMessage = "";
$successMessage = "";

// Get the current user's username
$username = $_SESSION['username'];

// Fetch current user data from the database (table name: users_1)
$sql = "SELECT * FROM users_1 WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$userData = mysqli_fetch_assoc($result);

// Update user information when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password != $confirm_password) {
        $errorMessage = "Passwords do not match.";
    } else {
        // Update the user information in the database
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT); // Hash the password

        // Update the user's details
        $update_sql = "UPDATE users_1 SET name = ?, email = ?, password = ? WHERE username = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "ssss", $new_name, $new_email, $new_password_hashed, $username);

        if (mysqli_stmt_execute($update_stmt)) {
            $successMessage = "Account details updated successfully.";
        } else {
            $errorMessage = "Failed to update account details.";
        }

        // Close the statement
        mysqli_stmt_close($update_stmt);
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('https://cdn.pixabay.com/photo/2024/05/17/16/49/steam-8768615_640.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            max-width: 500px;
            width: 100%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .page-heading {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .error-message, .success-message {
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .error-message {
            background-color: #FFBABA;
            color: #D8000C;
        }

        .success-message {
            background-color: #DFF2BF;
            color: #4F8A10;
        }

        .settings-form label {
            display: block;
            font-size: 14px;
            color: #555;
            margin-bottom: 6px;
        }

        .settings-form input[type="text"],
        .settings-form input[type="email"],
        .settings-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .settings-form input:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 6px rgba(76, 175, 80, 0.3);
        }

        .settings-form button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .settings-form button:hover {
            background-color: #45a049;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            .page-heading {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="page-heading">Account Settings</h2>

        <!-- Success or Error Message -->
        <?php if ($errorMessage): ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php elseif ($successMessage): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <!-- Account Settings Form -->
        <div class="settings-form">
            <form action="account_settings.php" method="POST">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($userData['name']); ?>" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>

                <label for="password">New Password</label>
                <input type="password" name="password" id="password" required>

                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
