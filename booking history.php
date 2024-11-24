<?php
// booking history.php
include('config.php');
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all booking history
$sql = "SELECT b.booking_id, b.booking_date, b.status, b.total_price, u.username, t.train_name 
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN trains t ON b.train_id = t.train_id
        ORDER BY b.booking_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking History</title>
    <style>
        bbody {
    font-family: Arial, sans-serif;
    background-image: url('https://cdn.pixabay.com/photo/2024/05/17/16/49/steam-8768615_640.jpg'); /* Replace with your image URL */
    background-size: cover;
    background-position: center center;
    background-attachment: fixed; /* This ensures the background stays in place during scrolling */
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
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        table {
            width: 80%;
            margin-top: 40px;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            background-color: #fff;
        }
        .btn {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<header>
    <h1>Booking History</h1>
</header>

<?php
// Check if there are any bookings
if ($result->num_rows > 0) {
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Booking ID</th>';
    echo '<th>Username</th>';
    echo '<th>Train Name</th>';
    echo '<th>Booking Date</th>';
    echo '<th>Status</th>';
    echo '<th>Total Price</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Loop through and display booking details
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['booking_id'] . '</td>';
        echo '<td>' . $row['username'] . '</td>';
        echo '<td>' . $row['train_name'] . '</td>';
        echo '<td>' . date('Y-m-d H:i', strtotime($row['booking_date'])) . '</td>';
        echo '<td>' . $row['status'] . '</td>';
        echo '<td>' . '$' . number_format($row['total_price'], 2) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>No booking history found.</p>';
}
?>

</body>
</html>
