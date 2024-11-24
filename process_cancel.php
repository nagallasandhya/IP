<?php
include('db.php'); // Include database connection

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Prepare SQL statement to delete the booking
    $sql = "DELETE FROM bookings WHERE booking_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Success";
        } else {
            echo "Error";
        }
        mysqli_stmt_close($stmt);
    }
} else {
    echo "Invalid booking ID.";
}

// Close the database connection
mysqli_close($conn);
?>
