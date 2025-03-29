<?php
session_start();
require 'db.php'; // Ensure database connection is included

if (!isset($_SESSION['id'])) {
    die("Error: User not logged in.");
}

$bid = $_SESSION['id']; // Buyer ID from session

// Fix: Ensure correct column name in ORDER BY
$sql = "SELECT * FROM transaction WHERE bid = '$bid' ORDER BY tid DESC LIMIT 1"; // Change txn_id if needed

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("No recent transactions found.");
}

$order = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Bill</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .bill-container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background: #f9f9f9; }
        h2 { text-align: center; }
        .details { margin-bottom: 15px; }
        .details p { margin: 5px 0; }
        .print-btn { display: block; width: 100%; text-align: center; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; margin-top: 15px; }
        .print-btn:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="bill-container">
    <h2>Order Bill</h2>
    <div class="details">
        <p><strong>Name:</strong> <?= htmlspecialchars($order['name']); ?></p>
        <p><strong>City:</strong> <?= htmlspecialchars($order['city']); ?></p>
        <p><strong>Mobile:</strong> <?= htmlspecialchars($order['mobile']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($order['email']); ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($order['addr']); ?></p>
        <p><strong>Pincode:</strong> <?= htmlspecialchars($order['pincode']); ?></p>
        <p><strong>Transaction ID:</strong> <?= htmlspecialchars($order['tid']); ?></p> <!-- Fix -->
        <p><strong>Product ID:</strong> <?= htmlspecialchars($order['pid']); ?></p>
    </div>

    <button class="print-btn" onclick="window.print()">Print Bill</button>
</div>

</body>
</html>
