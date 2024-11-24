<?php
// admin_login.php
include('config.php');
session_start();

// Handle login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists
    $sql = "SELECT * FROM admin_users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['username'] = $row['username'];
            header("Location: admin_dashboard.php");  // Redirect to the admin dashboard
        } else {
            $error_msg = "Incorrect password!";
        }
    } else {
        $error_msg = "No admin found with that username!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://cdn.pixabay.com/photo/2024/05/17/16/49/steam-8768615_640.jpg'); /* Add the background image URL here */
            background-size: cover;
            background-position: center center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        header {
            width: 100%;
            background-color: rgba(76, 175, 80, 0.8); /* Semi-transparent background for header */
            color: white;
            padding: 15px;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        form {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* White background with some transparency */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
            text-align: center;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<header>
    <h1>Admin Login</h1>
</header>

<form action="admin_login.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
</form>

<p>Don't have an account? <a href="admin_register.php">Register here</a></p>

<?php if (isset($error_msg)): ?>
    <p class="error"><?= $error_msg; ?></p>
<?php endif; ?>

</body>
</html>
