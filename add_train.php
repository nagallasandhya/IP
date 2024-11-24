<?php
// add_train.php
include('config.php');  // Ensure you have your database connection here
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch cities for dropdowns
$sql_cities = "SELECT city_id, city_name FROM cities";
$result_cities = $conn->query($sql_cities);

// Fetch train names for dropdown
$sql_trains = "SELECT train_name_id, train_name FROM train_names";
$result_trains = $conn->query($sql_trains);

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all required fields are set and not empty
    if (isset($_POST['train_name'], $_POST['departure_location'], $_POST['arrival_location'], $_POST['departure_time'], $_POST['arrival_time'], $_POST['price'])) {
        // Collect and sanitize train data from the form
        $train_name = mysqli_real_escape_string($conn, $_POST['train_name']);
        $departure_location = mysqli_real_escape_string($conn, $_POST['departure_location']);
        $arrival_location = mysqli_real_escape_string($conn, $_POST['arrival_location']);
        $departure_time = mysqli_real_escape_string($conn, $_POST['departure_time']);
        $arrival_time = mysqli_real_escape_string($conn, $_POST['arrival_time']);
        $price = (float)$_POST['price'];

        // Validate if fields are not empty
        if (empty($train_name) || empty($departure_location) || empty($arrival_location) || empty($departure_time) || empty($arrival_time) || empty($price)) {
            echo "All fields are required!";
        } else {
            // Insert train data into the database
            $sql = "INSERT INTO train (train_name_id, departure_location, arrival_location, departure_time, arrival_time, price) 
                    VALUES ('$train_name', '$departure_location', '$arrival_location', '$departure_time', '$arrival_time', '$price')";

            // Execute the query and check if it was successful
            if ($conn->query($sql) === TRUE) {
                // Get the auto-generated train_id
                $train_id = $conn->insert_id;
                echo "New train added successfully! Train ID: " . $train_id;
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Train</title>
    <style>
        /* Styling for form and page */
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
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        form {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
            text-align: center;
        }
        input[type="text"], input[type="datetime-local"], input[type="number"], select, input[type="submit"] {
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
    </style>
</head>
<body>

<header>
    <h1>Add Train</h1>
</header>

<form action="add_train.php" method="POST">
    <!-- Train Name Dropdown -->
    <select name="train_name" required>
        <option value="">Select Train Name</option>
        <?php
        // Generate dropdown options dynamically from the train_names table
        if ($result_trains->num_rows > 0) {
            while ($train = $result_trains->fetch_assoc()) {
                echo '<option value="' . $train['train_name_id'] . '">' . $train['train_name'] . '</option>';
            }
        } else {
            echo '<option value="">No train names available</option>';
        }
        ?>
    </select>

    <!-- Departure Location Dropdown -->
    <select name="departure_location" required>
        <option value="">Select Departure Location</option>
        <?php
        // Generate dropdown options dynamically from the cities table
        if ($result_cities->num_rows > 0) {
            while ($city = $result_cities->fetch_assoc()) {
                echo '<option value="' . $city['city_id'] . '">' . $city['city_name'] . '</option>';
            }
        } else {
            echo '<option value="">No cities available</option>';
        }
        ?>
    </select>
    
    <!-- Arrival Location Dropdown -->
    <select name="arrival_location" required>
        <option value="">Select Arrival Location</option>
        <?php
        // Reset the result pointer to the start for the second dropdown
        $result_cities->data_seek(0);
        
        // Generate dropdown options dynamically for the arrival location
        if ($result_cities->num_rows > 0) {
            while ($city = $result_cities->fetch_assoc()) {
                echo '<option value="' . $city['city_id'] . '">' . $city['city_name'] . '</option>';
            }
        } else {
            echo '<option value="">No cities available</option>';
        }
        ?>
    </select>
    
    <input type="datetime-local" name="departure_time" placeholder="Departure Time" required>
    <input type="datetime-local" name="arrival_time" placeholder="Arrival Time" required>
    <input type="number" name="price" placeholder="Price per Ticket" required>
    <input type="submit" value="Add Train">
</form>

</body>
</html>
