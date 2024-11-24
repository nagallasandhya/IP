<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Railway Reservation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="dashboard-header">
        <h1>Welcome, <?php echo $_SESSION['user']; ?>!</h1>
    </header>

    <div class="dashboard-container">
        <div class="dashboard-card">
            <h3>Book a Ticket</h3>
            <p>Reserve your train tickets with ease.</p>
            <a href="book_ticket.php" class="btn">Book Now</a>
        </div>

        <div class="dashboard-card">
            <h3>Check PNR Status</h3>
            <p>Track your booking status using your PNR number.</p>
            <a href="check_pnr.php" class="btn">Check Status</a>
        </div>

        <div class="dashboard-card">
            <h3>Booking History</h3>
            <p>View your past ticket reservations.</p>
            <a href="booking_history.php" class="btn">View History</a>
        </div>

        <div class="dashboard-card">
            <h3>Account Settings</h3>
            <p>Update your personal information and preferences.</p>
            <a href="account_settings.php" class="btn">Manage Account</a>
        </div>

        <div class="dashboard-card">
            <h3>Cancel Ticket</h3>
            <p>Cancel any of your reserved tickets.</p>
            <a href="cancel_ticket.php" class="btn">Cancel Ticket</a>
        </div>
    </div>

    <footer class="dashboard-footer">
        <p>&copy; 2024 Railway Reservation System. All Rights Reserved.</p>
    </footer>
</body>
</html>
