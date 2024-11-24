<?php
session_start();
// Initialize variables for search results
$trainResults = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get search parameters from form
    $departure_station = $_POST['departure_station'];
    $arrival_station = $_POST['arrival_station'];
    $travel_date = $_POST['travel_date'];

    // Simulating train search results (no database connection)
    $trainResults = [
        ['train_id' => 1, 'train_name' => 'Express 101', 'train_number' => '101', 'departure_station' => $departure_station, 'arrival_station' => $arrival_station, 'departure_time' => '10:00 AM', 'arrival_time' => '2:00 PM', 'travel_date' => $travel_date],
        ['train_id' => 2, 'train_name' => 'SuperFast 202', 'train_number' => '202', 'departure_station' => $departure_station, 'arrival_station' => $arrival_station, 'departure_time' => '11:00 AM', 'arrival_time' => '3:00 PM', 'travel_date' => $travel_date]
    ];

    // Simulating a no result message if no trains are found
    if (empty($trainResults)) {
        $message = "No trains found for the selected route and date.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Train Ticket</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling for the Book button */
        .book-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50; /* Green background */
            color: white;
            text-align: center;
            text-decoration: none; /* Remove underline */
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .book-btn:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <header class="dashboard-header">
        <h1>Book a Train Ticket</h1>
    </header>

    <div class="form-container">
        <form action="book_ticket.php" method="POST">
            <label for="departure_station">Departure Station</label>
            <select id="departure_station" name="departure_station" required>
                <option value="">Select Departure Station</option>
                <option value="Mumbai">Mumbai</option>
                <option value="Delhi">Delhi</option>
                <option value="Bengaluru">Bengaluru</option>
                <option value="Hyderabad">Hyderabad</option>
                <option value="Ahmedabad">Ahmedabad</option>
                <option value="Chennai">Chennai</option>
                <option value="Kolkata">Kolkata</option>
                <option value="Pune">Pune</option>
                <option value="Jaipur">Jaipur</option>
                <option value="Surat">Surat</option>
            </select>

            <label for="arrival_station">Arrival Station</label>
            <select id="arrival_station" name="arrival_station" required>
                <option value="">Select Arrival Station</option>
                <option value="Mumbai">Mumbai</option>
                <option value="Delhi">Delhi</option>
                <option value="Bengaluru">Bengaluru</option>
                <option value="Hyderabad">Hyderabad</option>
                <option value="Ahmedabad">Ahmedabad</option>
                <option value="Chennai">Chennai</option>
                <option value="Kolkata">Kolkata</option>
                <option value="Pune">Pune</option>
                <option value="Jaipur">Jaipur</option>
                <option value="Surat">Surat</option>
            </select>

            <label for="travel_date">Travel Date</label>
            <input type="date" id="travel_date" name="travel_date" required>

            <button type="submit" name="search">Search Trains</button>
        </form>
    </div>

    <?php if (!empty($trainResults)) : ?>
        <div class="results-container">
            <h2>Available Trains</h2>
            <table>
                <tr>
                    <th>Train Name</th>
                    <th>Train Number</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Action</th> <!-- Added column for action (book button) -->
                </tr>
                <?php foreach ($trainResults as $train) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($train['train_name']); ?></td>
                        <td><?php echo htmlspecialchars($train['train_number']); ?></td>
                        <td><?php echo htmlspecialchars($train['departure_station']); ?></td>
                        <td><?php echo htmlspecialchars($train['arrival_station']); ?></td>
                        <td><?php echo htmlspecialchars($train['departure_time']); ?></td>
                        <td><?php echo htmlspecialchars($train['arrival_time']); ?></td>
                        <td>
                            <!-- Book Button with simple redirection -->
                            <a href="book_ticket_detail.php?train_id=<?php echo htmlspecialchars($train['train_id']); ?>&departure_station=<?php echo urlencode($train['departure_station']); ?>&arrival_station=<?php echo urlencode($train['arrival_station']); ?>&travel_date=<?php echo urlencode($train['travel_date']); ?>" class="book-btn">Book</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php elseif (isset($message)) : ?>
        <p class="no-results"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <footer class="dashboard-footer">
        <p>&copy; 2024 Railway Reservation System. All Rights Reserved.</p>
    </footer>
</body>
</html>
