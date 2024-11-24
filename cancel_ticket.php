<?php
session_start();
include('db.php'); // Include database connection

// Check if the cancel request has been submitted
if (isset($_GET['id'])) {
    $id = $_GET['id'];  // Change 'booking_id' to 'id'

    // SQL query to delete the booking from the database based on 'id'
    $delete_sql = "DELETE FROM bookings WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);  // Bind the parameter using 'id'
        if (mysqli_stmt_execute($stmt)) {
            $message = "Booking cancelled successfully.";
        } else {
            $message = "Error cancelling booking: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

// SQL query to fetch all bookings
$sql = "SELECT * FROM bookings";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 0.9em;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .cancel-btn {
            padding: 8px 12px;
            background-color: #FF6347;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .cancel-btn:hover {
            background-color: #FF4500;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            margin-top: 20px;
        }

        .message {
            color: green;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Booking History and Cancellation</h1>
    </header>

    <div class="container">
        <?php if (isset($message)) : ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result) > 0) : ?>
            <table>
                <tr>
                    <th>Train ID</th>
                    <th>Departure Station</th>
                    <th>Arrival Station</th>
                    <th>Travel Date</th>
                    <th>Passenger Name</th>
                    <th>Passenger Age</th>
                    <th>Seat Type</th>
                    <th>Ticket Quantity</th>
                    <th>Total Price</th>
                    <th>Payment Method</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['train_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['departure_station']); ?></td>
                        <td><?php echo htmlspecialchars($row['arrival_station']); ?></td>
                        <td><?php echo htmlspecialchars($row['travel_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['passenger_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['passenger_age']); ?></td>
                        <td><?php echo htmlspecialchars($row['seat_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['ticket_quantity']); ?></td>
                        <td>₹<?php echo htmlspecialchars($row['total_price']); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                        <td>
                            <!-- Updated 'href' with 'id' parameter -->
                            <a href="cancel_ticket.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="cancel-btn" onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else : ?>
            <p>No bookings found.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 Railway Reservation System. All Rights Reserved.</p>
    </footer>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
