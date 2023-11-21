<?php
session_start();

// Function to display the transaction list
function displayTransactionList($savedCarts) {
    echo "<h2>Transaction List</h2>";
    
    if (empty($savedCarts)) {
        echo "No transactions available.";
    } else {
        echo "<table border='1'>
            <tr>
                <th>Transaction ID</th>
                <th>Customer ID</th>
                <th>Seller ID</th>
                <th>Transaction Date</th>
            </tr>";

        foreach ($savedCarts as $transactionId => $cart) {
            // Assume transaction details are retrieved from a database or other source
            // For simplicity, using placeholder values
            $customerId = '123'; // Replace with actual customer ID
            $sellerId = '456'; // Replace with actual seller ID
            $transactionDate = date('Y-m-d H:i:s'); // Replace with actual transaction date

            echo "<tr>
                <td>$transactionId</td>
                <td>$customerId</td>
                <td>$sellerId</td>
                <td>$transactionDate</td>
            </tr>";
        }

        echo "</table>";
    }
}

if (!isset($_SESSION['saved_carts'])) {
    $_SESSION['saved_carts'] = array();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction List</title>
    <style>
        /* Add your styles here */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div>
        <a href="index.php">Back to Store</a>
    </div>
    <div>
        <?php displayTransactionList($_SESSION['saved_carts']); ?>
    </div>
</body>
</html>