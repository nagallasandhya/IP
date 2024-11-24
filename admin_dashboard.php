<?php
// admin_dashboard.php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
        .navbar {
            display: flex;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background for navbar */
            width: 100%;
        }
        .navbar a {
            padding: 14px 20px;
            display: block;
            color: white;
            text-align: center;
            text-decoration: none;
            background-color: #333;
        }
        .navbar a:hover {
            background-color: #575757;
        }
        .dashboard {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* White background with some transparency */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
            text-align: center;
        }
        .logout {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 4px;
    cursor: pointer;
    text-align: center;
    display: flex;
    align-items: flex-end;  /* Align text to the bottom */
    justify-content: center; /* Center text horizontally */
    width: 100%; /* Stretch across the width */
    margin-top: 20px; /* Space above the button */
}

        .logout:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome, Admin</h1>
</header>

<!-- Navigation Bar -->
<div class="navbar">
    <a href="add_train.php">Add Train</a>
    <a href="view_trains.php">View Trains</a>

    <a href="booking_history.php">Manage Bookings</a>
</div>

<!-- Dashboard Content -->
<div class="dashboard">
    <h2>Admin Dashboard</h2>
    <p>Welcome to the admin dashboard. You can manage users, view bookings, and perform other administrative tasks.</p>
    <a href="logout.php" class="logout">Logout</a>
</div>

</body>
</html>
