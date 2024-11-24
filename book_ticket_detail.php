<?php
// Get the parameters from the URL
$train_id = $_GET['train_id'];
$departure_station = $_GET['departure_station'];
$arrival_station = $_GET['arrival_station'];
$travel_date = $_GET['travel_date'];

// Define base prices for each seat type (example prices, adjust as needed)
$seat_prices = [
    "Sleeper" => 500,
    "AC" => 1000,
    "First Class" => 1500,
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
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
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            font-size: 1.1em;
            margin: 5px 0;
        }

        .form-group {
            margin: 15px 0;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .form-group button {
            padding: 10px 20px;
            background-color: #4CAF50; /* Green background */
            color: white;
            font-size: 1.1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            margin-top: 20px;
        }
    </style>
    <script>
        function updateTotalPrice() {
            const seatType = document.getElementById("seat_type").value;
            const ticketQuantity = document.getElementById("ticket_quantity").value;
            const prices = {
                "Sleeper": 500,
                "AC": 1000,
                "First Class": 1500
            };
            const totalPrice = prices[seatType] * ticketQuantity;
            document.getElementById("total_price").value = totalPrice;
            document.getElementById("display_price").innerText = totalPrice;
        }
    </script>
</head>
<body>
    <header>
        <h1>Train Booking Details</h1>
    </header>

    <div class="container">
        <div class="details">
            <p><strong>Train ID:</strong> <?php echo htmlspecialchars($train_id); ?></p>
            <p><strong>Departure Station:</strong> <?php echo htmlspecialchars($departure_station); ?></p>
            <p><strong>Arrival Station:</strong> <?php echo htmlspecialchars($arrival_station); ?></p>
            <p><strong>Travel Date:</strong> <?php echo htmlspecialchars($travel_date); ?></p>
        </div>

        <form action="confirm_booking.php" method="POST">
            <!-- Hidden fields to pass essential information -->
            <input type="hidden" name="train_id" value="<?php echo htmlspecialchars($train_id); ?>">
            <input type="hidden" name="departure_station" value="<?php echo htmlspecialchars($departure_station); ?>">
            <input type="hidden" name="arrival_station" value="<?php echo htmlspecialchars($arrival_station); ?>">
            <input type="hidden" name="travel_date" value="<?php echo htmlspecialchars($travel_date); ?>">

            <div class="form-group">
                <label for="passenger_name">Passenger Name</label>
                <input type="text" id="passenger_name" name="passenger_name" required>
            </div>

            <div class="form-group">
                <label for="passenger_age">Passenger Age</label>
                <input type="number" id="passenger_age" name="passenger_age" required>
            </div>

            <div class="form-group">
                <label for="passenger_email">Passenger Email</label>
                <input type="email" id="passenger_email" name="passenger_email" required>
            </div>

            <div class="form-group">
                <label for="seat_type">Seat Type</label>
                <select id="seat_type" name="seat_type" required onchange="updateTotalPrice()">
                    <option value="">Select Seat Type</option>
                    <option value="Sleeper">Sleeper</option>
                    <option value="AC">AC</option>
                    <option value="First Class">First Class</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ticket_quantity">Ticket Quantity</label>
                <input type="number" id="ticket_quantity" name="ticket_quantity" min="1" value="1" required onchange="updateTotalPrice()">
            </div>

            <div class="form-group">
                <label for="total_price">Total Price: ₹<span id="display_price">0</span></label>
                <input type="hidden" id="total_price" name="total_price" value="0">
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="UPI">UPI</option>
                    <option value="Cash on Delivery">Cash on Delivery</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Confirm Booking</button>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Railway Reservation System. All Rights Reserved.</p>
    </footer>
</body>
</html>
