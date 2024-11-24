<?php
// view trains.php
include('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Trains - Train Reservation System</title>
    <style>
        /* General styling */
        body {
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
            background-color: #4CAF50;
            color: white;
            width: 100%;
            padding: 15px;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        main {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            text-align: center;
        }
        h2 {
            color: #4CAF50;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #eaf6e3;
        }
        .no-trains {
            padding: 20px;
            font-size: 18px;
            color: #777;
        }
    </style>
</head>
<body>

<header>
    <h1>Available Trains</h1>
</header>

<main>
    <h2>Train Schedule</h2>

    <!-- Displaying All Trains Table -->
    <?php
    $sql = "SELECT * FROM trains";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>Train Name</th>
                <th>Departure Location</th>
                <th>Arrival Location</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Price</th>
              </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['train_name']}</td>
                    <td>{$row['departure_location']}</td>
                    <td>{$row['arrival_location']}</td>
                    <td>{$row['departure_time']}</td>
                    <td>{$row['arrival_time']}</td>
                    <td>\${$row['price']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-trains'>No trains available at the moment.</p>";
    }
    ?>
</main>

</body>
</html>
