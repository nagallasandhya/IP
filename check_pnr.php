<?php
// Include database connection
include('db.php');  // Ensure this points to your actual database connection file

$errorMessage = "";
$pnrInfo = null;

// Check if PNR form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pnr_number = $_POST['pnr_number'];

    // Sanitize the input PNR
    $pnr_number = mysqli_real_escape_string($conn, $pnr_number);

    // Prepare SQL query to fetch PNR details
    $sql = "SELECT * FROM pnr WHERE pnr_number = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameter and execute the statement
    mysqli_stmt_bind_param($stmt, "s", $pnr_number);
    mysqli_stmt_execute($stmt);

    // Get result
    $result = mysqli_stmt_get_result($stmt);

    // Check if PNR exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch PNR details
        $pnrInfo = mysqli_fetch_assoc($result);
    } else {
        $errorMessage = "PNR number not found. Please try again.";
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check PNR Status</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: url('https://cdn.pixabay.com/photo/2024/05/17/16/49/steam-8768615_640.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        /* Main Container Styling */
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            max-width: 500px;
            width: 100%;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .page-heading {
            font-size: 24px;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        /* PNR Form Styling */
        .pnr-form {
            margin-bottom: 20px;
        }

        .pnr-form label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 6px;
            text-align: left;
        }

        .pnr-form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .pnr-form input[type="text"]:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 6px rgba(76, 175, 80, 0.3);
        }

        .pnr-form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .pnr-form button:hover {
            background-color: #45a049;
        }

        /* Error Message Styling */
        .error-message {
            color: #D8000C;
            background-color: #FFBABA;
            padding: 10px;
            margin-top: 20px;
            border-radius: 6px;
        }

        /* PNR Details Table */
        .pnr-details {
            margin-top: 20px;
        }

        .pnr-details h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }

        .pnr-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .pnr-details th,
        .pnr-details td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .pnr-details th {
            background-color: #f9f9f9;
            color: #4CAF50;
        }

        .pnr-details td {
            background-color: #fff;
        }

        /* Responsive Adjustments */
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            .page-heading {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="page-heading">Check PNR Status</h2>

        <!-- PNR Check Form -->
        <div class="pnr-form">
            <form action="check_pnr.php" method="POST">
                <label for="pnr_number">Enter PNR Number</label>
                <input type="text" name="pnr_number" id="pnr_number" required pattern="[A-Za-z0-9]{10}" placeholder="Enter your 10-digit PNR">
                <button type="submit">Check Status</button>
            </form>
        </div>

        <?php if ($errorMessage): ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php elseif ($pnrInfo): ?>
            <div class="pnr-details">
                <h3>PNR Details:</h3>
                <table>
                    <tr>
                        <th>PNR Number</th>
                        <td><?php echo htmlspecialchars($pnrInfo['pnr_number']); ?></td>
                    </tr>
                    <tr>
                        <th>Train Number</th>
                        <td><?php echo htmlspecialchars($pnrInfo['train_number']); ?></td>
                    </tr>
                    <tr>
                        <th>Journey Date</th>
                        <td><?php echo htmlspecialchars($pnrInfo['journey_date']); ?></td>
                    </tr>
                    <tr>
                        <th>Booking Status</th>
                        <td><?php echo htmlspecialchars($pnrInfo['status']); ?></td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
