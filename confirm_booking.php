<?php
session_start();
include('db.php'); // Include your database connection file

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $train_id = $_POST['train_id'];
    $departure_station = $_POST['departure_station'];
    $arrival_station = $_POST['arrival_station'];
    $travel_date = $_POST['travel_date'];
    $passenger_name = $_POST['passenger_name'];
    $passenger_age = $_POST['passenger_age'];
    $passenger_email = $_POST['passenger_email'];
    $seat_type = $_POST['seat_type'];
    $ticket_quantity = $_POST['ticket_quantity'];
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];

    // Prepare SQL statement to insert booking details
    $sql = "INSERT INTO bookings (train_id, departure_station, arrival_station, travel_date, passenger_name, passenger_age, passenger_email, seat_type, ticket_quantity, total_price, payment_method)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters and execute statement
        mysqli_stmt_bind_param($stmt, "issssissids", $train_id, $departure_station, $arrival_station, $travel_date, $passenger_name, $passenger_age, $passenger_email, $seat_type, $ticket_quantity, $total_price, $payment_method);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Booking confirmed successfully! Thank you, " . htmlspecialchars($passenger_name) . ".</p>";
        } else {
            echo "<p>Booking failed: " . mysqli_error($conn) . "</p>";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<p>Database error: " . mysqli_error($conn) . "</p>";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "<p>Invalid request.</p>";
}
?>
